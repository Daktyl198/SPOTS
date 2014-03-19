<?php
if (!fromIndex){die('You must access this through the root index!');}

require_once(databaseDir.'TaskIO.php');
$seriesSearch = 'All';
if (isset($_GET['pname']) && $_GET['pname'] != 'All'){
	$seriesSearch = $_GET['pname'];
}

$roleSearch = 'All';
if (isset($_GET['role']) && $_GET['role'] != 'All'){
	$seriesSearch = $_GET['role'];
}

$statusSearch = 'All';
if (isset($_GET['status']) && $_GET['status'] != 'All'){
	$status = $_GET['status'];
	switch ($status) {
		case 'Active':
			$statusSearch = 'A';
			break;
		case 'Inactive':
			$statusSearch = 'I';
			break;
		case 'Stalled':
			$statusSearch = 'S';
			break;
		case 'Complete':
			$statusSearch = 'C';
			break;
		default:
			break;
	}
}

if ($statusSearch != 'All'){
	if ($roleSearch != 'All'){
		$args = array(role, status);
		$data = getDefinedTasksByRoleAndStatus($args);
	}else if ($seriesSearch != 'All'){
		$args = array(title, status);
		$data = getDefinedTasksByTitleAndStatus($args);
	}else{
		$args = array(status);
		$data = getDefinedTasksByStatus($args);
	}
}else if ($roleSearch != 'All'){
	if ($seriesSearch != 'All'){
		$args = array(title, role);
		$data = getDefinedTasksByTitleAndRole($args);
	}else{
		$args = array(role);
		$data = getDefinedTasksByRole($args);
	}
}else if ($seriesSearch != 'All'){
	$args = array(title);
	$data = getDefinedTasksByTitle($args);
}else{
	$args = array(title, role, status);
	$data = getFullyDefinedTasks($args);
}

?>

<div class="project-block">
	<div class="title-div">Shurabura!</div>
	<div class="chapter-block">
		<div class="chapter-number">Ch. #</div>
		<div class="task">Tasks assigned to you</div>
		<br />
	</div>
	
	<div class="chapter-block">
		<div class="chapter-number">Ch.1</div>
		<div class="task">Cleaning</div>
		<br />
	</div>
	<div class="chapter-block">
		<div class="chapter-number">Ch.2</div>
		<div class="task">Proofreading</div>
		<br />
	</div>
</div>

<div class="project-block">
	<div class="title-div">Comic Studio</div>
	
	<div class="chapter-block">
		<span class="chapter-number">Ch.1</span>
		<span class="task">Translation</span>
	</div>
</div>

