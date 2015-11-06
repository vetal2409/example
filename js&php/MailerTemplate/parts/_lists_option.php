<?php
require_once('../../../include/config.php');
require_once '../mailer_settings.php';
$sqlLists = "SELECT `id`, `name` FROM $tableList WHERE deleted=0";
$queryLists = mysql_query($sqlLists);
?>

    <option value="">Please select</option>

<?php
if ($queryLists && mysql_num_rows($queryLists)):
    while ($rowList = mysql_fetch_assoc($queryLists)): ?>
        <option value="<?= $rowList['id'] ?>"><?= $rowList['name'] ?></option>
    <?php endwhile;
endif;


//    <option value="">Please select</option>
//
//<?php
//if (isset($lists) && count($lists)):
//    foreach ($lists as $value => $list): ?>
    <!--        <option value="--><? //= $value ?><!--">--><? //= $list['label'] ?><!--</option>-->
    <!--    --><?php //endforeach;
//endif;
