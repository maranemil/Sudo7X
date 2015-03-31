<?php
/*
global $sudo_user;

if(!empty($_SESSION['sudo_user']) && is_admin($_SESSION['sudo_user'])) {
	global $current_user;

    $user_focus = BeanFactory::getBean('Users');
    $user_focus->retrieve($_SESSION['sudo_user_id']);
    if($user_focus->is_admin)
    {
        $_SESSION['sudo_user_id'] = null;
        $GLOBALS['current_user'] = $user_focus;
        $current_user = $user_focus;
        $_SESSION['authenticated_user_id'] = $user_focus->id;
        unset($_SESSION['sudo_user']);
        header('Location: index.php?module=Users&action=ListView');
    }
}
*/
