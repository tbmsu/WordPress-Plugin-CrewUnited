<?php
/**
 *
 * @link              https://github.com/tbmsu/wp-crewunited
 * @since             1.0.0
 * @package           Crew United WP
 *
 * @wordpress-plugin
 * Plugin Name:       Crew United WP
 * Plugin URI:        https://github.com/tbmsu/wp-crewunited
 * Description:       This plugin adds a shotcode that let's you include content of your Crew United profile.
 * Version:           1.0.0
 * Author:            tbmsu
 * Author URI:        http://tbmsu.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Crew United WP
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 */
define( 'WP_CREWUNITED_VERSION', '1.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-crewunited.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_crewunited() {
    $plugin = new WP_CrewUnited();
    $plugin->run();
}

run_wp_crewunited();

 
function WP_CrewUnited($atts) {
    extract(shortcode_atts(array(
        "src" => ''
    ), $atts));
    return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'"></iframe>';
}
 
add_shortcode("wpcu", "WP_CrewUnited");
 
?>