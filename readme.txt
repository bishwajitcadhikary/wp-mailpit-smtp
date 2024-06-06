=== MailPit SMTP ===
Contributors: bishwajitcadhikary
Donate link: https://www.buymeacoffee.com/bishwajitca
Tags: smtp, mail, email, mailpit, mailgun
Requires at least: 4.6
Tested up to: 6.4.2
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires PHP: 5.6

A simple plugin to test SMTP settings and override the default WordPress mail system.

== Description ==
SMTP Test & Override is a powerful yet simple WordPress plugin designed to ensure reliable email delivery by allowing users to test SMTP settings directly within their WordPress dashboard. Say goodbye to the uncertainties of email delivery and hello to peace of mind with this essential tool for WordPress site owners.

== Installation ==

1. Upload the `mailpit-smtp` folder to the `/wp-content/plugins/` directory or install it through the WordPress plugin installer.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Configuration ==

1. Navigate to 'MailPit SMTP' in your WordPress dashboard.
2. Enter your SMTP host and port.
4. Click the "Save Changes" button to save your SMTP settings.

== Usage ==

1. After configuring the SMTP settings, you can use the `wp_mail` function in your WordPress code to send emails via SMTP.
2. To test your SMTP configuration, go to the 'MailPit SMTP Settings' page and use the "Send Test Email" feature.

== Frequently Asked Questions ==

#### How to install MailPit Server?
Refer to the [MailPit Server installation guide](https://mailpit.axllent.org/docs/install/).

### How do I configure the SMTP settings? ###
Navigate to 'Settings' -> 'MailPit SMTP' and enter your SMTP host and port.

### Can I use authentication with SMTP? ###
Yes, you can configure SMTP authentication on the settings page.


== Changelog ==

1.0.2 - Jun 07, 2024
- Fix some minor bugs

1.0.1 - Jan 20, 2024
- Update the readme file

1.0 - Oct 3, 2023
- Initial release.

== Support ==

If you encounter any issues or have questions, please visit the [support forum](https://wordpress.org/support/plugin/mailpit-smtp).

== Contribute ==

If you'd like to contribute to the development of this plugin, you can find it on [GitHub](https://github.com/bishwajitcadhikary/wp-mailpit-smtp).

== License ==

This plugin is released under the [GNU General Public License, Version 2](https://www.gnu.org/licenses/gpl-2.0.html).

== Credits ==

None yet.

== Upgrade Notice ==

None yet.