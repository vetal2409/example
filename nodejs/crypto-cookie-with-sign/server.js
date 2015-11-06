var http = require('http');
var Cookies = require('cookies');
var Keygrip = require('keygrip');
var crypto = require('./crypto-self');

http.createServer(function (req, res) {

    var keys = Keygrip(["sem", "dez"]);
    var cookies = new Cookies(req, res, keys);


    if (req.url === '/set') {

        // Encoding ID
        var encId = crypto.encrypt('1834');

        // Creating cookies
        var expires = new Date();
        expires.setTime(expires.getTime() + 60000);
        cookies.set('id', encId, {httpOnly: true, expires: expires, signed: true, overwrite: true});

        res.writeHead(200, {'Content-Type': 'text/plain'});
        res.end('Created cookie "id"\n');
    }

    if (req.url === '/get') {

        var decId;
        var receivedCookie = cookies.get('id', {signed: true});

        // Decoding received cookie
        if(receivedCookie != undefined)
            decId = crypto.decrypt(receivedCookie);

        res.writeHead(200, {'Content-Type': 'text/plain'});
        res.end('Cookies:\nid: ' +  decId);
    }
    res.end('Hello World!\n');

}).listen(3000, '127.0.0.1');