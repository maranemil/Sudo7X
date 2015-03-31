<?php

/**
 * Login as another user in SugarCRM and switch back to admin user
 *
 * @author Karl Metum <karl.metum@codehacker.se>
 * @author Emil Maran <maran.emil@gmail.com>
 * @link http://www.codehacker.se
 * @link http://www.maran-emil.de
 */

// Reference Code: 
// https://gist.github.com/karlingen/5265c27ad78fb83fb774

$manifest = array(
    'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
    'acceptable_sugar_versions' => array(
        'exact_matches' => array(),
        'regex_matches' => array(
            0 => "7*"
        ),
    ),
    'readme' => '',
    'key' => '',
    'author' => 'Emil Maran/Karl Metum',
    'description' => 'Sudo user for Sugar7X ',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'Sudo Pro Edition 7.*',
    'published_date' => '2015-03-31',
    'type' => 'module',
    'version' => '0.1.1',
    'remove_tables' => 'prompt',
);

$installdefs = array(
    'id' => 'Sudo7X',
    'copy' =>
        array(
            /** Sudo */
            /*array(
                'from' => '<basepath>/files/custom/modules/Users/SudoLogin.php',
                'to' => 'custom/modules/Users/SudoLogin.php'
            ),
            array(
                'from' => '<basepath>/files/custom/modules/Users/SudoLogout.php',
                'to' => 'custom/modules/Users/SudoLogout.php'
            ),
            array(
                'from' => '<basepath>/files/custom/modules/Users/views/view.detail.php',
                'to' => 'custom/modules/Users/views/view.detail.php',
            ),
            */
            /** Warnings */
            array(
                'from' => '<basepath>/sugarfix/modules/Administration/DisplayWarnings.php',
                'to' => 'modules/Administration/DisplayWarnings.php'
            ),
            array(
                'from' => '<basepath>/files/custom/modules/Users/',
                'to' => 'custom/modules/Users/',
            ),
        ),
    'menu' => array(
        array(
            'from' => '<basepath>/files/custom/modules/Users/Menu.php',
            'to_module' => 'Users',
        ),
    ),
    'language' =>
        array(
            /** ENGLISH en_us */
            array(
                'from' => '<basepath>/files/custom/modules/Users/language/en_us.lang.php',
                'to_module' => 'Users',
                'language' => 'en_us'
            ),
            /** END ENGLISH en_us */
        ),
);

?>
