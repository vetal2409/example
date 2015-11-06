<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="extensions/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>


<div class="container">
    <nav class="navbar">
        <ul class="nav navbar-nav">
            <li class="active">
                <a href="/">Home</a>
            </li>
        </ul>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1>Simple Real-time chat</h1>
                </div>
                <ul class="panel-body" id="messages-area">
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
            <div class="col-md-11">
                <label class="center-block"><input type="text" id="message" class="form-control panel-primary"
                                                   autocomplete="off" autofocus placeholder="Message..."></label>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary" id="send">Send</button>
            </div>
    </div>
</div>
<!--<div class="wrapper">-->
<!--    <header>-->
<!--        <h1 class="">Real-time chat</h1>-->
<!--    </header>-->
<!---->
<!--    <section class="main">-->
<!--        <div class="container">-->
<!--            <div id="screen">-->
<!---->
<!--            </div>-->
<!--            <div>-->
<!--                <label><input type="text" id="message"/></label>-->
<!--                <a href="#" id="send" class="btn btn-primary">Send</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
<!---->
<!--</div>-->


<script src="js/jquery-1.11.2.min.js"></script>
<script src="extensions/bootstrap/js/bootstrap.min.js"></script>
<script src="node_modules/socket.io/node_modules/socket.io-client/socket.io.js"></script>
<script src="js/main.js"></script>
</body>
</html>