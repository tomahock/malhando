<?php
require_once( '../includes/actions.php' );
switch ($_GET['action']) {
	case 'addMember':
		$data = $_POST;
		$result = addTeam( $data );
		header("content-type:application/json");
		$response = array(
			'success' => $result
		);
		echo json_encode($response);
		die();
		break;
	case 'makeGamesStep1':
		$data = $_POST;
		$result = makeGames( $data );
		header("content-type:application/json");
		$response = array(
			'success' => $result['success'],
			'message' => $result['message']
		);
		echo json_encode($response);
		die();
		break;

}