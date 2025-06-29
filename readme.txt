=== Multilang Perelink ===
Contributors: plance
Tags: multisite, multilingual, language switcher, internal linking, network
Requires at least: 6.0
Tested up to: 6.8
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Multilang Perelink allows interlinking between translated versions of the same content across different subsites in a WordPress multisite network.

== Description ==

**Multilang Perelink** is a plugin designed for WordPress multisite installations where each subsite represents a version of the same site in a different language.

The plugin enables interlinking between translations of the same content across different subsites (languages) using a simple language switcher and admin UI.

### Main Features:

- Adds a language switcher via shortcode: `[multilang_perelink_languages]`
- Provides a settings page under **Settings > Multilang Perelink** for fine-tuned control.
- Allows enabling the language switcher for:
  - The front page
  - Public post types
  - Public taxonomies
- Adds a UI to connect related posts or terms across subsites for selected types.
- Enhances user navigation by seamlessly switching between localized content.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/multilang-perelink` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress (on the **network level**).
3. Go to **Settings > Multilang Perelink** to configure the plugin.
4. Use the shortcode `[multilang_perelink_languages]` where you want to display the language switcher (e.g., in templates or widgets).

== Frequently Asked Questions ==

= Does this plugin provide automatic translations? =  
No. It only manages relationships between content manually translated and placed across subsites.

= Can I use this plugin on a single-site installation? =  
No. Multilang Perelink is intended specifically for WordPress multisite mode.

= Where does the language switcher appear? =  
You can place it anywhere using the `[multilang_perelink_languages]` shortcode. It can also be auto-inserted on selected content types via the plugin settings.

== Screenshots ==

1. Plugin settings page where you can configure which content types support interlinking.
2. Dropdown field to select related content on another subsite.
3. Language switcher rendered on the frontend.


== Changelog ==

= 1.0.0 =
* Init release.