var socket = io.connect('http://node.tomahock.com:8080');
socket.on('add2', function (data) {
	console.log( 'client' );
	console.log(data);
});

$('.js-add-point').on('click', function(e){
	$this = $(e.currentTarget);
	console.log( 'click' );
	data = {
		'team1' : $this.data( 'team1' ),
		'team2' : $this.data( 'team2' )
	}
	socket.emit( 'startGame', data );
});