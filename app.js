var app = require('http').createServer(handler)
, io = require('socket.io').listen(app)
, fs = require('fs');
var clients = [];
var ss;

var END_GAME_POINTS = 9;
var mysql      = require('mysql');
var connection = mysql.createConnection({
	host     : 'localhost',
	user     : 'malha',
	password : 'm@lh@',
	database : 'malha'
});

app.listen(3000);


function handler (req, res) {
	if(req.url == "/"){
	fs.readFile('index.php',
			function (err, data) {
			if (err) {
			    res.writeHead(500);
			    return res.end('Error loading proje.html');
			}

			res.writeHead(200);
			res.end(data);
	});
	}
	else{
		var str = req.url.substring(1, req.url.length); // strip the first slash
		
		fs.readFile(str,
				function (err, data) {
				if (err) {
				    res.writeHead(500);
				    return res.end('Error loading request ' + str);
				}

				res.writeHead(200);
				res.end(data);
		});
	}
}

io.sockets.on('connection', function (socket) {
	console.log( 'aqui' );
	var game = new Game( socket );
});

function Game( socket ) {
	this.socket = socket;
	var self = this;

	this.socket.on( 'addPoint', function( data ) {
		var instance = this;

		sql = 'UPDATE game SET ' + data.score + '=' + data.score + ' + 1 WHERE id=' + data.gameId;
		connection.query( sql , function( err, rows, fields) {
			console.log( rows );
		});
		self.socket.broadcast.emit( 'addPoint', data );
		self.socket.emit( 'addPoint', data );

	} );
	this.socket.on( 'endGame', function( data ) {
		console.log( '---------- endGame --------' );
		connection.query( 'SELECT * FROM game WHERE id=' + data.gameId , function( err, rows, fields) {
			if (err) throw err;
			if( rows[0].score1 == END_GAME_POINTS ) {
				connection.query( 'UPDATE teams SET active=0 WHERE id=' + rows[0].team2, function( err, rows, fields) {
					if (err) throw err;
					console.log( 'winning team 1' );
				});
			} else if( rows[0].score2 == END_GAME_POINTS ) {
				connection.query( 'UPDATE teams SET active=0 WHERE id=' + rows[0].team1, function( err, rows, fields) {
					if (err) throw err;
					that.endGame = true;
					console.log( 'winning team 2' );
				});
			} else {
				console.log( 'no one wins' );
				console.log( that.endGame );
			}
		});

		console.log( that.endGame );
		dataEmit = {
			'gameId' : data.gameId
		}
		console.log( dataEmit );
		self.socket.emit( 'endGame', dataEmit );
		self.socket.broadcast.emit( 'endGame', dataEmit );

	} )
}
