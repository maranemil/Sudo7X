<?php /** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedVariableInspection */
/** @noinspection PhpUndefinedFunctionInspection */
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/

global $db;
function displayAdminError($errorString)
{
    $output = '<p class="error">' . $errorString . '</p>';
    if (!empty($GLOBALS['buffer_system_notifications'])) {
        $GLOBALS['system_notification_count']++;
        $GLOBALS['system_notification_buffer'][] = $output;
    } else {
        echo $output;
    }
}

if (!empty($_SESSION['display_lotuslive_alert'])) {
    displayAdminError(translate('MSG_RECONNECT_LOTUSLIVE', 'Administration'));
}

if (is_admin($current_user) && !empty($GLOBALS['sugar_config']['fts_disable_notification'])) {
    displayAdminError(translate('LBL_FTS_DISABLED', 'Administration'));
}

if (isset($_SESSION['rebuild_relationships'])) {
    displayAdminError(translate('MSG_REBUILD_RELATIONSHIPS', 'Administration'));
}

if (isset($_SESSION['rebuild_extensions'])) {
    displayAdminError(translate('MSG_REBUILD_EXTENSIONS', 'Administration'));
}

if (empty($license)) {
    $license = new Administration();
    $license = $license->retrieveSettings('license');
}

// This section of code is a portion of the code referred
// to as Critical Control Software under the End User
// License Agreement.  Neither the Company nor the Users
// may modify any portion of the Critical Control Software.
if (!isset($_SESSION['LICENSE_EXPIRES_IN'])) {
    checkSystemLicenseStatus();
}

if (!ocLicense() && isset($_SESSION['LICENSE_EXPIRES_IN']) && $_SESSION['LICENSE_EXPIRES_IN'] !== 'valid') {
    if ((!is_admin($current_user) && $_SESSION['LICENSE_EXPIRES_IN'] < -1) || ($_SESSION['LICENSE_EXPIRES_IN'] < -7)) {
        setSystemState('LICENSE_KEY');
    }
}

if (!ocLicense() && isset($_SESSION['VALIDATION_EXPIRES_IN']) && $_SESSION['VALIDATION_EXPIRES_IN'] !== 'valid') {
    if ((!is_admin($current_user) && $_SESSION['VALIDATION_EXPIRES_IN'] < -1) || ($_SESSION['VALIDATION_EXPIRES_IN'] < -7)) {
        setSystemState('LICENSE_KEY');
    }
}
//END REQUIRED CODE DO NOT MODIFY

#if (!empty($_SESSION['HomeOnly'])) {
    #displayAdminError(translate('FATAL_LICENSE_ALTERED', 'Administration'));
#}

if (isset($license) && !empty($license->settings['license_msg_all'])) {
    displayAdminError(base64_decode($license->settings['license_msg_all']));
}
if ((strpos($_SERVER["SERVER_SOFTWARE"], 'Microsoft-IIS') !== false) &&
    (PHP_SAPI === 'cgi-fcgi') &&
    (ini_get('fastcgi.logging') !== '0')) {
    displayAdminError(translate('LBL_FASTCGI_LOGGING', 'Administration'));
}
if (is_admin($current_user)) {
    if (!empty($_SESSION['COULD_NOT_CONNECT'])) {
        displayAdminError(translate('LBL_COULD_NOT_CONNECT', 'Administration') . ' ' . $timedate->to_display_date_time($_SESSION['COULD_NOT_CONNECT']));
    }
    if (!empty($_SESSION['EXCEEDING_OC_LICENSES']) && $_SESSION['EXCEEDING_OC_LICENSES'] === true) {
        displayAdminError(translate('LBL_EXCEEDING_OC_LICENSES', 'Administration'));
    }
    if (isset($license) && !empty($license->settings['license_msg_admin'])) {
        // UUDDLRLRBA
        $GLOBALS['log']->fatal(base64_decode($license->settings['license_msg_admin']));
        //displayAdminError(base64_decode($license->settings['license_msg_admin']));
        return;
    }

//No SMTP server is set up Error.
    $smtp_error = false;
    $admin = new Administration();
    $admin->retrieveSettings();

//If sendmail has been configured by setting the config variable ignore this warning
    $sendMailEnabled = isset($sugar_config['allow_sendmail_outbound']) && $sugar_config['allow_sendmail_outbound'];

    if (trim($admin->settings['mail_smtpserver']) === '' && !$sendMailEnabled) {
        if ($admin->settings['notify_on']) {
            $smtp_error = true;
        } else {
            $workflow = new WorkFlow();
            if ($workflow->getActiveWorkFlowCount() > 0) {
                $smtp_error = true;
            }
        }
    }

    if ($smtp_error) {
        displayAdminError(translate('WARN_NO_SMTP_SERVER_AVAILABLE_ERROR', 'Administration'));
    }

    if (!empty($dbconfig['db_host_name']) || $sugar_config['sugar_version'] !== $sugar_version) {
        displayAdminError(translate('WARN_REPAIR_CONFIG', 'Administration'));
    }

    if (!isset($sugar_config['installer_locked']) || $sugar_config['installer_locked'] === false) {
        displayAdminError(translate('WARN_INSTALLER_LOCKED', 'Administration'));
    }

// This section of code is a portion of the code referred
// to as Critical Control Software under the End User
// License Agreement.  Neither the Company nor the Users
// may modify any portion of the Critical Control Software.

    if (!ocLicense() && isset($_SESSION['LICENSE_EXPIRES_IN']) &&
        strcmp($_SESSION['LICENSE_EXPIRES_IN'], 'valid') !== 0) {
        if (strcmp($_SESSION['LICENSE_EXPIRES_IN'], 'REQUIRED') === 0) {
            setSystemState('LICENSE_KEY');
            displayAdminError(translate('FATAL_LICENSE_REQUIRED', 'Administration'));
        } else if ($_SESSION['LICENSE_EXPIRES_IN'] < 0) {
            if ($_SESSION['LICENSE_EXPIRES_IN'] < -30) {
                setSystemState('LICENSE_KEY');
                displayAdminError(translate('FATAL_LICENSE_EXPIRED', 'Administration') . " [" . abs($_SESSION['LICENSE_EXPIRES_IN']) . " day(s) ] .<br> " . translate('FATAL_LICENSE_EXPIRED2', 'Administration'));
            } else {
                displayAdminError(translate('ERROR_LICENSE_EXPIRED', 'Administration') . abs($_SESSION['LICENSE_EXPIRES_IN']) . translate('ERROR_LICENSE_EXPIRED2', 'Administration'));
            }
        } else {
            displayAdminError(translate('WARN_LICENSE_EXPIRED', 'Administration') . $_SESSION['LICENSE_EXPIRES_IN'] . translate('WARN_LICENSE_EXPIRED2', 'Administration'));
        }
    } elseif (!ocLicense() && strcmp($_SESSION['VALIDATION_EXPIRES_IN'], 'valid') !== 0) {
        if (strcmp($_SESSION['VALIDATION_EXPIRES_IN'], 'REQUIRED') === 0) {
            setSystemState('LICENSE_KEY');
            displayAdminError(translate('FATAL_VALIDATION_REQUIRED', 'Administration'));
        } else if ($_SESSION['VALIDATION_EXPIRES_IN'] < 0) {
            if ($_SESSION['VALIDATION_EXPIRES_IN'] < -30) {
                setSystemState('LICENSE_KEY');
                displayAdminError(translate('FATAL_VALIDATION_EXPIRED', 'Administration') . " [" . abs($_SESSION['VALIDATION_EXPIRES_IN']) . " day(s) ] .<br>   " . translate('FATAL_VALIDATION_EXPIRED2', 'Administration'));
            } else {
                displayAdminError(translate('ERROR_VALIDATION_EXPIRED', 'Administration') . abs($_SESSION['VALIDATION_EXPIRES_IN']) . translate('ERROR_VALIDATION_EXPIRED2', 'Administration'));
            }
        } else {
            displayAdminError(translate('WARN_VALIDATION_EXPIRED', 'Administration') . $_SESSION['VALIDATION_EXPIRES_IN'] . translate('WARN_VALIDATION_EXPIRED2', 'Administration'));
        }
    }

    if (!isset($_SESSION['license_seats_needed'])) {
        $focus = new Administration();
        $focus->retrieveSettings();
        $license_users = isset($focus->settings['license_users']) ? $focus->settings['license_users'] : '';

        $_SESSION['license_seats_needed'] = count(get_user_array(false, "", "", false, null, " AND " . User::getLicensedUsersWhere(), false)) - $license_users;
    }

    if ($_SESSION['license_seats_needed'] > 0) {
        displayAdminError(translate('WARN_LICENSE_SEATS', 'Administration') . $_SESSION['license_seats_needed'] . translate('WARN_LICENSE_SEATS2', 'Administration'));
    }
    //END REQUIRED CODE DO NOT MODIFY
    if (empty($GLOBALS['sugar_config']['admin_access_control'])) {
        if (isset($_SESSION['invalid_versions'])) {
            $invalid_versions = $_SESSION['invalid_versions'];
            foreach ($invalid_versions as $invalid) {
                displayAdminError(translate('WARN_UPGRADE', 'Administration') . $invalid['name'] . translate('WARN_UPGRADE2', 'Administration'));
            }
        }

        if (isset($_SESSION['available_version']) && $_SESSION['available_version'] !== $sugar_version) {
            displayAdminError(translate('WARN_UPGRADENOTE', 'Administration') . $_SESSION['available_version_description']);
        }
    }

//		if (!isset($_SESSION['dst_fixed']) || $_SESSION['dst_fixed'] != true) {
//			$qDst = "SELECT count(*) AS dst FROM versions WHERE name = 'DST Fix'";
//			$rDst = $db->query($qDst);
//			$rowsDst = $db->fetchByAssoc($rDst);
//			if($rowsDst['dst'] > 0) {
//				$_SESSION['dst_fixed'] = true;
//			} else {
//				$_SESSION['dst_fixed'] = false;
//				displayAdminError($app_strings['LBL_DST_NEEDS_FIXIN']);
//			}
//
//		}

    if (isset($_SESSION['administrator_error'])) {
        // Only print DB errors once otherwise they will still look broken
        // after they are fixed.
        displayAdminError($_SESSION['administrator_error']);
    }

    unset($_SESSION['administrator_error']);
}


