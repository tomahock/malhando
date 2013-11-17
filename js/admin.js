$('body').on( 'click', '.js-add-member', function(e){
	e.preventDefault();
	$this = $( e.currentTarget );
	$form = $this.closest( 'form' );
	url = 'api/admin.php?action=addMember';

	data = {
		'name' : $('#teamName').val(),
		'member1' : $('#member1').val(),
		'member2' : $('#member2').val()
	}
	console.log( data );

	$.ajax( {
		type: 'post',
		url: url,
		data: data,
		success: function( data ) {
			if( data.success ) {
				$el = '<div class="alert alert-success">';
					$el += '<a href="#" class="alert-link">Successfully added</a>';
				$el += '</div>';
			} else {
				$el = '<div class="alert alert-danger">';
					$el += '<a href="#" class="alert-link">Error try again</a>';
				$el += '</div>';
			}
			$('.container').prepend( $el );
			setTimeout( function(){ $('.alert').remove(); }, 2000 );
		},
		error: function() {
			console.log( 'error' );
		}
	} );
});

$('body').on( 'click', '.js-make-games-step1', function(e){
	e.preventDefault();
	url = 'api/admin.php?action=makeGamesStep1';

	$.ajax( {
		type: 'post',
		url: url,
		success: function( data ) {
			if( data.success ) {
				console.log( 'success' );
			} else {
				$el = '<div class="alert alert-danger">';
					$el += '<a href="#" class="alert-link">' + data.message + '</a>';
				$el += '</div>';
			}

			$('.container').prepend( $el );
			setTimeout( function(){ $('.alert').remove(); }, 2000 );
		},
		error: function() {
			console.log( 'error' );
		}
	} );
})

var socket = io.connect('http://node.tomahock.com:8080');
socket.on('add2', function (data) {
	console.log( 'client' );
	console.log(data);
});


$('.js-add-point').on('click', function(e){
	$this = $(e.currentTarget);
	gameId = $this.parent().parent().data( 'id' );
	teamId = $this.data( 'team-id' );
	score = $this.data( 'score' );
	console.log( 'click' );
	data = {
		'gameId' :gameId,
		'team' : teamId,
		'score' : score
	}
	console.log( data );
	socket.emit( 'addPoint', data );
});

$('.js-end-game').on('click', function(e){
	$this = $(e.currentTarget);
	gameId = $this.parent().parent().find('.js-game-id').data( 'id' );
	console.log( 'click' );
	data = {
		'gameId' :gameId
	}
	socket.emit( 'endGame', data );
});