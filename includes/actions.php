<?php
/**
 * Created by PhpStorm.
 * User: tomahock
 * Date: 17/11/13
 * Time: 15:04
 */


require_once( 'base.php' );


/**
 * @param $data
 * @return bool
 */
function addTeam( $data )
{
	$query = "
		INSERT INTO teams( name, member1, member2 )
		VALUES( '{$data['name']}', '{$data['member1']}', '{$data['member2']}')

	";

	$db = new db( unserialize( DATABASE ) );
	$result = $db->query( $query );

	if( $result ){
		return true;
	} else {
		return false;
	}
}

/**
 * @return array|bool
 */
function getTeams()
{
	$query = "
		SELECT * FROM teams
	";

	$db = new db( unserialize( DATABASE ) );
	$db->query( $query );
	$result = $db->get();

	if( $result ){
		return $result;
	} else {
		return false;
	}
}

/***
 * @return array|bool
 */
function getActiveTeams()
{
	$query = "
		SELECT * FROM teams
		WHERE active='1'
	";

	$db = new db( unserialize( DATABASE ) );
	$db->query( $query );
	$result = $db->get();

	if( $result ){
		return $result;
	} else {
		return false;
	}
}

function makeGames()
{
	$teams = getActiveTeams();
	$available  = array(
		'2',
		'4',
		'8',
		'16',
		'32'
	);

	if( !in_array( count( $teams ), $available) ) {
		$return = array(
			'success' => false,
			'message' => 'wrong team count'
		);
		return $return;
	}

	/***
	 * randify :D
	 */
	for( $i = rand( 1, 10); $i >= 0; $i-- ){
		shuffle( $teams );
	}
	$coupleOfTeams = array();
	for( $j = 0; $j <=  ( count( $teams ) - 1 ) ; $j++ ) {
		$next = $j + 1;
		$aux = array();

		array_push( $aux, $teams[$j], $teams[$next] );
		array_push( $coupleOfTeams, $aux );
		$j++;
	}

	$numberOfMatches = count( $coupleOfTeams );
	$db = new db( unserialize( DATABASE ) );
	foreach( $coupleOfTeams as $match ) {
		switch( $numberOfMatches ) {
			case 16:
				$step = 1;
				break;
			case 8:
				$step = 2;
				break;
			case 4:
				$step = 3;
				break;
			case 2:
				$step = 4;
				break;
			case 1:
				$step = 5;
				break;
		}
		$query = "
			INSERT INTO game( team1, team2,  step, victories1, victories2 )
			VALUES( '{$match[0]->id}', '{$match[1]->id}', '{$step}', 0, 0 )
		";

		$db->query( $query );
		$gameId = $db->getLastId();

		$query = "
			INSERT INTO game_has_matchs( game_id, score1, score2, heat, active )
			VALUES( '{$gameId}', 0, 0, 1, 1 )
		";

		var_dump( $db->query( $query ) );

	}
}

function printGames()
{
	$db = new db( unserialize( DATABASE ) );
	$query = "
		SELECT * FROM game
	";
	$db->query( $query );
	$games = $db->get();


	$i = 1;
	$html = '';
	foreach( $games as $match ) {
		switch ( $i ) {
			case 1: $html .= "<h1>STEP 1 </h1>";
					$html .= "<div class='row'>";
					break;
			case 17: $html .= "<h1>STEP 2 </h1>";
					$html .= "<div class='row'>";
					break;
			case 25: $html .= "<h1>STEP 3 </h1>";
					$html .= "<div class='row'>";
					break;
			case 29: $html .= "<h1>STEP 4 </h1>";
				$html .= "<div class='row'>";
				break;
			case 31: $html .= "<h1>FINAL</h1>";
				$html .= "<div class='row'>";
				break;
		}
		$query = "
			SELECT name FROM teams
			WHERE id='{$match->team1}' OR id='{$match->team2}'
		";

		$db->query( $query );
		$names = $db->get();

		$query = "
			SELECT * from game_has_matchs
			WHERE game_id='{$match->id}'
		";

		$db->query( $query );
		$results = $db->get();

		$currentHeat = end($results);
		$currentHeat = $currentHeat;

		$html .= "<div class='js-game col-md-3' data-id='{$match->id}'>";
			$html .= "<p>";
				$html .= "Team 1 - " . $names[0]->name;
				if( count( $results) > 2 ) {
					foreach( $results as $result ) {
						if( $result->score1 > $result->score2 ) {
							$html .= "<span class='alert alert-success'>{$result->score1}</span>";
						} else {
							$html .= "<span class='alert alert-danger'>{$result->score1}</span>";
						}

					}
				}
				$html .= "  <span class='js-team-1 score1'>{$currentHeat->score1}</span>";
			$html .= "</p>";
			$html .= "<p>";
				$html .= "Team 2 - " . $names[1]->name;
				if( count( $results) > 2 ) {
					foreach( $results as $result ) {
						if( $result->score1 < $result->score2 ) {
							$html .= "<span class='alert alert-success'>{$result->score2}</span>";
						} else {
							$html .= "<span class='alert alert-danger'>{$result->score2}</span>";
						}

					}
				}
				$html .= "  <span class='js-team-2 score2'>{$currentHeat->score2}</span>";
			$html .= "</p>";
		$html .= "</div>";


		if( $i === 16 || $i === 24 || $i === 28 || $i === 30 || $i === 31 ) {
			$html .= "</div>";
		}

		$i++;
	}

	echo $html;
}

function printRunningGames()
{
	$db = new db( unserialize( DATABASE ) );
	$query = "
		SELECT * FROM game
	";
	$db->query( $query );
	$allGames = $db->get();

	$currentStep = end($allGames);
	$currentStep = $currentStep->step;

	$query = "
		SELECT * FROM game
		WHERE step = '{$currentStep}'
	";

	$db->query( $query );
	$games = $db->get();

	$html = '';
	switch ( $currentStep ) {
		case 1: $html .= "<h1>STEP 1 </h1>";
			$html .= "<div class='row'>";
			break;
		case 2: $html .= "<h1>STEP 2 </h1>";
			$html .= "<div class='row'>";
			break;
		case 3: $html .= "<h1>STEP 3 </h1>";
			$html .= "<div class='row'>";
			break;
		case 4: $html .= "<h1>STEP 4 </h1>";
			$html .= "<div class='row'>";
			break;
		case 5: $html .= "<h1>FINAL</h1>";
			$html .= "<div class='row'>";
			break;
	}

	foreach( $games as $match ) {
		if( $match->step != $currentStep ) {
			continue;
		}

		$query = "
			SELECT name FROM teams
			WHERE id='{$match->team1}' OR id='{$match->team2}'
		";

		$db->query( $query );
		$names = $db->get();

		$query = "
			SELECT * from game_has_matchs
			WHERE game_id='{$match->id}'
		";

		$db->query( $query );
		$results = $db->get();

		$currentHeat = end($results);
		$currentHeat = $currentHeat;

		$html .= "<div class='js-game col-md-3' data-id='{$match->id}'>";
			$html .= "<p>";
				$html .= "Team 1 - " . $names[0]->name;
				if( count( $results) > 2 ) {
					foreach( $results as $result ) {
						if( $result->score1 > $result->score2 ) {
							$html .= "<span class='alert alert-success'>{$result->score1}</span>";
						} else {
							$html .= "<span class='alert alert-danger'>{$result->score1}</span>";
						}

					}
				}
				$html .= "  <span class='js-team-1 score1'>{$currentHeat->score1}</span>";
			$html .= "</p>";
			$html .= "<p>";
				$html .= "Team 2 - " . $names[1]->name;
				if( count( $results) > 2 ) {
					foreach( $results as $result ) {
						if( $result->score1 < $result->score2 ) {
							$html .= "<span class='alert alert-success'>{$result->score2}</span>";
						} else {
							$html .= "<span class='alert alert-danger'>{$result->score2}</span>";
						}

					}
				}
				$html .= "  <span class='js-team-2 score2'>{$currentHeat->score2}</span>";
			$html .= "</p>";
		$html .= "</div>";
	}

	echo $html;
}

function printGamesAdmin()
{
	$db = new db( unserialize( DATABASE ) );
	$query = "
		SELECT * FROM game
	";
	$db->query( $query );
	$allGames = $db->get();

	$currentStep = end($allGames);
	$currentStep = $currentStep->step;

	$query = "
		SELECT * FROM game
		WHERE step = '{$currentStep}'
	";

	$db->query( $query );
	$games = $db->get();

	$i = 1;
	$html = '';
	foreach( $games as $match ) {
		if( $match->step != $currentStep ) {
			continue;
		}
		$query = "
			SELECT * FROM teams
			WHERE id='{$match->team1}' OR id='{$match->team2}'
		";

		$db->query( $query );
		$names = $db->get();

		$query = "
			SELECT * from game_has_matchs
			WHERE game_id='{$match->id}'
		";

		$db->query( $query );
		$results = $db->get();

		$currentHeat = end($results);
		$currentHeat = $currentHeat;

		$html .= "<div class='row'>";
			$html .= "<div class='js-game col-md-8 js-game-id' data-id='{$match->id}' data-heat-id='{$currentHeat->id}'>";
				$html .= "<p>";
					$html .= "Team 1 - " . $names[0]->name;
						if( count( $results) > 2 ) {
							foreach( $results as $result ) {
								if( $result->score1 > $result->score2 ) {
									$html .= "<span class='alert alert-success'>{$result->score1}</span>";
								} else {
									$html .= "<span class='alert alert-danger'>{$result->score1}</span>";
								}
							}
						}
					$html .= "  <span class='js-team-1 score1'>{$currentHeat->score1}</span>";
					$html .= "<button class='btn btn-success js-add-point' data-score='score1' data-team-id='{$match->team1}'>Add Point</button>";
				$html .= "</p>";
				$html .= "<p>";
					$html .= "Team 2 - " . $names[1]->name;
						if( count( $results) > 2 ) {
							foreach( $results as $result ) {
								if( $result->score1 < $result->score2 ) {
									$html .= "<span class='alert alert-success'>{$result->score2}</span>";
								} else {
									$html .= "<span class='alert alert-danger'>{$result->score2}</span>";
								}

							}
						}
					$html .= "  <span class='js-team-2 score2'>{$currentHeat->score2}</span>";
					$html .= "<button class='btn btn-success js-add-point' data-score='score2' data-team-id='{$match->team2}'>Add Point</button>";
				$html .= "</p>";
			$html .= "</div>";
			$html .= "<div class='js-game col-md-4'>";
				$html .= "<button class='btn btn-danger js-end-heat'>End Heat</button>";
				$html .= "<button class='btn btn-danger js-end-game'>End Game</button>";
			$html .= "</div>";
		$html .= "</div>";

		$i++;
	}
	echo $html;
}