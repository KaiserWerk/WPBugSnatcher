<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://kaiserrobin.eu
 * @since      1.0.0
 *
 * @package    Bugsnatcher
 * @subpackage Bugsnatcher/admin/partials
 */

$options = get_option($this->plugin_name);

$log_enabled = $options['log_enabled'];

$discord_enabled = $options['discord_enabled'];
$discord_webhook = $options['discord_webhook'];

$slack_enabled = $options['slack_enabled'];
$slack_apikey = $options['slack_apikey'];
$slack_channel = $options['slack_channel'];
$slack_botname = $options['slack_botname'];

$stride_enabled = $options['stride_enabled'];
$stride_bearer_token = $options['stride_bearer_token'];
$stride_cloud_id = $options['stride_cloud_id'];
$stride_conversation_id = $options['stride_conversation_id'];

$hipchat_enabled = $options['hipchat_enabled'];
$hipchat_chatname = $options['hipchat_chatname'];
$hipchat_room_number = $options['hipchat_room_number'];
$hipchat_token = $options['hipchat_token'];

$email_enabled = $options['email_enabled'];
$email_list = $options['email_list'];

settings_fields($this->plugin_name);
do_settings_sections($this->plugin_name);

$menu_tabs = array(
	'log_settings' => __('Log Settings', $this->plugin_name),
	'discord_settings' => __('Discord', $this->plugin_name),
	'slack_settings' => __('Slack', $this->plugin_name),
	'stride_settings' => __('Stride', $this->plugin_name),
	'hipchat_settings' => __('HipChat', $this->plugin_name),
	'email_settings' => __('Email', $this->plugin_name),
	'import_export' => __('Import & Export', $this->plugin_name),
);

$tab_keys = array_keys($menu_tabs);
$current_tab = isset( $_GET['tab'] ) ? sanitize_text_field($_GET['tab']) : $tab_keys[0];

?>

<div class="wrap">
<h2><?php echo esc_html(get_admin_page_title()); ?></h2>

<?php
echo '<h2 class="nav-tab-wrapper">';
foreach ( $menu_tabs as $tab_key => $tab_caption )
{
    $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
    echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_name . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
}
echo '</h2>';

if ($current_tab === 'log_settings') {
    ?>
    <form method="post" name="form_log_settings" action="options.php" enctype="multipart/form-data">
        <?php settings_fields( $this->plugin_name ); ?>
        <div class="postbox">
            <div class="inside">
                <h3 class="hndle"><?php _e( 'Log settings', $this->plugin_name ); ?></h3>

                <table class="form-table">
                    <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Enable writing log files', $this->plugin_name ); ?>:</th>
                        <td>
                            <label><input type="checkbox" id="<?php echo $this->plugin_name; ?>-log-enabled"
                                          name="<?php echo $this->plugin_name; ?>[log_enabled]" <?php checked( $log_enabled,
                                    '1', true ); ?>> Enable</label>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input type="submit" name="btn_log_settings"
                       value="<?php _e( 'Save Log settings', $this->plugin_name ); ?>"
                       class="button-primary">
            </div>
        </div>
    </form>
    <?php
}
if ($current_tab === 'discord_settings') {
    ?>
    <form method="post" name="form_discord_settings" action="options.php" enctype="multipart/form-data">
        <?php settings_fields( $this->plugin_name ); ?>
        <div class="postbox">
            <div class="inside">
                <h3 class="hndle"><?php _e( 'Discord notification settings', $this->plugin_name ); ?></h3>

                <table class="form-table">
                    <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Enable Discord Notifications', $this->plugin_name ); ?>:</th>
                        <td>
                            <label><input type="checkbox" id="<?php echo $this->plugin_name; ?>-discord-enabled"
                                          name="<?php echo $this->plugin_name; ?>[discord_enabled]" <?php checked( $discord_enabled,
                                    '1', true ); ?>> Enable</label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Webhook URL', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="url" id="<?php echo $this->plugin_name; ?>-discord-webhook"
                                   name="<?php echo $this->plugin_name; ?>[discord_webhook]" class="regular-text"
                                   value="<?php if ( ! empty( $discord_webhook ) ) {
                                       echo $discord_webhook;
                                   } ?>">
                            <span class="description"><?php _e( 'Please enter your Webhook URL.',
                                    $this->plugin_name ); ?></span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input type="submit" name="btn_discord_settings"
                       value="<?php _e( 'Save Discord settings', $this->plugin_name ); ?>"
                       class="button-primary">
            </div>
        </div>
    </form>
    <?php
}
if ($current_tab === 'slack_settings') {
    ?>
    <form method="post" name="form_slack_settings" action="options.php" enctype="multipart/form-data">
        <?php settings_fields( $this->plugin_name ); ?>
        <div class="postbox">
            <div class="inside">
                <h3 class="hndle"><?php _e( 'Slack notification settings', $this->plugin_name ); ?></h3>

                <table class="form-table">
                    <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Enable Slack Notifications', $this->plugin_name ); ?>:</th>
                        <td>
                            <label><input type="checkbox" id="<?php echo $this->plugin_name; ?>-slack-enabled"
                                          name="<?php echo $this->plugin_name; ?>[slack_enabled]" <?php checked( $slack_enabled,
                                    '1', true ); ?>> Enable</label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'API Key', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="text" id="<?php echo $this->plugin_name; ?>-slack-apikey"
                                   name="<?php echo $this->plugin_name; ?>[slack_apikey]" class="regular-text"
                                   value="<?php if ( ! empty( $slack_apikey ) ) {
                                       echo $slack_apikey;
                                   } ?>">
                            <span class="description"><?php _e( 'Please enter your Slack API Legacy Key.',
                                    $this->plugin_name ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Channel', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="text" id="<?php echo $this->plugin_name; ?>-slack-channel"
                                   name="<?php echo $this->plugin_name; ?>[slack_channel]" class="regular-text"
                                   value="<?php if ( ! empty( $slack_channel ) ) {
                                       echo $slack_channel;
                                   } ?>">
                            <span class="description"><?php _e( 'Please enter the Slack channel name, prefixed with a # symbol.',
                                    $this->plugin_name ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Bot Name', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="text" id="<?php echo $this->plugin_name; ?>-slack-botname"
                                   name="<?php echo $this->plugin_name; ?>[slack_botname]" class="regular-text"
                                   value="<?php if ( ! empty( $slack_botname ) ) {
                                       echo $slack_botname;
                                   } ?>">
                            <span class="description"><?php _e( 'Please enter the name under which the bot will post messages.',
                                    $this->plugin_name ); ?></span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input type="submit" name="btn_slack_settings"
                       value="<?php _e( 'Save Slack settings', $this->plugin_name ); ?>"
                       class="button-primary">
            </div>
        </div>
    </form>
    <?php
}
if ($current_tab === 'stride_settings') {
    ?>
    <form method="post" name="form_stride_settings" action="options.php" enctype="multipart/form-data">
        <?php settings_fields( $this->plugin_name ); ?>
        <div class="postbox">
            <div class="inside">
                <h3 class="hndle"><?php _e( 'Stride notification settings', $this->plugin_name ); ?></h3>

                <table class="form-table">
                    <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Enable Stride Notifications', $this->plugin_name ); ?>:</th>
                        <td>
                            <label><input type="checkbox" id="<?php echo $this->plugin_name; ?>-stride-enabled"
                                          name="<?php echo $this->plugin_name; ?>[stride_enabled]" <?php checked( $stride_enabled,
                                    '1', true ); ?>> Enable</label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Bearer Token', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="text" id="<?php echo $this->plugin_name; ?>-stride-bearer-token"
                                   name="<?php echo $this->plugin_name; ?>[stride_bearer_token]"
                                   class="regular-text" value="<?php if ( ! empty( $stride_bearer_token ) ) {
                                echo $stride_bearer_token;
                            } ?>">
                            <span class="description"><?php _e( 'Please enter the Bearer Token generated for the integration.',
                                    $this->plugin_name ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Cloud ID', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="text" id="<?php echo $this->plugin_name; ?>-stride-cloud-id"
                                   name="<?php echo $this->plugin_name; ?>[stride_cloud_id]" class="regular-text"
                                   value="<?php if ( ! empty( $stride_cloud_id ) ) {
                                       echo $stride_cloud_id;
                                   } ?>">
                            <span class="description"><?php _e( 'Please enter the ID of your Stride Cloud instance.',
                                    $this->plugin_name ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Conversation ID', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="text" id="<?php echo $this->plugin_name; ?>-conversation-id"
                                   name="<?php echo $this->plugin_name; ?>[stride_conversation_id]"
                                   class="regular-text" value="<?php if ( ! empty( $stride_conversation_id ) ) {
                                echo $stride_conversation_id;
                            } ?>">
                            <span class="description"><?php _e( 'Please enter ID of the conversation (= room).',
                                    $this->plugin_name ); ?></span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input type="submit" name="btn_stride_settings"
                       value="<?php _e( 'Save Stride settings', $this->plugin_name ); ?>"
                       class="button-primary">
            </div>
        </div>
    </form>
    <?php
}
if ($current_tab === 'hipchat_settings') {
    ?>
    <form method="post" name="form_hipchat_settings" action="options.php" enctype="multipart/form-data">
        <?php settings_fields( $this->plugin_name ); ?>
        <div class="postbox">
            <div class="inside">
                <h3 class="hndle"><?php _e( 'HipChat notification settings', $this->plugin_name ); ?></h3>

                <table class="form-table">
                    <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Enable HipChat Notifications', $this->plugin_name ); ?>:</th>
                        <td>
                            <label><input type="checkbox" id="<?php echo $this->plugin_name; ?>-hipchat-enabled"
                                          name="<?php echo $this->plugin_name; ?>[hipchat_enabled]" <?php checked( $hipchat_enabled,
                                    '1', true ); ?>> Enable</label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Chat Name', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="text" id="<?php echo $this->plugin_name; ?>-hipchat-chatname"
                                   name="<?php echo $this->plugin_name; ?>[hipchat_chatname]" class="regular-text"
                                   value="<?php if ( ! empty( $hipchat_chatname ) ) {
                                       echo $hipchat_chatname;
                                   } ?>">
                            <span class="description"><?php _e( 'Please enter the subdomain part of your HipChat URL.',
                                    $this->plugin_name ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Room number', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="text" id="<?php echo $this->plugin_name; ?>-hipchat-room-number"
                                   name="<?php echo $this->plugin_name; ?>[hipchat_room_number]"
                                   class="regular-text" value="<?php if ( ! empty( $hipchat_room_number ) ) {
                                echo $hipchat_room_number;
                            } ?>">
                            <span class="description"><?php _e( 'Please enter the room number.',
                                    $this->plugin_name ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Token', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="text" id="<?php echo $this->plugin_name; ?>-hipchat-token"
                                   name="<?php echo $this->plugin_name; ?>[hipchat_token]" class="regular-text"
                                   value="<?php if ( ! empty( $hipchat_token ) ) {
                                       echo $hipchat_token;
                                   } ?>">
                            <span class="description"><?php _e( 'Please enter the token. May also be called access key or auth token.',
                                    $this->plugin_name ); ?></span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input type="submit" name="btn_hipchat_settings"
                       value="<?php _e( 'Save HipChat settings', $this->plugin_name ); ?>"
                       class="button-primary">
            </div>
        </div>
    </form>
    <?php
}
if ($current_tab === 'email_settings') {
    ?>
    <form method="post" name="form_email_settings" action="options.php" enctype="multipart/form-data">
        <?php settings_fields( $this->plugin_name ); ?>
        <div class="postbox">
            <div class="inside">
                <h3 class="hndle"><?php _e( 'HipChat notification settings', $this->plugin_name ); ?></h3>

                <table class="form-table">
                    <tbody>
                    
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Enable e-mail Notifications', $this->plugin_name ); ?>:</th>
                        <td>
                            <label><input type="checkbox" id="<?php echo $this->plugin_name; ?>-email-enabled"
                                          name="<?php echo $this->plugin_name; ?>[email_enabled]" <?php checked( $email_enabled,
                                    '1', true ); ?>> Enable</label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'List of e-mail addresses', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="text" id="<?php echo $this->plugin_name; ?>-email-list"
                                   name="<?php echo $this->plugin_name; ?>[email_list]" class="regular-text"
                                   value="<?php if ( ! empty( $email_list ) ) {
                                       echo $email_list;
                                   } ?>">
                            <p class="description"><?php _e( 'Please separate with a comma. Allowed formats: <br>mail@address.com <br> Tim Tester &lt;tim@tester.net&gt;',
                                    $this->plugin_name ); ?></p>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <input type="submit" name="btn_email_settings"
                       value="<?php _e( 'Save Email settings', $this->plugin_name ); ?>"
                       class="button-primary">
            </div>
        </div>
    </form>
    <?php
}
if ($current_tab === 'import_export') {
    ?>


    <form method="post" name="form_import_settings" action="options.php" enctype="multipart/form-data">
        <?php settings_fields( $this->plugin_name ); ?>
        <div class="postbox">
            <div class="inside">
                <h3 class="handle"><?php _e( 'Import settings', $this->plugin_name ); ?></h3>
                <span class="description"><?php _e( 'Use this section to import settings
            from a file. Alternatively, copy/paste the contents of your import file into the textarea below.',
                        $this->plugin_name ); ?></span>
                <table class="form-table">
                    <tbody>
                    <tr valign="top">

                        <th scope="row"><?php _e( 'Import File', $this->plugin_name ); ?>:</th>
                        <td>
                            <input type="file" id="<?php echo $this->plugin_name; ?>-import-file"
                                   name="<?php echo $this->plugin_name; ?>[import_file]">
                            <p class="description"><?php _e( 'After selecting your file, click the button below to apply the settings to your site.',
                                    $this->plugin_name ); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Copy/Paste Import Data', $this->plugin_name ); ?>:</th>
                        <td>
                            <textarea id="<?php echo $this->plugin_name; ?>-import-settings-text"
                                      name="<?php echo $this->plugin_name; ?>[import_settings_text]" cols="80"
                                      rows="10"></textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input type="submit" name="btn_import_settings"
                       value="<?php _e( 'Import settings', $this->plugin_name ); ?>" class="button-primary">

            </div>
        </div>
    </form>

    <form method="post" name="form_export_settings" action="options.php" enctype="multipart/form-data">
        <?php settings_fields( $this->plugin_name ); ?>
        <div class="postbox">
            <div class="inside">
                <h3 class="hndle"><?php _e( 'Export settings', $this->plugin_name ); ?></h3>
                <span class="description"><?php _e( 'Click the button below to export settings into a file for you to download. This leaves your settings unchanged.',
                        $this->plugin_name ); ?></span>
                <table class="form-table">

                </table>
                <input type="submit" name="btn_export_settings"
                       value="<?php _e( 'Export settings', $this->plugin_name ); ?>" class="button-primary">

            </div>
        </div>
    </form>
    <?php
}
?>