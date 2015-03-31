<?php
/**
 * Login as another user in SugarCRM and switch back to admin user
 *
 * Simply put this file into a custom entry point file and
 * browse to it with the parameters 'user_name' or 'back_to_sudo'
 *
 * Usage:
 *    http://xxxxxxxxx/index.php?entryPoint=my_awesome_entry_point&user_name=mylittlepony
 *    http://xxxxxxxxx/index.php?entryPoint=my_awesome_entry_point&back_to_sudo=1
 *
 * @author Karl Metum <karl.metum@codehacker.se>
 * @link http://www.codehacker.se
 */


// https://gist.github.com/karlingen/5265c27ad78fb83fb774

if(!empty($_GET['user_name']) && $GLOBALS['current_user']->is_admin)
{
    $user_focus = BeanFactory::getBean('Users');
    $user_focus->retrieve_by_string_fields(array('user_name' => $_GET['user_name']));
    if(!empty($user_focus->id))
    {
        if(empty($_SESSION['sudo_user_id']))
            $_SESSION['sudo_user_id'] = $GLOBALS['current_user']->id;

        $GLOBALS['current_user'] = $user_focus;
        $_SESSION['authenticated_user_id'] = $user_focus->id;
        echo "Successfully logged in as " . $GLOBALS['current_user']->user_name;
        return;
    }
}
elseif(!empty($_GET['back_to_sudo']) && !empty($_SESSION['sudo_user_id']))
{
    $user_focus = BeanFactory::getBean('Users');
    $user_focus->retrieve($_SESSION['sudo_user_id']);
    if($user_focus->is_admin)
    {
        $_SESSION['sudo_user_id'] = null;
        $GLOBALS['current_user'] = $user_focus;
        $_SESSION['authenticated_user_id'] = $user_focus->id;
        echo "Successfully logged back to sudo user: " . $GLOBALS['current_user']->user_name;
        return;
    }
}

die("No dice.");