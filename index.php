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
	// This is going to need a nicer/cleaner alternative in the future...
	if (strpos($_GET['action'], './') || strpos($_GET['action'], '../') || strpos($_GET['sub'], './') || strpos($_GET['sub'], '../')) {
		$subDirAttempt = TRUE;
	}
	else {
		$action = str_replace('\0', '', $_GET['action']);
		$sub = isset($_GET['sub']) ? str_replace('\0', '', $_GET['sub']) : 'Main';
		$subDirAttempt = FALSE;
	}
}

DEFINE('actionDir', './Modules/'.$action);
DEFINE('moduleDir', './Modules/'.$action.'/'.$sub);

require_once(spotsIndex.'/header.php');

$sidebarFix = '';
if (!include_once(actionDir.'/sidebar.php')) {
	$sidebarFix = ' style="margin-left:0px;"';
}

echo '<div id="module" '.$sidebarFix.'">';

if ($subDirAttempt || !include_once(moduleDir.'/index.php')) {
	echo '<div style="margin-top:50px;">This page does not exist!</div>';
}

echo '</div>';

?>

<script type="text/javascript">
function downloadJSAtOnload() {
var element = document.createElement("script");
element.src = "js/index.js";
document.body.appendChild(element);
}
if (window.addEventListener)
window.addEventListener("load", downloadJSAtOnload, false);
else if (window.attachEvent)
window.attachEvent("onload", downloadJSAtOnload);
else window.onload = downloadJSAtOnload;
</script>

</body>
</html>
