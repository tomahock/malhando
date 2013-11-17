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
 - Not fully tested after the 32 teams inserted on admin page (yeah /admin.php with no authentication process) it can generate all games randomly.
 - On admin page -> Scores you can add add a score point for a team and it propagates to all clients with index page open.

TODO
======
 - better of 3 game
 - end game
 - generate second step
 - cool design (?)
 - replace mysql to mongodb
