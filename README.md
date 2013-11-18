malhando
========

This is supposed to be a app to manage a "malha" tournament

This is a work on progress

It is in an init state so... Code sucks, implementation sucks, organization sucks and probably you suck... But somethings are working!

Using
======
 - initializr from http://html5boilerplate.com/
 - twitter bootstrap
 - node.JS
 - socket.io
 - node-mysql by Felix Geisendörfer - https://github.com/felixge/node-mysq
 - mysql

Running
======
Edit configure.php and app.js to set your database configs

Edit admin.js and client.js to set your socket address correctly

run node app.js


Hint
======
Since i'm using nginx on my server, i'm catching all requests on port 8080 and using proxy_pass directive to send "~ /socket.io" request to port 3000 (setted on app.js). 

This is necessary because node.JS can't parse php so nginx parses php for node.JS and node.js just be node.JS

Working
======
 - Add teams :)
 - Add Point
 - End heat
 - End Game
 - Live score and end game
 - All games successfully generated randomly

TODO
======
 - ~~heats game~~
 - cool design (?)
 - replace mysql to mongodb
 - remove all php
