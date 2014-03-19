<?php

DEFINE('fromIndex', TRUE);
DEFINE('spotsIndex', dirname(__FILE__));
DEFINE('databaseDir', spotsIndex.'/Database/');

require_once(databaseDir.'Connection.php');
global $connection;
if ($connection === null || !mysqli_ping($connection)){
	connect();
}
else {
	// No point in doing anything else if we can't connect to the database.
	die('Failure to connect to database.');
}

session_start();
if ((isset($_GET['action']) && $_GET['action'] === 'logout') ||
	(isset($_POST['loginUser']) && isset($_POST['loginPass']))){
    require_once('./Login.php');
    //exit;
}

//Get Module names
if (!isset($_GET['action'])) {
	$action = 'Tasks';
	$sub = 'Main';
} else {
	$action = str_replace('\0', '', $_GET['action']);
	$sub = isset($_GET['sub']) ? str_replace('\0', '', $_GET['sub']) : 'Main';
}

DEFINE('actionDir', './Modules/'.$action);
DEFINE('moduleDir', './Modules/'.$action.'/'.$sub);

require_once(spotsIndex.'/header.php');

$sidebar = actionDir.'/sidebar.php';
$mindex = moduleDir.'/mindex.php';

if (!file_exists($mindex)) {
	echo '<div id="module" style="margin-left:0px;">';
	echo '<div style="margin-top:50px;">This page does not exist!</div>';
}
else {
	include_once($sidebar);
	echo '<div id="module">';
	include_once($mindex);
}

echo '</div>';

require_once('./footer.html');

?>
