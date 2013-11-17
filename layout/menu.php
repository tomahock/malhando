<?php
/**
 * Created by PhpStorm.
 * User: tomahock
 * Date: 17/11/13
 * Time: 14:47
 */
$page = null;
switch( $_SERVER['SCRIPT_NAME'] ) {
	case '/index.php':
			$page = 'index';
			break;
	case '/teams.php':
		$page = 'teams';
		break;
	case '/results':
		$page = 'result';
		break;
}
?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Malha</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li <?= ( $page === 'index' ) ? 'class="active"' : ''; ?>><a href="index.php">Home</a></li>
				<li <?= ( $page === 'teams' ) ? 'class="active"' : ''; ?>><a href="teams.php">Teams</a></li>
				<li <?= ( $page === 'results' ) ? 'class="active"' : ''; ?>><a href="results.php">Results</a></li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>