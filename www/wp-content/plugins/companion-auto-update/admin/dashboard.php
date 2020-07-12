<?php 

// Event schedules failed
if ( !wp_next_scheduled ( 'cau_set_schedule_mail' ) ) {
	echo '<div id="message" class="error"><p><b>'.__( 'Companion Auto Update was not able to set the event for sending you emails, please re-activate the plugin in order to set the event', 'companion-auto-update' ).'.</b></p></div>';
}

// Database requires an update
if ( cau_incorrectDatabaseVersion() ) {
        echo '<div id="message" class="error"><p><b>'.__( 'Companion Auto Update Database Update', 'companion-auto-update' ).' &ndash;</b>
        '.__( 'We need you to update to the latest database version', 'companion-auto-update' ).'. <a href="'.cau_url( 'status' ).'&run=db_update" class="button button-alt" style="background: #FFF;">'.__( 'Run updater now', 'companion-auto-update' ).'</a></p></div>';
}

// Update log DB is empty
if ( cau_updateLogDBisEmpty() ) {
        echo '<div id="message" class="error"><p><b>'.__( 'Companion Auto Update Database Update', 'companion-auto-update' ).' &ndash;</b>
        '.__( 'We need to add some information to your database', 'companion-auto-update' ).'. <a href="'.cau_url( 'status' ).'&run=db_info_update" class="button button-alt" style="background: #FFF;">'.__( 'Run updater now', 'companion-auto-update' ).'</a></p></div>';
}

// Save settings
if( isset( $_POST['submit'] ) ) {

	check_admin_referer( 'cau_save_settings' );

	global $wpdb;
	$table_name = $wpdb->prefix . "auto_updates"; 

	// Auto updater
	if( isset( $_POST['plugins'] ) ) 			$plugins 		= sanitize_text_field( $_POST['plugins'] ); else $plugins = '';
	if( isset( $_POST['themes'] ) ) 			$themes 		= sanitize_text_field( $_POST['themes'] ); else $themes = '';
	if( isset( $_POST['minor'] ) ) 				$minor 			= sanitize_text_field( $_POST['minor'] ); else $minor = '';
	if( isset( $_POST['major'] ) ) 				$major 			= sanitize_text_field( $_POST['major'] ); else $major = '';
	if( isset( $_POST['translations'] ) ) 		$translations 	= sanitize_text_field( $_POST['translations'] ); else $translations = '';

	$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'plugins'", $plugins ) );
	$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'themes'", $themes ) );
	$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'minor'", $minor ) );
	$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'major'", $major ) );
	$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'translations'", $translations ) );

	// Emails
	if( isset( $_POST['cau_send'] ) ) 			$send 			= sanitize_text_field( $_POST['cau_send'] ); else $send = '';
	if( isset( $_POST['cau_send_update'] ) ) 	$sendupdate 	= sanitize_text_field( $_POST['cau_send_update'] ); else $sendupdate = '';
	if( isset( $_POST['wpemails'] ) ) 			$wpemails 		= sanitize_text_field( $_POST['wpemails'] ); else $wpemails = '';
	if( isset( $_POST['cau_email'] ) ) 			$email 			= sanitize_text_field( $_POST['cau_email'] );
	if( isset( $_POST['html_or_text'] ) ) 		$html_or_text 	= sanitize_text_field( $_POST['html_or_text'] );

	$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'email'", $email ) );
	$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'send'", $send ) );
	$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'sendupdate'", $sendupdate ) );
	$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'wpemails'", $wpemails ) );
	$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'html_or_text'", $html_or_text ) );

	// Intervals

	// Set variables
	$plugin_sc 		= sanitize_text_field( $_POST['plugin_schedule'] );
	$theme_sc 		= sanitize_text_field( $_POST['theme_schedule'] );
	$core_sc 		= sanitize_text_field( $_POST['core_schedule'] );
	$schedule_mail 	= sanitize_text_field( $_POST['schedule_mail'] );
	$html_or_text 	= sanitize_text_field( $_POST['html_or_text'] );

	// First clear schedules
	wp_clear_scheduled_hook('wp_update_plugins');
	wp_clear_scheduled_hook('wp_update_themes');
	wp_clear_scheduled_hook('wp_version_check');
	wp_clear_scheduled_hook('cau_set_schedule_mail');
	wp_clear_scheduled_hook('cau_custom_hooks_plugins');
	wp_clear_scheduled_hook('cau_custom_hooks_themes');

	// Then set the new times

	// Plugins
	if( $plugin_sc == 'daily' ) {

		$date 				= date( 'Y-m-d' );
		$hours 				= sanitize_text_field( $_POST['pluginScheduleTimeH'] );
		$minutes 			= sanitize_text_field( $_POST['pluginScheduleTimeM'] );
		$seconds 			= date( 's' );
		$fullDate 			= $date.' '.$hours.':'.$minutes.':'.$seconds;
		$pluginSetTime 		= strtotime( $fullDate );

		wp_schedule_event( $pluginSetTime, $plugin_sc, 'wp_update_plugins' );
		wp_schedule_event( $pluginSetTime, $plugin_sc, 'cau_custom_hooks_plugins' );

	} else {

		wp_schedule_event( time(), $plugin_sc, 'wp_update_plugins' );
		wp_schedule_event( time(), $plugin_sc, 'cau_custom_hooks_plugins' );

	}

	// Themes
	if( $theme_sc == 'daily' ) {

		$dateT 				= date( 'Y-m-d' );
		$hoursT 			= sanitize_text_field( $_POST['ThemeScheduleTimeH'] );
		$minutesT 			= sanitize_text_field( $_POST['ThemeScheduleTimeM'] );
		$secondsT 			= date( 's' );
		$fullDateT 			= $dateT.' '.$hoursT.':'.$minutesT.':'.$secondsT;
		$themeSetTime 		= strtotime( $fullDateT );

		wp_schedule_event( $themeSetTime, $theme_sc, 'wp_update_themes' );
		wp_schedule_event( $themeSetTime, $theme_sc, 'cau_custom_hooks_themes' );

	} else {

		wp_schedule_event( time(), $theme_sc, 'wp_update_themes' );
		wp_schedule_event( time(), $theme_sc, 'cau_custom_hooks_themes' );

	}

	// Core
	if( $core_sc == 'daily' ) {

		$dateC 				= date( 'Y-m-d' );
		$hoursC 			= sanitize_text_field( $_POST['CoreScheduleTimeH'] );
		$minutesC 			= sanitize_text_field( $_POST['CoreScheduleTimeM'] );
		$secondsC 			= date( 's' );
		$fullDateC 			= $dateC.' '.$hoursC.':'.$minutesC.':'.$secondsC;
		$coreSetTime 		= strtotime( $fullDateC );

		wp_schedule_event( $coreSetTime, $core_sc, 'wp_version_check' );

	} else {

		wp_schedule_event( time(), $core_sc, 'wp_version_check' );

	}

	// Emails
	if( $schedule_mail == 'daily' ) {

		$dateT 				= date( 'Y-m-d' );
		$hoursT 			= sanitize_text_field( $_POST['timeScheduleEmailTimeH'] );
		$minutesT 			= sanitize_text_field( $_POST['timeScheduleEmailTimeM'] );
		$secondsT 			= date( 's' );
		$fullDateT 			= $dateT.' '.$hoursT.':'.$minutesT.':'.$secondsT;
		$emailSetTime 		= strtotime( $fullDateT );

		wp_schedule_event( $emailSetTime, $schedule_mail, 'cau_set_schedule_mail' );

	} else {

		wp_schedule_event( time(), $schedule_mail, 'cau_set_schedule_mail' );

	}

	echo '<div id="message" class="updated"><p><b>'.__( 'Settings saved.' ).'</b></p></div>';

}

if( isset( $_GET['welcome'] ) ) {

	echo '<div class="welcome-to-cau welcome-bg welcome-panel" style="margin-bottom: 0px;">
		<div class="welcome-image">
		</div><div class="welcome-content">

			<h3>'.__( 'Welcome to Companion Auto Update', 'companion-auto-update' ).'</h3>
			<br />
			<p><strong>'.__( 'You\'re set and ready to go', 'companion-auto-update' ).'</strong></p>
			<p>'.__( 'The plugin is all set and ready to go with the recommended settings, but if you\'d like you can change them below.' ).'</p>
			<br />
			<p><strong>'.__( 'Get Started' ).': </strong> <a href="'.cau_url( 'pluginlist' ).'">'.__( 'Update filter', 'companion-auto-update' ).'</a> &nbsp; | &nbsp;
			<strong>'.__( 'More Actions' ).': </strong> <a href="http://codeermeneer.nl/cau_poll/" target="_blank">'.__('Give feedback', 'companion-auto-update').'</a> - <a href="https://translate.wordpress.org/projects/wp-plugins/companion-auto-update/" target="_blank">'.__( 'Help us translate', 'companion-auto-update' ).'</a></p>

		</div>
	</div>';
}

$plugin_schedule 			= wp_get_schedule( 'wp_update_plugins' );
$theme_schedule 			= wp_get_schedule( 'wp_update_themes' );
$core_schedule 				= wp_get_schedule( 'wp_version_check' );
$schedule_mail				= wp_get_schedule( 'cau_set_schedule_mail' );
$cs_hooks_p 				= wp_get_schedule( 'cau_custom_hooks_plugins' );
$cs_hooks_t 				= wp_get_schedule( 'cau_custom_hooks_themes' );
$availableIntervals 		= cau_wp_get_schedules();

?>

<div class="cau-column-wide">
	
	<form method="POST">

		<div class="welcome-to-cau update-bg welcome-panel cau-dashboard-box">
			
			<h2 class="title"><?php _e('Auto Updater', 'companion-auto-update');?></h2>

			<table class="form-table">
				<tr>
					<td>
						<fieldset>

							<?php

							echo '<p><input id="plugins" name="plugins" type="checkbox"';
							if( cau_get_db_value( 'plugins' ) == 'on' ) echo 'checked';
							echo '/> <label for="plugins">'.__('Auto update plugins?', 'companion-auto-update').'</label></p>';

							echo '<p><input id="themes" name="themes" type="checkbox"';
							if( cau_get_db_value( 'themes' ) == 'on' ) echo 'checked';
							echo '/> <label for="themes">'.__('Auto update themes?', 'companion-auto-update').'</label></p>';

							echo '<p><input id="minor" name="minor" type="checkbox"';
							if( cau_get_db_value( 'minor' ) == 'on' ) echo 'checked';
							echo '/> <label for="minor">'.__('Auto update minor core updates?', 'companion-auto-update').' <code class="majorMinorExplain">5.3.0 > 5.3.1</code></label></p>';

							echo '<p><input id="major" name="major" type="checkbox"';
							if( cau_get_db_value( 'major' ) == 'on' ) echo 'checked';
							echo '/> <label for="major">'.__('Auto update major core updates?', 'companion-auto-update').' <code class="majorMinorExplain">5.3.0 > 5.4.0</code></label></p>';

							echo '<p><input id="translations" name="translations" type="checkbox"';
							if( cau_get_db_value( 'translations' ) == 'on' ) echo 'checked';
							echo '/> <label for="translations">'.__('Auto update translation files?', 'companion-auto-update').'</label></p>';

							?>

						</fieldset>
					</td>
				</tr>
			</table>

		</div>

		<div class="welcome-to-cau email-bg welcome-panel cau-dashboard-box">

			<h2 class="title"><?php _e( 'Email Notifications', 'companion-auto-update' );?></h2>

			<?php
			if( cau_get_db_value( 'email' ) == '' ) $toemail = get_option('admin_email'); 
			else $toemail = cau_get_db_value( 'email' );
			?>

			<table class="form-table">
				<tr>
					<th scope="row"><?php _e( 'Update available', 'companion-auto-update' );?></th>
					<td>
						<p>
							<input id="cau_send" name="cau_send" type="checkbox" <?php if( cau_get_db_value( 'send' ) == 'on' ) { echo 'checked'; } ?> />
							<label for="cau_send"><?php _e('Send me emails when an update is available.', 'companion-auto-update');?></label>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e( 'Successful update', 'companion-auto-update' );?></th>
					<td>
						<p>
							<input id="cau_send_update" name="cau_send_update" type="checkbox" <?php if( cau_get_db_value( 'sendupdate' ) == 'on' ) { echo 'checked'; } ?> />
							<label for="cau_send_update"><?php _e('Send me emails when something has been updated.', 'companion-auto-update');?></label>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e( 'Email Address' );?></th>
					<td>
						<p>
							<label for="cau_email"><?php _e('To', 'companion-auto-update');?>:</label>
							<input type="text" name="cau_email" id="cau_email" class="regular-text" placeholder="<?php echo get_option('admin_email'); ?>" value="<?php echo esc_html( $toemail ); ?>" />
						</p>

						<p class="description"><?php _e('Seperate email addresses using commas.', 'companion-auto-update');?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e( 'Use HTML in emails?', 'companion-auto-update' );?></th>
					<td>
						<p>
							<select id='html_or_text' name='html_or_text'>
								<option value='html' <?php if( cau_get_db_value( 'html_or_text' ) == 'html' ) { echo "SELECTED"; } ?>><?php _e( 'Use HTML', 'companion-auto-update' ); ?></option>
								<option value='text' <?php if( cau_get_db_value( 'html_or_text' ) == 'text' ) { echo "SELECTED"; } ?>><?php _e( 'Use plain text', 'companion-auto-update' ); ?></option>
							</select>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<?php _e('Core notifications', 'companion-auto-update');?>
						<span class='cau_tooltip'><span class="dashicons dashicons-editor-help"></span>
							<span class='cau_tooltip_text'><?php _e('Core notifications are handled by WordPress and not by this plugin. You can only disable them, changing your email address in the settings above will not affect these notifications.', 'companion-auto-update');?></span>
						</span>
					</th>
					<td>
						<p>
							<input id="wpemails" name="wpemails" type="checkbox" <?php if( cau_get_db_value( 'wpemails' ) == 'on' ) { echo 'checked'; } ?> />
							<label for="wpemails"><?php _e( 'By default WordPress sends an email when a core update has occurred. Uncheck this box to disable these emails.', 'companion-auto-update' );?></label>
						</p>
					</td>
				</tr>
			</table>

		</div>

		<div class="welcome-to-cau interval-bg welcome-panel cau-dashboard-box" style="overflow: hidden;">

			<h2 class="title"><?php _e('Intervals', 'companion-auto-update');?></h2>
			
			<div class="welcome-column welcome-column-quarter">

				<h4><?php _e( 'Plugin update interval', 'companion-auto-update' );?></h4>
				<p>
					<select name='plugin_schedule' id='plugin_schedule' class='schedule_interval wide'>
						<?php foreach ( $availableIntervals as $key => $value ) {
							echo "<option "; if( $plugin_schedule == $key ) { echo "selected "; } echo "value='".$key."'>".$value."</option>"; 
						} ?>
					</select>
				</p>
				<div class='timeSchedulePlugins' <?php if( $plugin_schedule != 'daily' ) { echo "style='display: none;'"; } ?> >

					<?php 

					$setTimePlugins 	= wp_next_scheduled( 'wp_update_plugins' );
					$setTimePluginsHour = date( 'H' , $setTimePlugins );
					$setTimePluginsMin 	= date( 'i' , $setTimePlugins ); 

					?>

					<div class='cau_schedule_input'>
						<input type='number' max='23' name='pluginScheduleTimeH' value='<?php echo $setTimePluginsHour; ?>' maxlength='2' >
					</div><div class='cau_schedule_input_div'>
						:
					</div><div class='cau_schedule_input'>
						<input type='number' max='59' name='pluginScheduleTimeM' value='<?php echo $setTimePluginsMin; ?>' maxlength='2' > 
					</div><div class='cau_shedule_notation'>
						<span class='cau_tooltip'><span class="dashicons dashicons-editor-help"></span>
							<span class='cau_tooltip_text'><?php _e('At what time should the updater run? Only works when set to <u>daily</u>.', 'companion-auto-update'); ?> - <?php _e( 'Time notation: 24H', 'companion-auto-update'); ?></span>
						</span>
					</div>

				</div>

			</div><div class="welcome-column welcome-column-quarter">

				<h4><?php _e( 'Theme update interval', 'companion-auto-update' );?></h4>
				<p>
					<select name='theme_schedule' id='theme_schedule' class='schedule_interval wide'>
						<?php foreach ( $availableIntervals as $key => $value ) {
							echo "<option "; if( $theme_schedule == $key ) { echo "selected "; } echo "value='".$key."'>".$value."</option>"; 
						} ?>
					</select>
				</p>
				<div class='timeScheduleThemes' <?php if( $theme_schedule != 'daily' ) { echo "style='display: none;'"; } ?> >

					<?php 

					$setTimeThemes 		= wp_next_scheduled( 'wp_update_themes' );
					$setTimeThemesHour 	= date( 'H' , $setTimeThemes );
					$setTimeThemesMins 	= date( 'i' , $setTimeThemes );

					?>

					<div class='cau_schedule_input'>
						<input type='number' max='23' name='ThemeScheduleTimeH' value='<?php echo $setTimeThemesHour; ?>' maxlength='2' >
					</div><div class='cau_schedule_input_div'>
						:
					</div><div class='cau_schedule_input'>
						<input type='number' max='59' name='ThemeScheduleTimeM' value='<?php echo $setTimeThemesMins; ?>' maxlength='2' > 
					</div><div class='cau_shedule_notation'>
						<span class='cau_tooltip'><span class="dashicons dashicons-editor-help"></span>
							<span class='cau_tooltip_text'><?php _e('At what time should the updater run? Only works when set to <u>daily</u>.', 'companion-auto-update'); ?> - <?php _e( 'Time notation: 24H', 'companion-auto-update'); ?></span>
						</span>
					</div>
				</div>

			</div><div class="welcome-column welcome-column-quarter">

				<h4><?php _e( 'Core update interval', 'companion-auto-update' );?></h4>
				<p>
					<select name='core_schedule' id='core_schedule' class='schedule_interval wide'>
						<?php foreach ( $availableIntervals as $key => $value ) {
							echo "<option "; if( $core_schedule == $key ) { echo "selected "; } echo "value='".$key."'>".$value."</option>"; 
						} ?>
					</select>
				</p>
				<div class='timeScheduleCore' <?php if( $core_schedule != 'daily' ) { echo "style='display: none;'"; } ?> >

					<?php 

					$setTimeCore 		= wp_next_scheduled( 'wp_version_check' );
					$setTimeCoreHour 	= date( 'H' , $setTimeCore );
					$setTimeCoreMins 	= date( 'i' , $setTimeCore );

					?>

					<div class='cau_schedule_input'>
						<input type='number' max='23' name='CoreScheduleTimeH' value='<?php echo $setTimeCoreHour; ?>' maxlength='2' >
					</div><div class='cau_schedule_input_div'>
						:
					</div><div class='cau_schedule_input'>
						<input type='number' max='59' name='CoreScheduleTimeM' value='<?php echo $setTimeCoreMins; ?>' maxlength='2' > 
					</div><div class='cau_shedule_notation'>
						<span class='cau_tooltip'><span class="dashicons dashicons-editor-help"></span>
							<span class='cau_tooltip_text'><?php _e('At what time should the updater run? Only works when set to <u>daily</u>.', 'companion-auto-update'); ?> - <?php _e( 'Time notation: 24H', 'companion-auto-update'); ?></span>
						</span>
					</div>
				</div>

			</div><div class="welcome-column welcome-column-quarter">

				<h4><?php _e( 'Email Notifications', 'companion-auto-update' );?></h4>
				<p>
					<select id='schedule_mail' name='schedule_mail' class='schedule_interval wide'>
						<?php foreach ( $availableIntervals as $key => $value ) {
							echo "<option "; if( $schedule_mail == $key ) { echo "selected "; } echo "value='".$key."'>".$value."</option>"; 
						} ?>
					</select>
				</p>
				<div class='timeScheduleEmail' <?php if( $schedule_mail != 'daily' ) { echo "style='display: none;'"; } ?> >

					<?php 

					$setTimeEmails 		= wp_next_scheduled( 'cau_set_schedule_mail' );
					$setTimeEmailHour 	= date( 'H' , $setTimeEmails );
					$setTimeEmailMins 	= date( 'i' , $setTimeEmails );

					?>

					<div class='cau_schedule_input'>
						<input type='number' max='23' name='timeScheduleEmailTimeH' value='<?php echo $setTimeEmailHour; ?>' maxlength='2' >
					</div><div class='cau_schedule_input_div'>
						:
					</div><div class='cau_schedule_input'>
						<input type='number' max='59' name='timeScheduleEmailTimeM' value='<?php echo $setTimeEmailMins; ?>' maxlength='2' > 
					</div><div class='cau_shedule_notation'>
						<span class='cau_tooltip'><span class="dashicons dashicons-editor-help"></span>
							<span class='cau_tooltip_text'><?php _e( 'Time notation: 24H', 'companion-auto-update'); ?></span>
						</span>
					</div>
				</div>

			</div>
		</div>

		<?php wp_nonce_field( 'cau_save_settings' ); ?>	
		<?php submit_button(); ?>

	</form>

</div><div class="cau-column-small">

	<div class="welcome-to-cau help-bg welcome-panel cau-dashboard-box">
		<div class="welcome-column welcome-column.welcome-column-half">
			<h3 class="support-sidebar-title"><?php _e( 'Help' ); ?></h3>
			<ul class="support-sidebar-list">
				<li><a href="https://codeermeneer.nl/stuffs/faq-auto-updater/" target="_blank"><?php _e( 'Frequently Asked Questions', 'companion-auto-update' ); ?></a></li>
				<li><a href="https://wordpress.org/support/plugin/companion-auto-update" target="_blank"><?php _e( 'Support Forums' ); ?></a></li>
			</ul>

			<h3 class="support-sidebar-title"><?php _e( 'Want to contribute?', 'companion-auto-update' ); ?></h3>
			<ul class="support-sidebar-list">
				<li><a href="http://codeermeneer.nl/cau_poll/" target="_blank"><?php _e( 'Give feedback', 'companion-auto-update' ); ?></a></li>
				<li><a href="https://codeermeneer.nl/blog/companion-auto-update-and-its-future/" target="_blank"><?php _e( 'Feature To-Do List', 'companion-auto-update' ); ?></a></li>
				<li><a href="https://translate.wordpress.org/projects/wp-plugins/companion-auto-update/" target="_blank"><?php _e( 'Help us translate', 'companion-auto-update' ); ?></a></li>
			</ul>
		</div>
		<div class="welcome-column welcome-column.welcome-column-half">
			<h3 class="support-sidebar-title"><?php _e( 'Developer?', 'companion-auto-update' ); ?></h3>
			<ul class="support-sidebar-list">
				<li><a href="https://codeermeneer.nl/documentation/auto-update/" target="_blank"><?php _e( 'Documentation' ); ?></a></li>
			</ul>
		</div>
	</div>

	<div class="welcome-to-cau support-bg welcome-panel cau-dashboard-box">
		<div class="welcome-column welcome-column">
			<h3><?php _e('Support', 'companion-auto-update');?></h3>
			<p><?php _e('Feel free to reach out to us if you have any questions or feedback.', 'companion-auto-update'); ?></p>
			<p><a href="https://codeermeneer.nl/contact/" target="_blank" class="button button-primary"><?php _e( 'Contact us', 'companion-auto-update' ); ?></a></p>
			<p><a href="https://codeermeneer.nl/plugins/" target="_blank" class="button button-alt"><?php _e('Check out our other plugins', 'companion-auto-update');?></a></p>
		</div>
	</div>

	<div class="welcome-to-cau love-bg cau-show-love welcome-panel cau-dashboard-box">
		<h3><?php _e( 'Like our plugin?', 'companion-auto-update' ); ?></h3>
		<p><?php _e('Companion Auto Update is free to use. It has required a great deal of time and effort to develop and you can help support this development by making a small donation.<br />You get useful software and we get to carry on making it better.', 'companion-auto-update'); ?></p>
		<a href="https://wordpress.org/support/plugin/companion-auto-update/reviews/#new-post" target="_blank" class="button button-alt button-hero">
			<?php _e('Rate us (5 stars?)', 'companion-auto-update'); ?>
		</a>
		<a href="<?php echo cau_donateUrl(); ?>" target="_blank" class="button button-primary button-hero">
			<?php _e('Donate to help development', 'companion-auto-update'); ?>
		</a>
		<p style="font-size: 12px; color: #BDBDBD;">Donations via PayPal. Amount can be changed.</p>
	</div>

</div>

<script type="text/javascript">
	
	jQuery( '#plugin_schedule' ).change( function() {

		var selected = jQuery(this).val();

		if( selected == 'daily' ) {
			jQuery('.timeSchedulePlugins').show();
		} else {
			jQuery('.timeSchedulePlugins').hide();
		}

	});
	
	jQuery( '#theme_schedule' ).change( function() {

		var selected = jQuery(this).val();

		if( selected == 'daily' ) {
			jQuery('.timeScheduleThemes').show();
		} else {
			jQuery('.timeScheduleThemes').hide();
		}

	});
	
	jQuery( '#core_schedule' ).change( function() {

		var selected = jQuery(this).val();

		if( selected == 'daily' ) {
			jQuery('.timeScheduleCore').show();
		} else {
			jQuery('.timeScheduleCore').hide();
		}

	});
	
	jQuery( '#schedule_mail' ).change( function() {

		var selected = jQuery(this).val();

		if( selected == 'daily' ) {
			jQuery('.timeScheduleEmail').show();
		} else {
			jQuery('.timeScheduleEmail').hide();
		}

	});

</script>