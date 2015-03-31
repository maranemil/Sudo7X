<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $mod_strings, $app_strings;
global $current_user, $sugar_config;

$module_menu=Array();
if($GLOBALS['current_user']->isAdminForModule('Users'))
{
    $module_menu = Array(
        Array("index.php?module=Users&action=EditView&return_module=Users&return_action=DetailView", $mod_strings['LNK_NEW_USER'],"CreateUsers"),
        Array("index.php?module=Users&action=EditView&usertype=group&return_module=Users&return_action=DetailView", $mod_strings['LNK_NEW_GROUP_USER'],"CreateUsers")
    );

    if (isset($sugar_config['enable_web_services_user_creation']) && $sugar_config['enable_web_services_user_creation']) {
        $module_menu[] = Array("index.php?module=Users&action=EditView&usertype=portal&return_module=Users&return_action=DetailView", $mod_strings['LNK_NEW_PORTAL_USER'],"CreateUsers");
    }

    $module_menu[] = Array("index.php?module=Users&action=ListView&return_module=Users&return_action=DetailView", $mod_strings['LNK_USER_LIST'],"Users");
    $module_menu[] = Array("index.php?module=Users&action=reassignUserRecords", $mod_strings['LNK_REASSIGN_RECORDS'],"ReassignRecords");
    $module_menu[] = Array("index.php?module=Import&action=Step1&import_module=Users&return_module=Users&return_action=index", $mod_strings['LNK_IMPORT_USERS'],"Import", 'Contacts');

    if(isset($_REQUEST['record'])){
        require_once('modules/Users/User.php');
        $log_user = new User();
        $log_user->retrieve($_REQUEST['record']);
        $module_menu[] = Array("index.php?module=Users&action=SudoSwitch&record=".$_REQUEST['record'], $mod_strings['LBL_LOGIN_AS'].$log_user->user_name,"SudoSwitch");
    }
}

if(!empty($_SESSION['sudo_user'])) {
    $module_menu[] = Array("index.php?module=Users&action=SudoSwitch", $mod_strings['LBL_LOGOUT_AS'].$current_user->user_name,"SudoSwitch");
}

?>
