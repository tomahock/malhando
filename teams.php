<?php
/**
 * Created by PhpStorm.
 * User: tomahock
 * Date: 17/11/13
 * Time: 14:43
 */
	require_once( 'includes/base.php' );
	require_once( 'includes/actions.php' );
	require_once( 'layout/header.php' );

	$teams = getTeams();
?>
<table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Team Name</th>
            <th>Member 1</th>
            <th>Member 2</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach( $teams as $team ) : ?>
	        <tr>
		        <td><?= $team->id ?></td>
		        <td><?= $team->name ?></td>
		        <td><?= $team->member1 ?></td>
		        <td><?= $team->member2 ?></td>
	        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>

<?php
	require_once( 'layout/header.php' );
?>