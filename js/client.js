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

socket.on('endHeat', function (data) {
	console.log( 'xixixixix' );
	$div =  $('div').find( '[data-id='+ data.gameId +']');
	result1 = $div.find( '.js-team-1').text();
	result2 = $div.find( '.js-team-2').text();


	html1 = "<span class='";
	html2 = "<span class='";
		if( result1 > result2 ) {
			html1 += "alert alert-success"
			html2 += "alert alert-danger"
		} else {
			html1 += "alert alert-danger"
			html2 += "alert alert-success"
		}
		html1 += "'>";
		html2 += "'>";
		html1 += result1;
		html2 += result2;
	html1 += "</span>"
	html2 += "</span>"
	$div.find('.js-team-1').before( html1 );
	$div.find('.js-team-2').before( html2 );
	$div.find('.js-team-1').text( 0 );
	$div.find('.js-team-2').text( 0 );

	$div.data( 'id', data.gameId );
	$div.data( 'heat-id', data.heatId );
//	$span =  $('div').find( '[data-id='+ data.gameId +']');
//	$span.css( { 'background-color' : 'red'} );
});