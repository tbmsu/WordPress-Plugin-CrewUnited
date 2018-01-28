<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/tbmsu/wp-crewunited
 * @since      1.0.0
 *
 * @package    wp-crewunited
 * @subpackage wp-crewunited/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    wp-crewunited
 * @subpackage wp-crewunited/public
 * @author     tbmsu
 */
class WP_CrewUnited_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

    }
    
    /**
	 * Register the shortcode [cuwp] to display the Crew United profile.
	 *
	 * @since    1.0.0
	 */
    function cuwp_shortcodes_init() {
		
		/**
		 * Function handler that is called when the shotcode is excecuted.
		 */
        function cuwp_shortcode($atts = [], $content = null, $tag = '') {

			if (is_admin()) return;

			/**
			 * Helper function that is responsible for loading and parsing the XML.
			 */
			function loadParseCrewXml( $src, $maxProjects, $deptNav, $showProfileLink ) {

				function helperGetCrewProfileLink($xml) {
					return $xml->MemberProfile->Contacts->CrewUnitedLink->English;
				}

				function helperGetDepartment($pBlock) {
					return $pBlock->Department->NameEnglish;
				}

				function helperGetHeadOfHeader($pBlock) {
					$out = 'Director';
					if (
						strpos($pBlock->Department->NameEnglish, 'camera') !== false
						|| strpos($pBlock->Department->NameEnglish, 'DIT') !== false) {
						$out .= ' of Photography';
					}
					return $out;
				}

				function helperGetTitle($project) {
					if($project->ProjectTitle->InternationalTitle != '')
						return $project->ProjectTitle->InternationalTitle;
					else if($project->ProjectTitle->OfficialTitleGerman != '')
						return $project->ProjectTitle->OfficialTitleGerman;
					else 
						return $project->ProjectTitle->WorkingTitle;
				}

				function helperGetType($project) {
					return $project->ProjectType->NameEnglish;
				}

				function helperGetHeadOf($project) {
					return $project->SelectedHeadOf->FirstName 
						. ' ' 
						. $project->SelectedHeadOf->LastName;
				}

				function helperGetComment($project) {
					return $project->Note; 
				}

				if ('' == $src) return 'no source provided, can\'t load anything...';
		
				$xml = simplexml_load_file($src) or die("Error: Cannot create XML object from source");

				/**
				 * Departments (Project Blocks)
				 */
				$pBlocks = [];
				$deptIndex = 0;
				foreach($xml->MemberProfile->Projects->children() as $pBlock) {

					$department = helperGetDepartment($pBlock[0]);
					array_push($pBlocks, $department);

					$out .= '<h3 id="cuwp-department-' . $deptIndex++ .'">' . $department . '</h3>';

					/**
					 * Projects within Project Block
					 */
					$out .= '<table>';
					$out .= '<thead>';
					$out .= '<tr>';
					$out .= '<th>Year</th>';
					$out .= '<th>Title</th>';
					$out .= '<th>Movie Type</th>';
					$out .= '<th>' . helperGetHeadOfHeader($pBlock[0]) . '</th>';
					$out .= '<th>Comment</th>';
					$out .= '</tr>';
					$out .= '</thead>';
					$out .= '<tbody>';
					$pCount = 0;
					foreach($pBlock[0]->SelectedProjects->children() as $project) { 
						$out .= '<tr>';
						$out .= '<td>' . $project[0]->ParticipationYear . '</td>';
						$out .= '<td>' . helperGetTitle($project[0]) . '</td>';
						$out .= '<td>' . helperGetType($project[0]) . '</td>';
						$out .= '<td>' . helperGetHeadOf($project[0]) . '</td>';
						$out .= '<td>' . helperGetComment($project[0]) . '</td>';
						$out .= '<tr>';
						if (0 < $maxProjects && ++$pCount == $maxProjects) break;
					}
					$out .= '</tbody>';
					$out .= '</table>';
				}
				
				if ($deptNav){
					$navOut = '<nav>';
					$deptIndex = 0;
					foreach($pBlocks as $pBlock) {
						$navOut .= '<a href="#cuwp-department-' . $deptIndex++ . '">' . $pBlock . '</a>';
					}

					$navOut .= '</nav>';

					$out = $navOut . $out;	
				}

				if ($showProfileLink) {
					$out .= '<p class="profile-link">' 
						. 'Visit my profile on <a href="'
						. helperGetCrewProfileLink($xml)
						. '" target="_blank">Crew United</a>' 
						. '</p>';
				}

				return $out;
			}

			/**
			 * From here on the output HTML is generated...
			 */

            // normalize attribute keys, lowercase
            $atts = array_change_key_case((array)$atts, CASE_LOWER);

            // override default attributes with user attributes
            $cuwp_atts = shortcode_atts([
                'title' => 'Crew United WP',
				'src' => '',
				'maxprojects' => 0,
				'deptnav' => 'false',
				'profilelink' => 'true'
			], $atts, $tag);
			
			$src = esc_html__($cuwp_atts['src'], 'cuwp');
			$maxProjects = intval(esc_html__($cuwp_atts['maxprojects'], 'cuwp'));
			$deptNav = esc_html__($cuwp_atts['deptnav'], 'cuwp') == 'true'
				? true
				: false;
			$showProfileLink = esc_html__($cuwp_atts['profilelink'], 'cuwp') == 'true'
				? true
				: false;

            $out = '';
            $out .= '<div class="cuwp-box">';
            $out .= loadParseCrewXml($src, $maxProjects, $deptNav, $showProfileLink);
			$out .= '</div>';
    
            // always return
            return $out;
		}

		if ( shortcode_exists( 'cuwp' ) ) {
			die("Crew United WP: The shortcode [cuwp] already exists. Please uninstall the plugin 'Crew United WP' :(");
		}

		add_shortcode('cuwp', 'cuwp_shortcode');
    }
}