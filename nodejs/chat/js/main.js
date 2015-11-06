$(document).ready(function () {
    var messagesAreaObj = $('#messages-area');
    var messageObj = $('#message');
    var btnSendObj = $('#send');
    var socket = io.connect('http://85.214.242.99:1337');

    var send = function () {
        var message = messageObj.val().trim();
        if (message) {
            socket.emit('message', message);
            messagesAreaObj.append('<li>' + message + '</li>');
            messageObj.val('');
        }
    };
    btnSendObj.click(function () {
        send();
    });
    messageObj.keypress(function (e) {
        if (e.which == 13) {
            send();
        }
    });

    socket.on('message', function (message) {
        messagesAreaObj.append('<li>' + message + '</li>');
    });
});

