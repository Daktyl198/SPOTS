<?php

DEFINE('fromIndex', TRUE);
DEFINE('databaseDir', dirname(__FILE__).'/Database/');

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
if (isset($_POST['loginUser']) && isset($_POST['loginPass'])){
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

require_once(databaseDir.'Connection.php');
global $connection;
if ($connection === null || !mysqli_ping($connection)){
	connect();
}

require_once('./header.php');

$sidebar = actionDir.'/sidebar.php';
if (!file_exists($sidebar) || !include_once($sidebar)){
	$marginFix = ' style="margin-left:0px;"';
}else {
	$marginFix = '';
}

echo '<div id="module"'.$marginFix.'>';
$mindex = moduleDir.'/mindex.php';
if (!include_once($mindex)) {
	echo '<div style="margin-top:50px;">This page does not exist!</div>';
}
echo '</div>';

require_once('./footer.html');

?>
