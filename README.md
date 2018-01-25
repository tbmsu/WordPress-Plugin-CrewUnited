# Crew United WP

This plugin adds a shortcode to your Wordpress blog that allows you to embed parts of your public Crew United profile. It makes use if the profile XML the Crew United site creates. You can find the URL of your profile XML in the sidebar of your Crew United profile.

## Contents

The WordPress Plugin Crew United WP includes the following files:

* `.gitignore`. Used to exclude certain files from the repository.
* `README.md`. The file that you’re currently reading.
* The `wp-crewunited` directory that contains the plugin's source code - a fully executable WordPress plugin.

# Features

The current version of the Crew United WP shortcode embeds the following content in your site:

* Projects as [department]
** all your projects you participated in this department
** following infos per project are displayed
*** *year* of participation
*** *title* of the production (can be the working title)
*** *movie type*
*** *head of* head of the department/director

The rendered HTML structure is as follows, so you can use a style for class `cuwp-box`and its child elements.

```html
<div class="cuwp-box">
    <h3>{Department}</h3>
    <table>
        <thead>
            <tr>
                <td>`...`</td>
                `...`
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>`...`</td>
                `...`
            </tr>
        </tbody>
    </table>
</div>
```

## Installation

Just copy the folder `wp-creunited`to your WordPress plugin directory, probably unter `wp-content/plugins/`. After that go to the admin site of your WordPress installation and activate the plugin. That's all, now you can use the new shortcode.

## Usage

Place the following shortcode in the editor or text widget:

`[cuwp src="<URL of profile XML"]`

### Options

So far, the shortcode takes only one option.

`src` (required): the URL to your Crew United profile XML, e.g. http://xml.crew-united.com/Profilansichten/XmlGenerator.asp?get=xxxxxxxxxxxx

## Contact

If you find any bugs or have ideas for improvement (there should be a whole lot) please [let me know](http://tbmsu.com/kontakt/).