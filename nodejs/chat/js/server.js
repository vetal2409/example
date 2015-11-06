var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);

server.listen(1337);

app.get('/', function (req, res) {
    res.sendfile(__dirname + '/index.html');
});

io.on('connection', function (socket) {
    socket.broadcast.emit('message', 'Connected.');
    socket.on('message', function (message) {
        socket.broadcast.emit('message', message);
    });
});
console.log('Server started!');