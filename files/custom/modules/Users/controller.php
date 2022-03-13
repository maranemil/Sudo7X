<?php /** @noinspection PhpUndefinedClassInspection */
/** @noinspection AutoloadingIssuesInspection */
/** @noinspection PhpUnused */
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 31.03.15
 * Time: 21:49
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/Controller/SugarController.php');
require_once('custom/modules/Users/CustomSudo.php');

/**
 * @property CustomSudo $bean
 */
class CustomUsersController extends SugarController
{
    public function action_listview()
    {
        $this->bean = new CustomSudo();
        parent::action_listview();
    }
}