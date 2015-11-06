<?php
require_once 'components/NumberConverter.php';
use components\NumberConverter;

$from = intval($_GET['from']);
$to = intval($_GET['to']);
$lang = htmlspecialchars(trim($_GET['lang']));
$convert = new NumberConverter($lang);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Number converter</title>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>

<div class="wrapper">
    <div class="setting">
        <form action="" method="get">
            <label for="from">From:</label> <input type="text" name="from" id="from" value="<?= $from ?>"
                                                   maxlength="9"/>
            <label for="to">To:</label><input type="text" name="to" id="to" value="<?= $to ?>" maxlength="9"/>
            <label for="lang">Language:</label>
            <select name="lang" id="lang">
                <option value="ru" <?= $lang === 'ru' ? 'selected' : '' ?>>RU</option>
                <option value="ua" <?= $lang === 'ua' ? 'selected' : '' ?>>UA</option>
                <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>EN</option>
            </select>
            <input type="submit" value="Start"/>
        </form>
    </div>

    <div class="result">
        <?php $t = microtime(true); while ($to >= $from):  ?>
            <p><span><?= $from ?></span> - <?= $convert->untilBillion($from++) ?></p>
        <?php endwhile; echo 'Time - ' . (microtime(true)-$t);?>
    </div>
</div>


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>