<?php

// Source: Karl Metum
// https://community.sugarcrm.com/sugarcrm/topics/login_as_another_user_possible

global $current_user, $db;
if (!$current_user->is_admin)
   if (empty($_SESSION['was_admin']))
	  die('Need to be administrator to access');
if (!empty($_GET['user_id'])) {
   $_SESSION['user_id']               = $_GET['user_id'];
   $_SESSION['authenticated_user_id'] = $_GET['user_id'];
   $_SESSION['was_admin']             = true;

   $user = new User();
   $user->retrieve($_GET['user_id']);
   $current_user = $user;
   header('Location: index.php?module=Home');
}
$sql       = "SELECT id, user_name, first_name, last_name FROM users WHERE deleted = 0 AND is_group = 0";
$resultset = $db->query($sql);
while ($row = $db->fetchByAssoc($resultset)) {
   echo '<a href="index.php?module=Administration&action=SwitchUser&user_id=' . $row['id'] . '"> ' . $row['user_name'] . '</a> ' . $row['first_name'] . ' ' . $row['last_name'] . ' <br/><br/>';
}

?>