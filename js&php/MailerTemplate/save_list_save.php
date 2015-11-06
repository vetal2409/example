<?php
require_once('../../include/config.php');
require_once 'mailer_settings.php';
if (isset($_POST['listName'], $_POST['andWhereUrlEncode'])
    && ($listName = $_POST['listName'])
    && ($andWhere = trim(base64_decode(urldecode(urldecode($_POST['andWhereUrlEncode'])))))
) {
    $listExist = false;
    $sqlListCount = "SELECT COUNT(*) as `count` FROM $tableList as `count` WHERE deleted=0 AND name='$listName'";
    $queryListCount = mysql_query($sqlListCount);
    if ($queryListCount) {
        $rowListCount = mysql_fetch_assoc($queryListCount);
        $listExist = $rowListCount['count'] > 0;
    }
    if ($listExist) {
        $result = 'EXIST';
    } else {
        if (strtolower(substr($andWhere, 0, 4)) === 'and ') {
            $andWhere = substr($andWhere, 4);
        }
        $andWhere = str_replace('"', "'", $andWhere);
        $sql_and_where = ' AND (' . $andWhere . ')';

        function encodeForDb($var)
        {
            return mysql_real_escape_string($var);
        }

        $listNameDb = encodeForDb($listName);
        $sql_and_whereDb = encodeForDb($sql_and_where);
        $time = time();
        $sqlInsertList = "INSERT INTO $tableList (`name`, `and_where`, `created_at`) VALUES ('$listNameDb', '$sql_and_whereDb', $time)";
        $result = mysql_query($sqlInsertList) ? 'SUCCESS' : 'ERROR';
    }
    echo $result;
}