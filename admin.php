<?php
/**
 * Created by PhpStorm.
 * User: tomahock
 * Date: 17/11/13
 * Time: 14:43
 */
require_once( 'layout/header.php' );
?>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
		<li><a href="#addTeam" data-toggle="tab">Add Team</a></li>
		<li><a href="#games" data-toggle="tab">Games</a></li>
		<li><a href="#scores" data-toggle="tab">Scores</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane fade in active" id="addTeam">
			<form role="form">
				<div class="form-group">
					<label for="teamName">Team Name</label>
					<input type="text" class="form-control" id="teamName" placeholder="Team Name">
				</div>
				<div class="form-group">
					<label for="member1">Member 1 </label>
					<input type="text" class="form-control" id="member1" placeholder="Member 1">
				</div>
				<div class="form-group">
					<label for="member2">Member 2 </label>
					<input type="text" class="form-control" id="member2" placeholder="Member 1">
				</div>
				<button type="submit" class="btn btn-default js-add-member">Add</button>
			</form>
		</div>
		<div class="tab-pane fade" id="games">
			<button class="btn btn-primary js-make-games-step1">Make games step1</button>
		</div>
		<div class="tab-pane fade" id="scores">
			<?php printGamesAdmin(); ?>
		</div>
	</div>

	<script src="js/admin.js"></script>
<?php
require_once( 'layout/footer.php' );
?>