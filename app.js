var app = require('http').createServer(handler)
, io = require('socket.io').listen(app)
, fs = require('fs');
var clients = [];
var ss;

var mysql      = require('mysql');
var connection = mysql.createConnection({
	host     : 'localhost',
	user     : 'malha',
	password : 'm@lh@',
	database : 'malha'
});

//var pool  = mysql.createPool({
//	host     : 'localhost',
//	user     : 'malha',
//	password : 'm@lh@',
//	database : 'malha'
//});

//pool.getConnection(function(err, connection) {
	// connected! (unless `err` is set)
//	console.log( err );
//});

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

//		connection.end();
//

//
//		console.log( 'startGame 2' );
//		console.log( instance.team1id );
//		sql = 'SELECT * FROM teams WHERE name="' + data.team2 + '"';
//		connection.query( sql , function( err, rows, fields) {
//			console.log( err );
//			console.log( rows );
//			instance.team2id = rows[0].id;
//			connection.end();
//		});
//
//
//		console.log( 'startGame 3' );
//		console.log( instance.team1id );
//		data = {
//			team1 : instance.team1id,
//			team2 : instance.team2id,
//			score1: 0,
//			score2: 0
//		};
//		sql = 'INSERT INTO game( team1, team2, score1, score2) values("'+instance.team1id+'", "'+instance.team2id+'", 0, 0';
//		console.log( sql );
//		connection.query( sql, function(err, result) {
//			console.log( err );
//			connection.end();
//		});

	} );
	this.socket.on( 'addPoint2', function( data ) {
		connection.connect();
		connection.query( 'INSERT INTO game(c1,c2) value("bla", "bla2")' , function(err, rows, fields) {
			if (err) throw err; });

		self.socket.emit( 'add2', { team : '1'} );

	} )
}
