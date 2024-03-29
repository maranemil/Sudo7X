<?php /** @noinspection PhpUnused */
/** @noinspection PhpUndefinedClassInspection */
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 31.03.15
 * Time: 21:45
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once("modules/Users/User.php");

/**
 * @property $id
 * @property $user_name
 */
class CustomSudo extends User
{

    /**
     * @return mixed
     */
    public function get_list_view_data()
    {
        $temp_array = parent::get_list_view_data(); //let it work as it does by default

        if (!empty($temp_array['USER_NAME'])) {
            $temp_array['USER_NAME'] = "<a href='index.php?module=Users&action=SudoSwitch&record=$this->id'>Sudo
             <img src='themes/Sugar/images/ACLRoles.gif' alt=>
             <br /> $this->user_name </a>";
        }
        return $temp_array;
    }
}