<?php

// Get database value
function cau_get_db_value( $name, $table = 'auto_updates' ) {

	global $wpdb;
	$table_name 	= $wpdb->prefix.$table; 
	$cau_configs 	= $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table_name} WHERE name = '%s'", $name ) );
	foreach ( $cau_configs as $config ) return $config->onoroff;

}

// Get database value
function cau_get_plugininfo( $check, $field ) {

	global $wpdb;
	$table_name 	= $wpdb->prefix.'update_log'; 
	$cau_configs 	= $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table_name} WHERE slug = '%s'", $check ) );
	foreach ( $cau_configs as $config ) return $config->$field;

}

// Get the set timezone
function cau_get_proper_timezone() {

	// WP 5.3 adds the wp_timezone_string function
	if ( !function_exists( 'wp_timezone_string' ) ) {
		$timezone = get_option( 'timezone_string' ); 
	} else {
		$timezone = wp_timezone_string(); 
	}

	// Should fix an reported issue
	if( $timezone == '+00:00' ) {
		$timezone = 'UTC';
	}

	return $timezone;

}

// Copy of the wp_timezone_string for < 5.3 compat
if ( !function_exists( 'wp_timezone_string' ) ) {
	function wp_timezone_string() {
	    $timezone_string = get_option( 'timezone_string' );
	 
	    if ( $timezone_string ) {
	        return $timezone_string;
	    }
	 
	    $offset  = (float) get_option( 'gmt_offset' );
	    $hours   = (int) $offset;
	    $minutes = ( $offset - $hours );
	 
	    $sign      = ( $offset < 0 ) ? '-' : '+';
	    $abs_hour  = abs( $hours );
	    $abs_mins  = abs( $minutes * 60 );
	    $tz_offset = sprintf( '%s%02d:%02d', $sign, $abs_hour, $abs_mins );
	 
	    return $tz_offset;
	}
}

// List of incompatible plugins
function cau_incompatiblePluginlist() {

	// Pluginlist, write as Plugin path => Issue
	$pluginList = array( 
		'better-wp-security/better-wp-security.php' => 'May block auto-updating for everything.', 
		'updraftplus/updraftplus.php' 				=> 'Does not update automatically, needs to be done manually. Causes no issues with other plugins.' 
	);

	return $pluginList;

}
function cau_incompatiblePlugins() {

	$return	= false;

	foreach ( cau_incompatiblePluginlist() as $key => $value ) {
		if( is_plugin_active( $key ) ) {
			$return = true;
		}
	}

	return $return;

}

// Check if has issues
function cau_pluginHasIssues() {

	$return = false;

	if( get_option( 'blog_public' ) == 0 ) {
		$return 	= true;
	}

	if( checkAutomaticUpdaterDisabled() ) {
		$return 	= true;
	}

	if( checkCronjobsDisabled() ) {
		$return 	= true;
	}

	if( cau_incorrectDatabaseVersion() ) {
		$return 	= true;
	}

	return $return;
}
function cau_pluginIssueLevels() {
	
	if( checkAutomaticUpdaterDisabled() ) {
		$level = 'high';
	} else {
		$level = 'low';
	}

	return $level;
}
function cau_pluginIssueCount() {
	
	$count = 0;

	if( get_option( 'blog_public' ) == 0 ) {
		$count++;
	}
	if( checkAutomaticUpdaterDisabled() ) {
		$count++;
	}
	if( checkCronjobsDisabled() ) {
		$count++;
	}
	if( cau_incompatiblePlugins() ) {
		foreach ( cau_incompatiblePluginlist() as $key => $value ) {
			if( is_plugin_active( $key ) ) {
				$count++;
			}
		}
	}

	return $count;
}
function cau_incorrectDatabaseVersion() {
	if( get_option( "cau_db_version" ) != cau_db_version() ) {
		return true;
	} else {
		return false;
	}
}

// Run custom hooks on plugin update
function cau_run_custom_hooks_p() {

	// Create array
	$allDates 	= array();

	// Where to look for plugins
	$dirr    	= plugin_dir_path( __DIR__ );
	$listOfAll 	= get_plugins();

	// Loop trough all plugins
	foreach ( $listOfAll as $key => $value ) {

		// Get data
		$fullPath 		= $dirr.'/'.$key;
		$fileDate 		= date ( 'YmdHi', filemtime( $fullPath ) );
		$fileTime 		= date ( 'Hi', filemtime( $fullPath ) );
		$updateSched 	= wp_get_schedule( 'wp_update_plugins' );

		// Check when the last update was
		if( $updateSched == 'hourly' ) {
			$lastday = date( 'YmdHi', strtotime( '-1 hour' ) );
		} elseif( $updateSched == 'twicedaily' ) {
			$lastday = date( 'YmdHi', strtotime( '-12 hours' ) );
		} elseif( $updateSched == 'daily' ) {
			$lastday = date( 'YmdHi', strtotime( '-1 day' ) );
		}

		$update_time 	= wp_next_scheduled( 'wp_update_plugins' );
		$range_start 	= date( 'Hi', strtotime( '-30 minutes', $update_time ) );
		$range_end 		= date( 'Hi', strtotime( '+30 minutes', $update_time ) );

		if( $fileDate >= $lastday ) {

			// Push to array
			array_push( $allDates, $fileDate );

			// Update info
			if( $fileTime > $range_start && $fileTime < $range_end ) {
				$status = __( 'Automatic', 'companion-auto-update' );
			} else {
				$status = __( 'Manual', 'companion-auto-update' );
			}
			cau_updatePluginInformation( $key, $status );

		}

	}

	$totalNum = 0;

	// Count number of updated plugins
	foreach ( $allDates as $key => $value ) $totalNum++;

	// If there have been plugin updates run hook
	if( $totalNum > 0 ) {
		do_action( 'cau_after_plugin_update' );
	}

}

// Run custom hooks on theme update
function cau_run_custom_hooks_t() {

	// Create array
	$allDates 	= array();

	// Where to look for plugins
	$dirr    	= get_theme_root();
	$listOfAll 	= wp_get_themes();

	// Loop trough all plugins
	foreach ( $listOfAll as $key => $value) {

		// Get data
		$fullPath 		= $dirr.'/'.$key;
		$fileDate 		= date ( 'YmdHi', filemtime( $fullPath ) );
		$updateSched 	= wp_get_schedule( 'wp_update_themes' );

		// Check when the last update was
		if( $updateSched == 'hourly' ) {
			$lastday = date( 'YmdHi', strtotime( '-1 hour' ) );
		} elseif( $updateSched == 'twicedaily' ) {
			$lastday = date( 'YmdHi', strtotime( '-12 hours' ) );
		} elseif( $updateSched == 'daily' ) {
			$lastday = date( 'YmdHi', strtotime( '-1 day' ) );
		}

		// Push to array
		if( $fileDate >= $lastday ) {
			array_push( $allDates, $fileDate );
		}

	}

	$totalNum = 0;

	// Count number of updated plugins
	foreach ( $allDates as $key => $value ) $totalNum++;

	// If there have been plugin updates run hook
	if( $totalNum > 0 ) {
		do_action( 'cau_after_theme_update' );
	}

}

// Check if automatic updating is disabled globally
function checkAutomaticUpdaterDisabled() {

	// I mean, I know this can be done waaaay better but I's quite late and I need to push a fix so take it or leave it untill I decide to fix this :)

	if ( defined( 'automatic_updater_disabled' ) ) {
		if( doing_filter( 'automatic_updater_disabled' ) ) {
			return true;
		} elseif( constant( 'automatic_updater_disabled' ) == 'true' ) {
			return true;
		} elseif( constant( 'automatic_updater_disabled' ) == 'minor' ) {
			return true;
		} else {
			return false;
		}

	} else if ( defined( 'AUTOMATIC_UPDATER_DISABLED' ) ) {
		if( doing_filter( 'AUTOMATIC_UPDATER_DISABLED' ) ) {
			return true;
		} elseif( constant( 'AUTOMATIC_UPDATER_DISABLED' ) == 'true' ) {
			return true;
		} elseif( constant( 'AUTOMATIC_UPDATER_DISABLED' ) == 'minor' ) {
			return true;
		} else {
			return false;
		}

	} else {
		return false;
	}

}

// Check if cronjobs are disabled
function checkCronjobsDisabled() {

	// I mean, I know this can be done waaaay better but I's quite late and I need to push a fix so take it or leave it untill I decide to fix this :)

	if ( defined( 'disable_wp_cron' ) ) {
		if( constant( 'disable_wp_cron' ) == 'true' ) {
			return true;
		} else {
			return false;
		}

	} else if ( defined( 'DISABLE_WP_CRON' ) ) {
		if( constant( 'DISABLE_WP_CRON' ) == 'true' ) {
			return true;
		} else {
			return false;
		}

	} else {
		return false;
	}

}

// Menu location
function cau_menloc( $after = '' ) {
	return 'tools.php'.$after;
}
function cau_url( $tab = '' ) {
	return admin_url( cau_menloc( '?page=cau-settings&tab='.$tab ) );
}

// Get the active tab
function active_tab( $page, $identifier = 'tab' ) {
	echo _active_tab( $page, $identifier );
}
function _active_tab( $page, $identifier = 'tab' ) {

	if( !isset( $_GET[ $identifier ] ) ) {
		$cur_page = '';
	} else {
		$cur_page = $_GET[ $identifier ];
	}

	if( $page == $cur_page ) {
		return 'nav-tab-active';
	}

}

// Get the active subtab
function active_subtab( $page, $identifier = 'tab' ) {

	if( !isset( $_GET[ $identifier ] ) ) {
		$cur_page = '';
	} else {
		$cur_page = $_GET[ $identifier ];
	}

	if( $page == $cur_page ) {
		echo 'current';
	}

}

// List of plugins that should not be updated
function donotupdatelist( $filter = 'plugins' ) {

	// Select correct database row
	switch ( $filter ) {
		case 'themes':
			$db_table 		= 'notUpdateListTh';
			break;
		case 'plugins':
			$db_table 		= 'notUpdateList';
			break;
		default:
			$db_table 		= 'notUpdateList';
			break;
	}

	// Create list
	global $wpdb;
	$table_name 	= $wpdb->prefix."auto_updates"; 
	$config 		= $wpdb->get_results( "SELECT * FROM {$table_name} WHERE name = '{$db_table}'");

	$list 			= $config[0]->onoroff;
	$list 			= explode( ", ", $list );
	$returnList 	= array();

	foreach ( $list as $key ) array_push( $returnList, $key );
	
	return $returnList;

}
function plugins_donotupdatelist() {
	return donotupdatelist( 'plugins' );
}
function themes_donotupdatelist() {
	return donotupdatelist( 'themes' );
}

// Show the update log
function cau_fetch_log( $limit, $format = 'simple' ) {

	// Database
	global $wpdb;
	$updateLog 		= "update_log"; 
	$updateLogDB 	= $wpdb->prefix.$updateLog;

	// Filter log
	if( isset( $_GET['filter'] ) ) {
		$filter = $_GET['filter'];
	} else {
		$filter = 'all';
	}

	switch( $filter ) {

		case 'plugins':
			$plugins 		= true;
			$themes 		= false;
			$core 			= false;
			$translations 	= false;
			break;

		case 'themes':
			$plugins 		= false;
			$themes 		= true;
			$core 			= false;
			$translations 	= false;
			break;

		case 'translations':
			$plugins 		= false;
			$themes 		= false;
			$core 			= false;
			$translations 	= true;
			break;
		
		default:
			$plugins 		= true;
			$themes 		= true;
			$core 			= true;
			$translations 	= false;
			break;
	}

	// Create arrays
	$pluginNames 	= array();
	$pluginVersion 	= array();
	$pluginDates 	= array();
	$pluginDatesF 	= array();
	$plugslug 		= array();
	$type 			= array();
	$method 		= array();

	// Date format
	$dateFormat = get_option( 'date_format' );

	// PLUGINS
	if( $plugins ) {

		// Where to look for plugins
		$plugdir    = plugin_dir_path( __DIR__ );
		$allPlugins = get_plugins();

		// Loop trough all plugins
		foreach ( $allPlugins as $key => $value) {

			// Get plugin data
			$fullPath 		= $plugdir.'/'.$key;
			$getFile 		= $path_parts = pathinfo( $fullPath );
			$pluginData 	= get_plugin_data( $fullPath );
			$pluginSlug 	= explode( "/", plugin_basename( $key ) );
			$pluginSlug		= $pluginSlug[0];

	        array_push( $plugslug , $pluginSlug );

	        // Automatic or Manual (non-db-version)
			$date_tod 		= date ( 'ydm' );
			$fileDay 		= date ( 'ydm', filemtime( $fullPath ) );
			$fileTime 		= date ( 'Hi', filemtime( $fullPath ) );
			$updateSched 	= wp_next_scheduled( 'wp_update_plugins' );
			$range_start 	= date( 'Hi', strtotime( '-30 minutes', $updateSched ) );
			$range_end 		= date( 'Hi', strtotime( '+30 minutes', $updateSched ) );

			if( $date_tod == $fileDay ) {

				if( $fileTime > $range_start && $fileTime < $range_end ) {
					$status = __( 'Automatic', 'companion-auto-update' );
				} else {
					$status = __( 'Manual', 'companion-auto-update' );
				}
				
				array_push( $method , $status );

			} else {

				// Get info from database
		        if( cau_check_if_exists( $key, 'slug', $updateLog ) ) {
		        	array_push( $method , cau_get_plugininfo( $key, 'method' ) );
		        } else {
		        	array_push( $method , '-' );
		        }

			}

			// Get plugin name
			foreach ( $pluginData as $dataKey => $dataValue ) {
				if( $dataKey == 'Name') {
					array_push( $pluginNames , $dataValue );
				}
				if( $dataKey == 'Version') {
					array_push( $pluginVersion , $dataValue );
				}
			}

			// Get last update date
			$fileDate 	= date ( 'YmdHi', filemtime( $fullPath ) );
			if( $format == 'table' ) {
				$fileDateF 	= date_i18n( $dateFormat, filemtime( $fullPath ) );
				$fileDateF .= ' &dash; '.date( 'H:i', filemtime( $fullPath ) );
			} else {
				$fileDateF 	= date_i18n( $dateFormat, filemtime( $fullPath ) );
			}
			array_push( $pluginDates, $fileDate );
			array_push( $pluginDatesF, $fileDateF );
			array_push( $type, 'Plugin' );

		}

	}

	// THEMES
	if( $themes ) {

		// Where to look for themes
		$themedir   = get_theme_root();
		$allThemes 	= wp_get_themes();

		// Loop trough all themes
		foreach ( $allThemes as $key => $value) {

			// Get theme data
			$fullPath 	= $themedir.'/'.$key;
			$getFile 	= $path_parts = pathinfo( $fullPath );

			// Get theme name
			$theme_data 	= wp_get_theme( $path_parts['filename'] );
			$themeName 		= $theme_data->get( 'Name' );
			$themeVersion 	= $theme_data->get( 'Version' ); 
			array_push( $pluginNames , $themeName ); 
			array_push( $pluginVersion , $themeVersion );

	        // Get info from database
	        array_push( $method , '-' );

			// Get last update date
			$fileDate 	= date( 'YmdHi', filemtime( $fullPath ) );

			if( $format == 'table' ) {
				$fileDateF 	= date_i18n( $dateFormat, filemtime( $fullPath ) );
				$fileDateF .= ' &dash; '.date ( 'H:i', filemtime( $fullPath ) );
			} else {
				$fileDateF 	= date_i18n( $dateFormat, filemtime( $fullPath ) );
			}

			array_push( $pluginDates, $fileDate );
			array_push( $pluginDatesF, $fileDateF );
			array_push( $type, 'Theme' );
			array_push( $plugslug , '' );

		}

	}

	// TRANSLATIONS
	if( $translations ) {

		// There is no way (at this time) to check if someone changed this link, so therefore it won't work when it's changed, sorry
		$transFolder = get_home_path().'wp-content/languages';
		if( file_exists( $transFolder ) ) {

			$allThemTranslations 	= array();
			$allThemTypes 			= array();

			$pt = __( 'Plugin translations', 'companion-auto-update' );
			$tt = __( 'Theme translations', 'companion-auto-update' );
			$ct = __( 'Core translations', 'companion-auto-update' );

			// Plugin translations
			$files = glob( $transFolder.'/plugins/*.{mo}', GLOB_BRACE );
			foreach( $files as $file ) {
				array_push( $allThemTranslations, $file );
				array_push( $allThemTypes, $pt );
			}

			// Theme translations
			$files = glob( $transFolder.'/themes/*.{mo}', GLOB_BRACE );
			foreach( $files as $file ) {
				array_push( $allThemTranslations, $file );
				array_push( $allThemTypes, $tt );
			}

			// Core translations
			$files = glob( $transFolder.'/*.{mo}', GLOB_BRACE );
			foreach( $files as $file ) {
				array_push( $allThemTranslations, $file );
				array_push( $allThemTypes, $ct );
			}

			foreach( $allThemTranslations as $key => $trans_file ) {

				$transDate 	= date( 'YmdHi', filemtime( $trans_file ) );

				if( $format == 'table' ) {
					$transDateF 	= date_i18n( $dateFormat, filemtime( $trans_file ) );
					$transDateF .= ' &dash; '.date ( 'H:i', filemtime( $trans_file ) );
				} else {
					$transDateF 	= date_i18n( $dateFormat, filemtime( $trans_file ) );
				}

				$trans_name 	= basename( $trans_file );
				$trans_name 	= str_replace( "-", " ", $trans_name );
				$trans_name 	= str_replace( ".mo", "", $trans_name );
				$trans_name 	= str_replace( ".json", "", $trans_name );
				$trans_lang 	= substr( $trans_name, strrpos( $trans_name, " " ) + 1 );
				$trans_name 	= str_replace( $trans_lang, "", $trans_name );
				$trans_lang 	= substr( $trans_lang, strrpos( $trans_lang, "_" ) + 1 );

				// Push
				array_push( $pluginNames, ucfirst( $trans_name ).': '.$trans_lang ); 
				array_push( $type, $allThemTypes[$key] ); 
				array_push( $pluginVersion, '-' );
				array_push( $pluginDates, $transDate );
				array_push( $pluginDatesF, $transDateF );
				array_push( $plugslug , '' );
		        array_push( $method , '-' );

		    }

		} else {
			$transDate 	= date('YmdHi');
			$transDateF 	= 'Could not read translations date.';

			array_push( $pluginNames, 'Translations' ); 
			array_push( $type, $trans_type.' translations' ); 
			array_push( $pluginVersion, '-' );
			array_push( $pluginDates, $transDate );
			array_push( $pluginDatesF, $transDateF );
			array_push( $plugslug , '' );

	        // Get info from database
	        array_push( $method , '-' );

		}

	}

	// CORE
	if( $core ) {

		// There is no way (at this time) to check if someone changed this link, so therefore it won't work when it's changed, sorry
		$coreFile = get_home_path().'wp-admin/about.php';
		if( file_exists( $coreFile ) ) {
			$coreDate 	= date( 'YmdHi', filemtime( $coreFile ) );

			if( $format == 'table' ) {
				$coreDateF 	= date_i18n( $dateFormat, filemtime( $coreFile ) );
				$coreDateF .= ' &dash; '.date ( 'H:i', filemtime( $coreFile ) );
			} else {
				$coreDateF 	= date_i18n( $dateFormat, filemtime( $coreFile ) );
			}

		} else {
			$coreDate 	= date('YmdHi');
			$coreDateF 	= 'Could not read core date.';
		}

		array_push( $pluginNames, 'WordPress' ); 
		array_push( $type, 'WordPress' ); 
		array_push( $pluginVersion, get_bloginfo( 'version' ) );
		array_push( $pluginDates, $coreDate );
		array_push( $pluginDatesF, $coreDateF );
		array_push( $plugslug , '' );

        // Get info from database
        array_push( $method , '-' );

	}

	// Sort array by date
	arsort( $pluginDates );

	if( $limit == 'all' ) {
		$limit = 999;
	}

	$listClasses = 'wp-list-table widefat autoupdate autoupdatelog';

	if( $format == 'table' ) {
		$listClasses .= ' autoupdatelog striped';
	} else {
		$listClasses .= ' autoupdatewidget';
	}

	echo '<table class="'.$listClasses.'">';

	// Show the last updated plugins
	if( $format == 'table' ) {

		echo '<thead>
			<tr>
				<th><strong>'.__( 'Name', 'companion-auto-update' ).'</strong></th>';
				if( !$translations ) echo '<th><strong>'.__( 'To version', 'companion-auto-update' ).'</strong></th>';
				echo '<th><strong>'.__( 'Type', 'companion-auto-update' ).'</strong></th>
				<th><strong>'.__( 'Last updated on', 'companion-auto-update' ).'</strong></th>
				<th><strong>'.__( 'Update method', 'companion-auto-update' ).'</strong></th>
			</tr>
		</thead>';

	}

	echo '<tbody id="the-list">';

	$loopings = 0;

	foreach ( $pluginDates as $key => $value ) {

		if( $loopings < $limit ) {

			echo '<tr>';

				if( $format == 'table' ) {
					$pluginName = $pluginNames[$key];
				} else {
					$pluginName = substr( $pluginNames[$key], 0, 25);
					if( strlen( $pluginNames[$key] ) > 25 ) {
						$pluginName .= '...';
					}
				}

				echo '<td class="column-updatetitle"><p><strong title="'. $pluginNames[$key] .'">'.cau_getChangelogUrl( $type[$key], $pluginNames[$key], $plugslug[$key] ).'</strong></p></td>';

				if( $format == 'table' ) {

					if( $type[$key] == 'Plugin' ) {
						$thisType = __( 'Plugin', 'companion-auto-update' );
					} else if( $type[$key] == 'Theme' ) {
						$thisType = __( 'Theme', 'companion-auto-update' );
					} else {
						$thisType = $type[$key];
					}

					if( !$translations ) echo '<td class="cau_hide_on_mobile column-version" style="min-width: 100px;"><p>'. $pluginVersion[$key] .'</p></td>';
					echo '<td class="cau_hide_on_mobile column-description"><p>'. $thisType .'</p></td>';

				}

				echo '<td class="column-date" style="min-width: 100px;"><p>'. $pluginDatesF[$key] .'</p></td>';

				if( $format == 'table' ) {
					echo '<td class="column-method"><p>'. $method[$key] .'</p></td>';
				}

			echo '</tr>';

			$loopings++;

		}

	}

	echo "</tbody></table>";

}

// Get the proper changelog URL
function cau_getChangelogUrl( $type, $name, $plugslug ) {

	switch( $type ) {
	    case 'WordPress':
	        $url = '';
	        break;
	    case 'Plugin':
	    	$url = admin_url( 'plugin-install.php?tab=plugin-information&plugin='.$plugslug.'&section=changelog&TB_iframe=true&width=772&height=772' );
	        break;
	    case 'Theme':
	        $url = '';
	        break;
	}

	if( !empty( $url ) ) {
		return '<a href="'.$url.'" class="thickbox open-plugin-details-modal" aria-label="More information about '.$name.'" data-title="'.$name.'">'.$name.'</a>';
	} else {
		return $name;
	}

}

// Only update plugins which are enabled
function cau_dontUpdatePlugins( $update, $item ) {

	$plugins = plugins_donotupdatelist();

    if ( in_array( $item->slug, $plugins ) ) {
    	return false; // Don't update these plugins
    } else {
    	return true; // Always update these plugins
    } 


}
function cau_dontUpdateThemes( $update, $item ) {

	$themes = themes_donotupdatelist();

	if( !empty( $themes ) ) {
	    if ( in_array( $item->slug, $themes ) ) {
	    	return false; // Don't update these themes
	    } else {
	    	return true; // Always update these themes
	    } 
	} else {
		return true;
	}


}

// Get plugin information of repository
function cau_plugin_info( $slug, $what ) {

	$slug 				= sanitize_title( $slug );
    $cau_transient_name = 'cau' . $slug;
    $cau_info 			= get_transient( $cau_transient_name );

    require_once( ABSPATH.'wp-admin/includes/plugin-install.php' );
	$cau_info = plugins_api( 'plugin_information', array( 'slug' => $slug ) );

	if ( ! $cau_info or is_wp_error( $cau_info ) ) {
        return false;
    }

    set_transient( $cau_transient_name, $cau_info, 3600 );

    switch ( $what ) {
    	case 'versions':
    		return $cau_info->versions;
    		break;
    	case 'version':
    		return $cau_info->version;
    		break;
    	case 'name':
    		return $cau_info->name;
    		break;
    	case 'slug':
    		return $cau_info->slug;
    		break;
    }

}

// Get plugin information of currently installed plugins
function cau_active_plugin_info( $slug, $what ) {

	$allPlugins = get_plugins();

	foreach ($allPlugins as $key => $value) {
		$thisSlug 	= explode('/', $key);
		$thisSlugE 	= $thisSlug[0];
		if( $thisSlug == $slug ) {

			if( $what == 'version' ) return $value['Version'];

		}
	}

}

// Remove update nag when major updates are disabled
function cau_hideUpdateNag() {

	global $wpdb;
	$table_name = $wpdb->prefix . "auto_updates"; 
	$configs 	= $wpdb->get_results( "SELECT * FROM {$table_name} WHERE name = 'major'");
	foreach ( $configs as $config ) {
		if( $config->onoroff != 'on' ) {
			remove_action( 'admin_notices', 'update_nag', 3 );
			remove_action( 'network_admin_notices', 'maintenance_nag', 10 );
		}
	}
}
 
add_action( 'admin_head', 'cau_hideUpdateNag', 100 );

// Add more intervals to event schedules
function cau_addMoreIntervals( $schedules ) {

	// Add a weekly interval.
	$schedules['weekly'] = array(
		'interval' => 604800,
		'display'  => __( 'Once Weekly' ),
	);
	
	// Add a twice montly interval.
	$schedules['twice_monthly'] = array(
		'interval' => 1317600,
		'display'  => __( 'Twice a month' ),
	);
	
	// Add a montly interval.
	$schedules['once_monthly'] = array(
		'interval' => 2635200,
		'display'  => __( 'Once a month' ),
	);

	return $schedules;

}
add_filter( 'cron_schedules', 'cau_addMoreIntervals' ); 

// Get only unique schedules
function cau_wp_get_schedules() {

	// Start variables
	$availableIntervals = wp_get_schedules();
	$array_unique 		= array();
	$intervalTimes 		= array();
	$intervalNames 		= array();
	$intervalUniques 	= array();
	$counter 			= 0;

	// Get all intervals
	foreach ( $availableIntervals as $key => $value ) {

		// Do a bunch of checks to format them the right way
		foreach ( $value as $display => $interval ) {

			if( $display == 'display' ) {
				$intervalNames[$counter] 	= $interval; // Add the display name (i.e. "Once a month" or "Once Daily")
				$counter++; // Make sure the next interval gets a new "key" value
			} else {
				if( $interval == '86400' ) $key = 'daily'; // Force the daily interval to be called daily, requires by a bunch of handles of this plugin
				$intervalTimes[$counter] 	= $key;  // Add the backend name (i.e. "once_monthly" or "daily") 
				$intervalUniques[$counter] 	= $interval;  // Add the unix timestamp of this interval, used to identify unique items
			}

		}

	}

	// Prevent duplicates
	foreach ( array_unique( $intervalUniques ) as $key => $value ) {
		// $value is the timestamp
		// $intervalTimes[$key] is the backend name
		// $intervalNames[$key] is the display name
		$array_unique[$intervalTimes[$key]] = $intervalNames[$key];
	}

	// Return the array
	return $array_unique;

} 

// Check if the update log db is empty
function cau_updateLogDBisEmpty() {

	global $wpdb;
	$updateDB 		= "update_log";
	$updateLog 		= $wpdb->prefix.$updateDB; 
	$row_count 		= $wpdb->get_var( "SELECT COUNT(*) FROM $updateLog" );

	if( $row_count > 0 ) {
		return false;
	} else {
		return true;
	}
}

// Plugin information to DB
function cau_savePluginInformation( $method = 'New' ) {

	global $wpdb;
	$updateDB 		= "update_log";
	$updateLog 		= $wpdb->prefix.$updateDB; 
	$allPlugins 	= get_plugins();

	foreach ( $allPlugins as $key => $value ) {
		if( !cau_check_if_exists( $key, 'slug', $updateDB ) ) $wpdb->insert( $updateLog, array( 'slug' => $key, 'oldVersion' => '-', 'method' => $method ) );
	}	

}

function cau_updatePluginInformation( $slug, $method = '-', $newVersion = '-' ) {

	global $wpdb;
	$updateDB 		= "update_log";
	$updateLog 		= $wpdb->prefix.$updateDB; 
	$wpdb->query( $wpdb->prepare( "UPDATE $updateLog SET newVersion = '%s', method = %s WHERE slug = '%s'", $newVersion, $method, $slug ) );

}

function cau_siteHealthSignature() {
	return '<p style="font-size: 12px; color: #707070;">'.__( 'This was reported by the Companion Auto Update plugin', 'companion-auto-update' ).'</p>';
}

function cau_add_siteHealthTest( $tests ) {
    $tests['direct']['cau_disabled'] = array( 'label' => __( 'Companion Auto Update', 'companion-auto-update' ), 'test'  => 'cau_disabled_test' );
    $tests['direct']['cau_cronjobs'] = array( 'label' => __( 'Companion Auto Update', 'companion-auto-update' ), 'test'  => 'cau_cronjobs_test' );
    $tests['direct']['cau_siteinde'] = array( 'label' => __( 'Companion Auto Update', 'companion-auto-update' ), 'test'  => 'cau_siteindex_test' );
    return $tests;
}
add_filter( 'site_status_tests', 'cau_add_siteHealthTest' );

function cau_siteindex_test() {
    $result = array(
        'label'       => __( 'Search Engine Visibility', 'companion-auto-update' ),
        'status'      => 'good',
        'badge'       => array(
            'label' => __( 'Performance' ),
            'color' => 'blue',
        ),
        'description' => sprintf( '<p>%s</p>', __( "Search Engines can index your site just fine.", 'companion-auto-update' ) ),
        'actions'     => '',
        'test'        => 'cau_siteinde',
    );
 
    if ( get_option( 'blog_public' ) == 0 ) {
        $result['status'] 		= 'recommended';
        $result['label'] 		= __( 'Search Engine Visibility ', 'companion-auto-update' );
        $result['description'] 	= sprintf( '<p>%s</p>', __( "You’ve chosen to disscourage Search Engines from indexing your site. Auto-updating works best on sites with more traffic, consider enabling indexing for your site.", 'companion-auto-update' ) );
        $result['actions'] 		.= sprintf( '<p><a href="%s">%s</a>', esc_url( admin_url( 'options-reading.php' ) ), __( 'Fix it', 'companion-auto-update' ) );
    }

    $result['actions'] 		.= cau_siteHealthSignature();
 
    return $result;
}
 
function cau_disabled_test() {
    $result = array(
        'label'       => __( 'Auto updating is enabled', 'companion-auto-update' ),
        'status'      => 'good',
        'badge'       => array(
            'label' => __( 'Security' ),
            'color' => 'blue',
        ),
        'description' => sprintf( '<p>%s</p>', __( "Automatic updating isn't disabled on this site.", 'companion-auto-update' ) ),
        'actions'     => '',
        'test'        => 'cau_disabled',
    );
 
    if ( checkAutomaticUpdaterDisabled() ) {
        $result['status'] 		= 'critical';
        $result['label'] 		= __( 'Auto updating is disabled', 'companion-auto-update' );
        $result['description'] 	= sprintf( '<p>%s</p>', __( "Automatic updating is disabled on this site by either WordPress, another plugin or your webhost.", 'companion-auto-update' ) );
        $result['description'] 	.= sprintf( '<p>%s</p>', __( "Error code", 'companion-auto-update' ).': <code>AUTOMATIC_UPDATER_DISABLED true</code>' );
        $result['actions'] 		.= sprintf( '<p><a href="%s">%s</a>', esc_url( cau_url( 'status' ) ), __( 'Fix it', 'companion-auto-update' ) );
        $result['actions'] 		.= sprintf( ' - <a href="%s">%s</a></p>', esc_url( cau_url( 'support' ) ), __( 'Contact for support', 'companion-auto-update' ) );
    }

    $result['actions'] 		.= cau_siteHealthSignature();
 
    return $result;
}

function cau_cronjobs_test() {
    $result = array(
        'label'       => __( 'Cronjobs are enabled', 'companion-auto-update' ),
        'status'      => 'good',
        'badge'       => array(
            'label' => __( 'Performance' ),
            'color' => 'blue',
        ),
        'description' => sprintf( '<p>%s</p>', __( "Cronjobs are enabled on this site.", 'companion-auto-update' ) ),
        'actions'     => '',
        'test'        => 'cau_cronjobs',
    );
 
    if ( checkCronjobsDisabled() ) {
        $result['status'] 		= 'recommended';
        $result['label'] 		= __( 'Cronjobs are disabled', 'companion-auto-update' );
        $result['description'] 	= sprintf( '<p>%s</p>', __( "Cronjobs are disabled on this site by either you, WordPress, another plugin or your webhost. Companion Auto Update might experience issues when cronjobs are disabled. ", 'companion-auto-update' ) );
        $result['description'] 	.= sprintf( '<p>%s</p>', __( "Error code", 'companion-auto-update' ).': <code>DISABLE_WP_CRON true</code>' );
        $result['actions'] 		.= sprintf( '<p><a href="%s">%s</a>', esc_url( cau_url( 'status' ) ), __( 'Fix it', 'companion-auto-update' ) );
        $result['actions'] 		.= sprintf( ' - <a href="%s">%s</a></p>', esc_url( cau_url( 'support' ) ), __( 'Contact for support', 'companion-auto-update' ) );
    }

    $result['actions'] 		.= cau_siteHealthSignature();
 
    return $result;
}