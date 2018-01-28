# Crew United WP

This plugin adds a shortcode to your WordPress blog that allows you to embed parts of your public Crew United profile. It makes use if the profile XML the Crew United site creates. You can find the URL of your profile XML in the sidebar of your Crew United profile.

## Contents

The WordPress Plugin Crew United WP includes the following files:

* `.gitignore`. Used to exclude certain files from the repository.
* `README.md`. The file that you’re currently reading.
* The `wp-crewunited` directory that contains the plugin's source code - a fully executable WordPress plugin.

# Features

The current version of the Crew United WP shortcode embeds the following content in your site:

* Projects as [department]
    * all your projects you participated in this department
    * following infos per project are displayed
        * __year__ of participation
        * __title__ of the production (can be the working title)
        * __movie type__
        * __head of__ head of the department/director

The rendered HTML structure is as follows, so you can use styles for the class `cuwp-box`and its child elements.

```html
<div class="cuwp-box">

    <!-- Begin Department Navigation (optional), set 'deptNav="true"' -->
    <nav>
        <a href="#department">...</a>
    </nav>
    <!-- End Department Navigation -->

    <!-- Begin Repeat per Department -->
    <h3>{Department}</h3>
    <table>
        <thead>
            <tr>
                <td>...</td>
                ...
            </tr>
        </thead>
        <tbody>
            <tr>
                <!-- one row per project, limit rows by setting 'maxProfiles="n"' -->
                <td>...</td>
                ...
            </tr>
        </tbody>
    </table>
    <!-- End Repeat -->

    <!-- Begin Profile Link (optional), set 'profileLink="true"' -->
    <p class="profile-link">Visit my profile on <a href="...">Crew United</a></p>
    <!-- End Profile Link -->

</div>
```

## Installation

Just copy the folder `wp-crewunited`to your WordPress plugin directory, probably unter `~/wp-content/plugins/`. After that go to the admin site of your WordPress installation and activate the plugin. That's all, now you can use the new shortcode.

## Usage

Place the following shortcode in the editor or text widget:

`[cuwp src="<URL of profile XML>"]`

### Options

* `src` (__required__): the URL to your Crew United profile XML, e.g. `src="http://xml.crew-united.com/Profilansichten/XmlGenerator.asp?get=xxxxxxxxxxxx"`

* `maxProjects` (optional): if this value is greater than 0, the amount of projects displayed per department is limited to this value, e.g. `maxProjects="10"`

* `deptNav` (optional): adds a navigation to your departments, e.g. `deptNav="true"`

* `profileLink` (optional): displays a link to your profile on Crew United if set to _true_, e.g. `profileLink="false"`


## Contact

If you find any bugs or have ideas for improvement (there should be a whole lot) please [let me know](http://tbmsu.com/kontakt/).