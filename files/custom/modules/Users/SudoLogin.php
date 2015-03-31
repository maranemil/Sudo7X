<?php

global $current_user;
if(is_admin($current_user) && !empty($_REQUEST['record'])) {
    require_once('modules/Users/User.php');

    $user_focus = BeanFactory::getBean('Users');
    //$user_focus->retrieve_by_string_fields(array('user_name' => $_GET['record']));
    $user_focus->retrieve($_GET['record']);
    if(!empty($user_focus->id))
    {
        if(empty($_SESSION['sudo_user_id'])){
            $_SESSION['sudo_user'] = $GLOBALS['current_user'];
            $_SESSION['sudo_user_id'] = $GLOBALS['current_user']->id;
        }

        $GLOBALS['current_user'] = $user_focus;
        $current_user = $user_focus;
        $_SESSION['authenticated_user_id'] = $user_focus->id;
        header('Location: index.php?module=Home&action=index');
    }
}