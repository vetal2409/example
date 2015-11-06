<?php
if ($_POST['listId'] && $_POST['listId']!=='') {
    $arr = array('status' => 'error');

    require_once '../../../include/config.php';

    $mailerId = escapeString($_POST['listId']);

    $selectWhereSql = "SELECT and_where FROM mailer_list WHERE `id` = $mailerId AND `deleted` = '0'";
    $selectWhereQuery = mysql_query($selectWhereSql);

    if ($selectWhereQuery && mysql_num_rows($selectWhereQuery)) {

        $Where = mysql_fetch_assoc($selectWhereQuery);

        $countSql = "SELECT COUNT(*) as `count` FROM `event_registrations` WHERE  1=1 {$Where['and_where']}";
        $countQuery = mysql_query($countSql);

        if ($countQuery && mysql_num_rows($countQuery)) {
            $countRow = mysql_fetch_assoc($countQuery);
            $arr['status'] = 'success';
            $arr['count'] = $countRow['count'];

            if ($_POST['templateId'] && $_POST['templateId']!=='') {
                $templateId = escapeString($_POST['templateId']);
                $sqlLastSent = "(SELECT `registration_id` FROM `mailer_success` WHERE `list_id` = $mailerId AND `template_id` = $templateId)
            UNION (SELECT `registration_id` FROM `mailer_error` WHERE `list_id` = $mailerId AND `template_id` = $templateId)
            ORDER BY `registration_id` DESC LIMIT 1";
                $queryLastSent = mysql_query($sqlLastSent);
                if ($queryLastSent && mysql_num_rows($queryLastSent)) {
                    $rowLastSent = mysql_fetch_assoc($queryLastSent);
                    $lastSentId = $rowLastSent['registration_id'];

                    $sqlReg = "SELECT `regid` FROM `event_registrations` WHERE `regid` > $lastSentId {$Where['and_where']}";
                    $queryReg = mysql_query($sqlReg);
                    if ($queryReg) {
                        $arr['count-success'] = $countRow['count'] - mysql_num_rows($queryReg);
                    }
                }
                else
                {
                    $arr['count-success'] = 0;
                }
            }
        }

    }

    echo json_encode($arr);
}
