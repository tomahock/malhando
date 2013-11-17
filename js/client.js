/**
 * Created by tomahock on 17/11/13.
 */
var socket = io.connect('http://node.tomahock.com:8080');
socket.on('addPoint', function (data) {
	$span =  $('div').find( '[data-id='+ data.gameId +']').find( '.' + data.score );
	$span.text( parseInt( $span.text(), 10 ) + 1 );
});

socket.on('endGame', function (data) {
	console.log( data );
	$span =  $('div').find( '[data-id='+ data.gameId +']');
	$span.css( { 'background-color' : 'red'} );
});