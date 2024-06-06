<?php
/**
 * MailPit SMTP
 *
 * @package           MailPit
 * @author            Bishwajit Adhikary
 * @copyright         2024 Bishwajit Adhikary
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       MailPit SMTP
 * Plugin URI:        https://wordpress.org/plugins/mailpit-smtp
 * Description:       A simple plugin to test SMTP settings and override the default WordPress mail system.
 * Version:           1.0.1
 * Requires at least: 5.3
 * Requires PHP:      7.4
 * Author:            Bishwajit Adhikary
 * Author URI:        https://github.com/bishwajitcadhikary
 * Text Domain:       mailpit-smtp
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Set default values for SMTP host and port
function mailpit_smtp_default_options() {
    add_option('mailpit_smtp_host', '127.0.0.1');
    add_option('mailpit_smtp_port', '1025');
}

function mailpit_smtp_settings_menu() {
    // Define the URL of the custom icon
    $icon_url = plugin_dir_url(__FILE__) . 'mailpit.svg';

    add_menu_page(
        'MailPit SMTP Settings',
        'MailPit SMTP',
        'manage_options',
        'mailpit-smtp-settings',
        'mailpit_smtp_settings_page',
        $icon_url // Specify the custom icon URL here
    );
}

// Display the SMTP settings page
function mailpit_smtp_settings_page() {
    ?>
    <div class="wrap">
        <h2>MailPit SMTP Settings</h2>
        <form method="post" action="<?php echo esc_url(admin_url('options.php')); ?>">
            <?php
            settings_fields('mailpit-smtp-settings-group');
            do_settings_sections('mailpit-smtp-settings');
            submit_button();
            ?>
        </form>

        <h2>Test SMTP Email</h2>
        <form method="post" action="">
            <?php
            wp_nonce_field('mailpit_smtp_test_email', 'mailpit_smtp_nonce');
            ?>
            <table class="form-table" role="presentation">
                <tbody>
                <tr>
                    <th scope="row">
                        <label for="subject">Subject:</label>
                    </th>
                    <td>
                        <input type="text" id="subject" name="subject" value="Test Email" required>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="test_email">Test Email Address:</label>
                    </th>
                    <td>
                        <input type="email" id="test_email" name="test_email" value="<?php echo esc_attr(get_option('admin_email')); ?>" required>
                    </td>
                </tr>
                </tbody>
            </table>

            <p class="submit">
                <input type="submit" name="send_test_email" class="button-primary" value="Send Test Email">
            </p>
        </form>
        <?php
        if (isset($_POST['send_test_email'])) {
            // Verify nonce
            if (!isset($_POST['mailpit_smtp_nonce']) || !wp_verify_nonce($_POST['mailpit_smtp_nonce'], 'mailpit_smtp_test_email')) {
                wp_die('Security check');
            }

            $test_email = sanitize_email($_POST['test_email']);
            $subject = sanitize_text_field($_POST['subject']);
            $message = 'This is a test email sent from the MailPit SMTP Plugin for WordPress.';
            $result = wp_mail($test_email, $subject, $message);

            if ($result) { ?>
                <div class="updated"><p>Test email sent successfully to <?php echo esc_attr($test_email) ?></p></div>
            <?php } else { ?>
                <div class="error"><p>Error sending test email to <?php echo esc_attr($test_email) ?></p></div>
            <?php }
        }
        ?>
    </div>
    <?php
}

// Initialize and register SMTP settings
function mailpit_smtp_settings_init() {
    register_setting(
        'mailpit-smtp-settings-group',
        'mailpit_smtp_host'
    );
    register_setting(
        'mailpit-smtp-settings-group',
        'mailpit_smtp_port'
    );

    add_settings_section(
        'mailpit-smtp-settings-section',
        'SMTP Configuration',
        'mailpit_smtp_settings_section_callback',
        'mailpit-smtp-settings'
    );

    add_settings_field(
        'mailpit-smtp-host',
        'SMTP Host',
        'mailpit_smtp_host_callback',
        'mailpit-smtp-settings',
        'mailpit-smtp-settings-section'
    );

    add_settings_field(
        'mailpit-smtp-port',
        'SMTP Port',
        'mailpit_smtp_port_callback',
        'mailpit-smtp-settings',
        'mailpit-smtp-settings-section'
    );
}

// Callback to display section description
function mailpit_smtp_settings_section_callback() {
    echo 'Configure your SMTP settings below:';
}

// Callback to display SMTP Host field
function mailpit_smtp_host_callback() {
    $host = esc_attr(get_option('mailpit_smtp_host'));
    echo "<input type='text' name='mailpit_smtp_host' value='" . esc_attr($host) ."' />";
}

// Callback to display SMTP Port field
function mailpit_smtp_port_callback() {
    $port = esc_attr(get_option('mailpit_smtp_port'));
    echo "<input type='text' name='mailpit_smtp_port' value='". esc_attr($port) ."' />";
}

// Hook to add menu, initialize settings, and set default options
add_action('admin_menu', 'mailpit_smtp_settings_menu');
add_action('admin_init', 'mailpit_smtp_settings_init');
add_action('admin_init', 'mailpit_smtp_default_options');

// Override the WordPress mail system with SMTP settings
function mailpit_smtp_phpmailer_init($phpmailer) {
    $smtp_host = get_option('mailpit_smtp_host');
    $smtp_port = get_option('mailpit_smtp_port');

    $phpmailer->isSMTP();
    $phpmailer->Host = $smtp_host;
    $phpmailer->Port = $smtp_port;
    $phpmailer->SMTPAuth = false;
    // You can add more SMTP configuration options here, such as authentication settings if needed.
}

add_action('phpmailer_init', 'mailpit_smtp_phpmailer_init');

// Define the uninstaller function
function mailpit_smtp_uninstall() {
    // Remove options from the database
    delete_option('mailpit_smtp_host');
    delete_option('mailpit_smtp_port');
}

// Hook the uninstaller function to the 'uninstall' action
register_uninstall_hook(__FILE__, 'mailpit_smtp_uninstall');
