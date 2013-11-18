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
		console.log( '---------- addPoint --------' );
		var instance = this;

		console.log(  data );
		sql = 'UPDATE game_has_matchs SET ' + data.score + '= (' + data.score + ' + 1 ) WHERE id=' + data.heatId;
		console.log( sql );
		connection.query( sql , function( err, rows, fields) {
			console.log( rows );
		});
		self.socket.broadcast.emit( 'addPoint', data );
		self.socket.emit( 'addPoint', data );

	} );
	this.socket.on( 'endGame', function( data ) {
		console.log( '---------- endGame --------' );
		connection.query( 'SELECT * FROM game INNER JOIN game_has_matchs ON game.id=game_has_matchs.game_id WHERE game.id=' + data.gameId , function( err, rows, fields) {
			if (err) throw err;
			console.log( rows );
			if( rows[0].score1 == END_GAME_POINTS ) {
				connection.query( 'UPDATE teams SET active=0 WHERE id=' + rows[0].team2, function( err, rows, fields) {
					if (err) throw err;
					console.log( 'desactivate team 2' );
				});
			} else if( rows[0].score2 == END_GAME_POINTS ) {
				connection.query( 'UPDATE teams SET active=0 WHERE id=' + rows[0].team1, function( err, rows, fields) {
					if (err) throw err;
					console.log( 'desactivate team 1' );
				});
			} else {
				console.log( 'no one wins' );
			}
			connection.query( 'UPDATE game_has_matchs SET active=0 WHERE id=' + data.heatId, function( err, rows, fields) {
				if (err) throw err;
				console.log( 'desactivate heat' );
			});

		});

		dataEmit = {
			'gameId' : data.gameId
		}
		console.log( dataEmit );
		self.socket.emit( 'endGame', dataEmit );
		self.socket.broadcast.emit( 'endGame', dataEmit );

	} )

	this.socket.on( 'endHeat', function( data )
	{
		console.log( '---------- endHeat --------' );
		connection.query( 'UPDATE game_has_matchs SET active=0 WHERE id=' + data.heatId, function( err, rows, fields ) {
			if (err) throw err;
			connection.query( 'SELECT * FROM game_has_matchs WHERE id=' + data.heatId, function( err, rows, fields) {
				if (err) throw err;
				sql = "UPDATE game SET ";
				if( rows[0].score1 >= 9 ) {
					sql += 'victories1 = victories1 + 1';
				} else if(  rows[0].score2 >= 9 ) {
					sql += 'victories2 = victories2 + 1';
				} else {
					console.log( 'no points to finish heat' );
				}
				sql += " WHERE id=" + rows[0].game_id;

				console.log( sql );
				connection.query( sql, function( err, rows, fields) {
					if (err) throw err;
					console.log( 'updated game' );
				});
				nextHeat = parseInt( rows[0].heat, 10 ) + 1;
				if( nextHeat <=3 ) {
					connection.query( 'INSERT INTO game_has_matchs(game_id, score1, score2, heat, active) VALUES(' + rows[0].game_id + ', 0, 0, ' + nextHeat +  ', 1 )', function( err, rows, fields) {
						if (err) throw err;
						console.log( 'inserting new match');
					});

					connection.query( 'SELECT * FROM game_has_matchs WHERE game_id=' + rows[0].game_id + ' AND heat=' + nextHeat, function( err, rows, fields ) {
						if (err) throw err;

						dataEmit = {
							endGame : false,
							gameId : rows[0].game_id,
							heatId : rows[0].id
						}

						self.socket.emit( 'endHeat', dataEmit );
						self.socket.broadcast.emit( 'endHeat', dataEmit );

						return true;
					} )
				} else {
					dataEmit = {
						endGame : true,
						gameId :data.gameId,
						heatId : null
					}


					self.socket.emit( 'endHeat', dataEmit );
					self.socket.broadcast.emit( 'endHeat', dataEmit );

					return true;
				}

			} );
		} );
	});
}
