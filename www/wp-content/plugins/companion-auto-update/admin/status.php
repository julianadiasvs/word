<?php

	// Update the database
	if( isset( $_GET['run'] ) && $_GET['run'] == 'db_update' ) {
		cau_manual_update();
		echo '<div id="message" class="updated"><p><b>'.__( 'Database update completed' ).'</b></p></div>';
	}
	
	if( isset( $_GET['run'] ) && $_GET['run'] == 'db_info_update' ) {
		cau_savePluginInformation();
		echo '<div id="message" class="updated"><p><b>'.__( 'Database information update completed' ).'</b></p></div>';
	}
	
	// Date format
	$dateFormat = get_option( 'date_format' );
	$dateFormat .= ' '.get_option( 'time_format' );

	global $wpdb;
	$table_name = $wpdb->prefix . "auto_updates"; 

	// Minor updates
	$configs = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE name = 'minor'");
	foreach ( $configs as $config ) {

		if( $config->onoroff == 'on' && wp_get_schedule( 'wp_version_check' ) ) {
			$minorUpdates 	= true;
			$minorStatus 	= 'enabled';
			$minorIcon		= 'yes-alt';
			$minorInterval 	= wp_get_schedule( 'wp_version_check' );
			$minorNext 		= date_i18n( $dateFormat, wp_next_scheduled( 'wp_version_check' ) );
			$minorText 		= __( 'Enabled', 'companion-auto-update' );
		} else {
			$minorUpdates 	= false;
			$minorStatus 	= 'disabled';
			$minorIcon		= 'marker';
			$minorInterval 	= '&dash;';
			$minorNext 		= '&dash;';
			$minorText 		= __( 'Disabled', 'companion-auto-update' );
		}

	}

	// Major updates
	$configs = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE name = 'major'");
	foreach ( $configs as $config ) {

		if( $config->onoroff == 'on' && wp_get_schedule( 'wp_version_check' ) ) {
			$majorUpdates 	= true;
			$majorStatus 	= 'enabled';
			$majorIcon		= 'yes-alt';
			$majorInterval 	= wp_get_schedule( 'wp_version_check' );
			$majorNext 		= date_i18n( $dateFormat, wp_next_scheduled( 'wp_version_check' ) );
			$majorText 		= __( 'Enabled', 'companion-auto-update' );
		} else {
			$majorUpdates 	= false;
			$majorStatus 	= 'disabled';
			$majorIcon		= 'marker';
			$majorInterval 	= '&dash;';
			$majorNext 		= '&dash;';
			$majorText 		= __( 'Disabled', 'companion-auto-update' );
		}

	}

	// Plugin updates
	$configs = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE name = 'plugins'");
	foreach ( $configs as $config ) {

		if( $config->onoroff == 'on' && wp_get_schedule( 'wp_update_plugins' ) ) {
			$pluginsUpdates 	= true;
			$pluginsStatus 		= 'enabled';
			$pluginsIcon		= 'yes-alt';
			$pluginsInterval 	= wp_get_schedule( 'wp_update_plugins' );
			$pluginsNext 		= date_i18n( $dateFormat, wp_next_scheduled( 'wp_update_plugins' ) );
			$pluginsText 		= __( 'Enabled', 'companion-auto-update' );
		} else {
			$pluginsUpdates 	= false;
			$pluginsStatus 		= 'disabled';
			$pluginsIcon		= 'marker';
			$pluginsInterval 	= '&dash;';
			$pluginsNext 		= '&dash;';
			$pluginsText 		= __( 'Disabled', 'companion-auto-update' );
		}

	}

	// Themes updates
	$configs = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE name = 'themes'");
	foreach ( $configs as $config ) {

		if( $config->onoroff == 'on' && wp_get_schedule( 'wp_update_plugins' ) ) {
			$themesUpdates 		= true;
			$themesStatus 		= 'enabled';
			$themesIcon			= 'yes-alt';
			$themesInterval 	= wp_get_schedule( 'wp_update_plugins' );
			$themesNext 		= date_i18n( $dateFormat, wp_next_scheduled( 'wp_update_plugins' ) );
			$themesText 		= __( 'Enabled', 'companion-auto-update' );
		} else {
			$themesUpdates 		= false;
			$themesStatus 		= 'disabled';
			$themesIcon			= 'marker';
			$themesInterval 	= '&dash;';
			$themesNext 		= '&dash;';
			$themesText 		= __( 'Disabled', 'companion-auto-update' );
		}

	}

	// E-mail notifications
	if ( wp_next_scheduled ( 'cau_set_schedule_mail' ) ) {

		$emailCase = false;
		
		$configs = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE name = 'send'");
		foreach ( $configs as $config ) {
			if( $config->onoroff == 'on' ) {
				$emailCase = true;
			}
		}
		$configs = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE name = 'sendupdate'");
		foreach ( $configs as $config ) {
			if( $config->onoroff == 'on' ) {
				$emailCase = true;
			}
		}

		if( $emailCase ) {
			$setScheduleStatus  	= 'enabled';
			$setScheduleIcon  		= 'yes-alt';
			$setScheduleInterval 	= wp_get_schedule( 'cau_set_schedule_mail' );
			$setScheduleNext 		= date_i18n( $dateFormat, wp_next_scheduled( 'cau_set_schedule_mail' ) );
			$setScheduleText 		= __( 'Enabled', 'companion-auto-update' );
		} else {
			$setScheduleStatus  	= 'warning';
			$setScheduleIcon  		= 'marker';
			$setScheduleInterval 	= '&dash;';
			$setScheduleNext 		= '&dash;';
			$setScheduleText 		= __( 'Disabled', 'companion-auto-update' );
		}

	} else {
		$setScheduleStatus  	= 'disabled';
		$setScheduleIcon  		= 'dismiss';
		$setScheduleInterval 	= '&dash;';
		$setScheduleNext 		= '&dash;';
		$setScheduleText 		= __( 'Error', 'companion-auto-update' );
	}

	// Core notifcations
	$configs = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE name = 'wpemails'");
	foreach ( $configs as $config ) {
		if( $config->onoroff == 'on' ) {
			$setCoreStatus  	= 'enabled';
			$setCoreIcon  		= 'yes-alt';
			$setCoreInterval 	= wp_get_schedule( 'cau_set_schedule_mail' );
			$setCoreNext 		= date_i18n( $dateFormat, wp_next_scheduled( 'cau_set_schedule_mail' ) );
			$setCoreText 		= __( 'Enabled', 'companion-auto-update' );
		} else {
			$setCoreStatus  	= 'warning';
			$setCoreIcon  		= 'marker';
			$setCoreInterval 	= '&dash;';
			$setCoreNext 		= '&dash;';
			$setCoreText 		= __( 'Disabled', 'companion-auto-update' );
		}
	}

	$schedules = wp_get_schedules();

?>

<h2><?php _e('Status', 'companion-auto-update'); ?></h2>

<div class="cau_status_page">

<div id="message" class="cau">
	<strong>Got a moment?</strong> &dash; <a href="https://forms.gle/FbnokrbdLFhVHgDZA" target="_blank" class="tell_me_more">Please answer a few questions about the future of the status page in this plugin.</a>
</div>

<table class="cau_status_list widefat striped">

	<thead>
		<tr>
			<th width="300" class="cau_status_name"><strong><?php _e( 'Auto Updater', 'companion-auto-update' ); ?></strong></th>
			<th class="cau_status_active_state"><strong><?php _e( 'Status', 'companion-auto-update' ); ?></strong></th>
			<th class="cau_status_interval"><strong><?php _e( 'Interval', 'companion-auto-update' ); ?></strong></th>
			<th class="cau_status_next"><strong><?php _e( 'Next', 'companion-auto-update' ); ?></strong></th>
		</tr>
	</thead>

	<tbody id="the-list">
		<tr>
			<td class="cau_status_name"><?php _e( 'Plugins', 'companion-auto-update' ); ?></td>
			<td class="cau_status_active_state"><span class='cau_<?php echo $pluginsStatus; ?>'><span class="dashicons dashicons-<?php echo $pluginsIcon; ?>"></span> <?php echo $pluginsText; ?></span></td>
			<td class="cau_status_interval"><?php echo $schedules[$pluginsInterval]['display']; ?></td>
			<td class="cau_status_next"><span class="cau_mobile_prefix"><?php _e( 'Next', 'companion-auto-update' ); ?>: </span><?php echo $pluginsNext; ?></td>
		</tr>
		<tr>
			<td class="cau_status_name"><?php _e( 'Themes', 'companion-auto-update' ); ?></td>
			<td class="cau_status_active_state"><span class='cau_<?php echo $themesStatus; ?>'><span class="dashicons dashicons-<?php echo $themesIcon; ?>"></span> <?php echo $themesText; ?></span></td>
			<td class="cau_status_interval"><?php echo $schedules[$themesInterval]['display']; ?></td>
			<td class="cau_status_next"><span class="cau_mobile_prefix"><?php _e( 'Next', 'companion-auto-update' ); ?>: </span><?php echo $themesNext; ?></td>
		</tr>
		<tr>
			<td class="cau_status_name"><?php _e( 'Core (Minor)', 'companion-auto-update' ); ?></td>
			<td class="cau_status_active_state"><span class='cau_<?php echo $minorStatus; ?>'><span class="dashicons dashicons-<?php echo $minorIcon; ?>"></span> <?php echo $minorText; ?></span></td>
			<td class="cau_status_interval"><?php echo $schedules[$minorInterval]['display']; ?></td>
			<td class="cau_status_next"><span class="cau_mobile_prefix"><?php _e( 'Next', 'companion-auto-update' ); ?>: </span><?php echo $minorNext; ?></td>
		</tr>
		<tr>
			<td class="cau_status_name"><?php _e( 'Core (Major)', 'companion-auto-update' ); ?></td>
			<td class="cau_status_active_state"><span class='cau_<?php echo $majorStatus; ?>'><span class="dashicons dashicons-<?php echo $majorIcon; ?>"></span> <?php echo $majorText; ?></span></td>
			<td class="cau_status_interval"><?php echo $schedules[$majorInterval]['display']; ?></td>
			<td class="cau_status_next"><span class="cau_mobile_prefix"><?php _e( 'Next', 'companion-auto-update' ); ?>: </span><?php echo $majorNext; ?></td>
		</tr>
	</tbody>

</table>

<table class="cau_status_list widefat striped">

	<thead>
		<tr>
			<th width="300" class="cau_status_name"><strong><?php _e( 'Email Notifications', 'companion-auto-update' ); ?></strong></th>
			<th class="cau_status_active_state"><strong><?php _e( 'Status', 'companion-auto-update' ); ?></strong></th>
			<th class="cau_status_interval"><strong><?php _e( 'Interval', 'companion-auto-update' ); ?></strong></th>
			<th class="cau_status_next"><strong><?php _e( 'Next', 'companion-auto-update' ); ?></strong></th>
		</tr>
	</thead>

	<tbody id="the-list">
		<tr>
			<td class="cau_status_name"><?php _e( 'Email Notifications', 'companion-auto-update' ); ?></td>
			<td class="cau_status_active_state"><span class='cau_<?php echo $setScheduleStatus; ?>'><span class="dashicons dashicons-<?php echo $setScheduleIcon; ?>"></span> <?php echo $setScheduleText; ?></span></td>
			<td class="cau_status_interval"><?php echo $schedules[$setScheduleInterval]['display']; ?></td>
			<td class="cau_status_next"><span class="cau_mobile_prefix"><?php _e( 'Next', 'companion-auto-update' ); ?>: </span><?php echo $setScheduleNext; ?></td>
		</tr>
		<tr>
			<td class="cau_status_name"><?php _e( 'Core notifications', 'companion-auto-update' ); ?></td>
			<td class="cau_status_active_state"><span class='cau_<?php echo $setCoreStatus; ?>'><span class="dashicons dashicons-<?php echo $setCoreIcon; ?>"></span> <?php echo $setCoreText; ?></span></td>
			<td class="cau_status_interval"><?php echo $schedules[$setCoreInterval]['display']; ?></td>
			<td class="cau_status_next"><span class="cau_mobile_prefix"><?php _e( 'Next', 'companion-auto-update' ); ?>: </span><?php echo $setCoreNext; ?></td>
		</tr>
	</tbody>

</table>

<?php 

if( get_option( 'blog_public' ) == 0 ) { ?>

	<table class="cau_status_list widefat striped cau_status_warnings">

		<thead>
			<tr>
				<th class="cau_plugin_issue_name"><strong><?php _e( 'Search Engine Visibility' ); ?></strong></th>
				<th class="cau_plugin_issue_explain"> </th>
				<th class="cau_plugin_issue_fixit"><strong><?php _e( 'Fix it', 'companion-auto-update' ); ?></strong></th>
			</tr>
		</thead>

		<tbody id="the-list">
			<tr>
				<td class="cau_plugin_issue_name"><span class='cau_warning'><span class="dashicons dashicons-warning"></span> <?php _e( 'Warning', 'companion-auto-update' ); ?></span></td>
				<td class="cau_plugin_issue_explain">
					<?php _e( 'You’ve chosen to disscourage Search Engines from indexing your site. Auto-updating works best on sites with more traffic, consider enabling indexing for your site.', 'companion-auto-update' ); ?>
				</td>
				<td class="cau_plugin_issue_fixit">
					<a href="<?php echo admin_url( 'options-reading.php' ); ?>" class="button button-alt"><?php _e( 'Fix it', 'companion-auto-update' ); ?></a>
				</td>
			</tr>
		</tbody>

	</table>
    
<?php }

if( checkAutomaticUpdaterDisabled() ) { ?>

	<table class="cau_status_list widefat striped cau_status_warnings">

		<thead>
			<tr>
				<th class="cau_plugin_issue_name"><strong><?php _e( 'Critical Error', 'companion-auto-update' ); ?></strong></th>
				<th class="cau_plugin_issue_explain"> </th>
				<th class="cau_plugin_issue_explain"> </th>
				<th class="cau_plugin_issue_fixit"><strong><?php _e( 'How to fix', 'companion-auto-update' ); ?></strong></th>
			</tr>
		</thead>

		<tbody id="the-list">
			<tr>
				<td class="cau_plugin_issue_name"><span class='cau_disabled'><span class="dashicons dashicons-no"></span> <?php _e( 'Critical Error', 'companion-auto-update' ); ?></span></td>
				<td class="cau_plugin_issue_explain">
					<?php _e( 'Updating is globally disabled.', 'companion-auto-update' ); ?>
				</td>
				<td class="cau_plugin_issue_explain">
					<code>AUTOMATIC_UPDATER_DISABLED true</code>
				</td>
				<td class="cau_plugin_issue_fixit">
					<form method="POST">
						<?php wp_nonce_field( 'cau_fixit' ); ?>
						<button type="submit" name="fixit" class="button button-primary"><?php _e( 'Fix it', 'companion-auto-update' ); ?></button>
						<a href="<?php echo cau_url( 'support' ); ?>" class="button"><?php _e( 'Contact for support', 'companion-auto-update' ); ?></a>
					</form>
				</td>
			</tr>
		</tbody>

	</table>

<?php } 

if( checkCronjobsDisabled() ) { ?>

	<table class="cau_status_list widefat striped cau_status_warnings">

		<thead>
			<tr>
				<th class="cau_plugin_issue_name"><strong><?php _e( 'Warning', 'companion-auto-update' ); ?></strong></th>
				<th class="cau_plugin_issue_explain"> </th>
				<th class="cau_plugin_issue_explain"> </th>
				<th class="cau_plugin_issue_fixit"><strong><?php _e( 'How to fix', 'companion-auto-update' ); ?></strong></th>
			</tr>
		</thead>

		<tbody id="the-list">
			<tr>
				<td class="cau_plugin_issue_name"><span class='cau_warning'><span class="dashicons dashicons-warning"></span> <?php _e( 'Warning', 'companion-auto-update' ); ?></span></td>
				<td class="cau_plugin_issue_explain">
					<?php _e( 'Cronjobs are disabled.', 'companion-auto-update' ); ?>
				</td>
				<td class="cau_plugin_issue_explain">
					<code>DISABLE_WP_CRON true</code>
				</td>
				<td class="cau_plugin_issue_fixit">
					<a href="<?php echo cau_url( 'support' ); ?>" class="button"><?php _e( 'Contact for support', 'companion-auto-update' ); ?></a>
				</td>
			</tr>
		</tbody>

	</table>

<?php } 

// Remove the line
if( isset( $_POST['fixit'] ) ) {
	check_admin_referer( 'cau_fixit' );
	cau_removeErrorLine();
	echo "<div id='message' class='updated'><p><strong>".__( 'Error fixed', 'companion-auto-update' )."</strong></p></div>";
}

// Get wp-config location
function cau_configFile() {

	// Config file
	if ( file_exists( ABSPATH . 'wp-config.php') ) {
		$conFile = ABSPATH . 'wp-config.php';
	} else {
		$conFile = dirname(ABSPATH) . '/wp-config.php';
	}

	return $conFile;

}

// Change the AUTOMATIC_UPDATER_DISABLED line
function cau_removeErrorLine() {

	// Config file
	$conFile = cau_configFile();

	// Lines to check and replace
	$revLine 		= "define('AUTOMATIC_UPDATER_DISABLED', false);"; // We could just remove the line, but replacing it will be safer
	$posibleLines 	= array( "define( 'AUTOMATIC_UPDATER_DISABLED', true );", "define( 'AUTOMATIC_UPDATER_DISABLED', minor );" ); // The two base options
	foreach ( $posibleLines as $value ) array_push( $posibleLines, strtolower( $value ) ); // Support lowercase variants
	foreach ( $posibleLines as $value ) array_push( $posibleLines, str_replace( ' ', '', $value ) ); // For variants without spaces

	// Check for each string if it exists
	foreach ( $posibleLines as $key => $string ) {

		if( strpos( file_get_contents( $conFile ), $string ) !== false) {
	        $contents = file_get_contents( $conFile );
			$contents = str_replace( $string, $revLine, $contents );
			file_put_contents( $conFile, $contents );
	    }

	}

}

// If has incomptable plugins
if( cau_incompatiblePlugins() ) { ?>

	<p>&nbsp;</p>
	<h2 style="margin-bottom: 3px"><?php _e('Possible plugin issues', 'companion-auto-update'); ?></h2>
	<span class='cau_disabled'><?php _e("You're using one or more plugins that <i>might</i> cause issues.", "companion-auto-update"); ?></span>

	<table class="cau_status_list widefat striped cau_status_warnings">

		<thead>
			<tr>
				<th class="cau_plugin_issue_name"><strong><?php _e( 'Name', 'companion-auto-update' ); ?></strong></th>
				<th class="cau_plugin_issue_explain"><strong><?php _e( 'Possible issue', 'companion-auto-update' ); ?></strong></th>
				<th class="cau_plugin_issue_fixit"><strong><?php _e( 'How to fix', 'companion-auto-update' ); ?></strong></th>
			</tr>
		</thead>

		<tbody id="the-list">
			<?php
			foreach ( cau_incompatiblePluginlist() as $key => $value ) {
				if( is_plugin_active( $key ) ) {

					echo '<tr>
						<td class="cau_plugin_issue_name">'.$key.'</td>
						<td class="cau_plugin_issue_explain">'.$value.'</td>
						<td class="cau_plugin_issue_fixit"><a href="https://codeermeneer.nl/documentation/known-issues-fixes/#plugins" target="_blank" class="button">'.__( 'How to fix', 'companion-auto-update' ).'</a></td>
					</tr>';
				
				}
			}
			?>
		</tbody>

	</table>

<?php } ?>

	<table class="autoupdate cau_status_list widefat striped cau_status_warnings">

		<thead>
			<tr>
				<th colspan="2"><strong><?php _e( 'Systeminfo', 'companion-auto-update' ); ?></strong></th>
			</tr>
		</thead>

		<tbody id="the-list">
			<tr>
				<td width="200">WordPress</td>
				<td><?php echo get_bloginfo( 'version' ); ?></td>
			</tr>
			<tr>
				<td>PHP</td>
				<td><?php echo phpversion(); ?></td>
			</tr>
			<tr <?php if( cau_incorrectDatabaseVersion() ) { echo "class='inactive'"; } ?>>
				<td>Database</td>
				<td><?php echo get_option( "cau_db_version" ); ?> <code>(Latest: <?php echo cau_db_version(); ?>)</code></td>
			</tr>
			<tr>
				<td class="cau_status_name"><?php _e( 'Timezone' ); ?></td>
				<td class="cau_status_active_state"><?php echo cau_get_proper_timezone(); ?> (GMT <?php echo get_option('gmt_offset'); ?>) - <?php echo date_default_timezone_get(); ?></td>
			</tr>
		</tbody>

	</table>

	<table class="autoupdate cau_status_list widefat striped cau_status_warnings">

		<thead>
			<tr>
				<th><strong><?php _e( 'Advanced info', 'companion-auto-update' ); ?></strong> &dash; <?php _e( 'For when you need our help fixing an issue.', 'companion-auto-update' ); ?></th>
			</tr>
		</thead>
		<tbody id="the-list">
			<tr>
				<td>
					<div class='button button-primary toggle_advanced_button'>Toggle</div>
				
					<div class='toggle_advanced_content' style='display: none;'>
						<?php 
						global $wpdb;
						$autoupdates 	= $wpdb->prefix."auto_updates"; 
						$cau_configs 	= $wpdb->get_results( "SELECT * FROM $autoupdates" ); 

						echo "<pre>";
						print_r( $cau_configs );
						echo "</pre>";
						?>
					</div>
				</td>
			</tr>
		</tbody>
	</table>

</div>

<script>jQuery( '.toggle_advanced_button' ).click( function() { jQuery( '.toggle_advanced_content' ).toggle(); });</script>