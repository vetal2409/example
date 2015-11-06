<?php
/**
 * @var $email
 * @var $lastname
 * @var $firstname
 * @var $email
 *
 * @var $tableReg
 * @var $tableRegPrimary
 * @var $tableRegDeleted
 * @var $tableTemplate
 * @var $tableSuccess
 * @var $tableList
 * @var $tableError
 * @var $listId
 * @var $templateId
 * @var $packageNum
 */
set_time_limit(0);
require_once('../../components/Controller.php');
include(Controller::getBasePath() . '/include/config.php');
require_once('./models/MailTemplates.php');
require_once './mailer_settings.php';
$modelMailTemplate = new MailTemplates();
$modelMailTemplate->initMailer();
$result['success_count'] = $result['error_count'] = 0;
$numReg = 0;
$result['type'] = null;
$type = &$result['type'];

function replaceTemplateVars($string)
{
    global $GLOBALS;
    preg_match_all("/\{\{(.*)\}\}/iU", $string, $output_array);
    $replace = array();
    foreach ($output_array[1] as $v) {
        $v = str_replace(']', '', htmlspecialchars_decode($v, ENT_QUOTES));
        $v = str_replace('"', '', $v);
        $v = str_replace("'", '', $v);
        $v_arr = explode('[', $v);
        $val = '';
        foreach ($v_arr as $k_one => $v_one) {
            if ($k_one === 0) {
                $val = $GLOBALS[$v_one];
            } else {
                $val = $GLOBALS[$v_arr[$k_one - 1]][$v_one];
            }
        }
        $replace[] = $val; //eval('return $' . $v . ';');
    }
    return str_replace($output_array[0], $replace, $string);
}

if (isset($_POST) && ($templateId = $_POST['template_id'])) {
    parse_str($_POST['form_data'], $mail_form);
    $template = MailTemplates::findOne($templateId);
    $templateLanguage = $_POST['language'];

    if (isset($mail_form['list']) && ($listId = $mail_form['list'])) { //Mailer list
        $result['sendStatus'] = isset($_POST['sendStatus']) ? $_POST['sendStatus'] : 'start';
        $result['countAll'] = 0;
        $result['countNew'] = 0;

        $type = 'list';
        $sendStatus = &$result['sendStatus'];
        $countAll = &$result['countAll'];
        $countNew = &$result['countNew'];
        $sqlList = "SELECT `id`, `name`, `and_where` FROM `$tableList` WHERE `deleted` = 0 AND `id` = $listId";
        $queryList = mysql_query($sqlList);
        if ($queryList && mysql_num_rows($queryList)) {
            $rowList = mysql_fetch_assoc($queryList);
            $andWhere = $rowList['and_where'];
            $lastSentId = 0;

            $sqlLastSent = "(SELECT `registration_id` FROM `$tableSuccess` WHERE `list_id` = $listId AND `template_id` = $templateId)
            UNION (SELECT `registration_id` FROM `mailer_error` WHERE `list_id` = $listId AND `template_id` = $templateId)
            ORDER BY `registration_id` DESC LIMIT 1";
            $queryLastSent = mysql_query($sqlLastSent);
            if ($queryLastSent && mysql_num_rows($queryLastSent)) {
                $rowLastSent = mysql_fetch_assoc($queryLastSent);
                $lastSentId = $rowLastSent['registration_id'];
            }

            $sqlReg = "SELECT `$tableRegPrimary`, `guid` FROM `$tableReg` WHERE `$tableRegPrimary` > $lastSentId{$andWhere}{$tableRegDeleted} LIMIT $packageNum";
            $queryReg = mysql_query($sqlReg);
            if ($queryReg) {
                $numReg = mysql_num_rows($queryReg);
            }

            if ($sendStatus === 'start') {
                $sqlRegAllNum = "SELECT COUNT(*) as `countAll` FROM `$tableReg` WHERE 1=1{$andWhere}{$tableRegDeleted}";
                $queryRegAllNum = mysql_query($sqlRegAllNum);
                if ($queryRegAllNum) {
                    $rowRegAllNum = mysql_fetch_assoc($queryRegAllNum);
                    $countAll = $rowRegAllNum['countAll'];
                }
            }

            if ((int)$numReg === 0) {
                $sendStatus = 'end';
            } elseif ($sendStatus === 'start') {
                if ((int)$numReg < $packageNum) {
                    $countNew = $numReg;
                } else {
                    $sqlRegNewNum = "SELECT COUNT(*) as `countNew` FROM `$tableReg` WHERE `$tableRegPrimary` > $lastSentId{$andWhere}{$tableRegDeleted}";
                    $queryRegNewNum = mysql_query($sqlRegNewNum);
                    if ($queryRegNewNum) {
                        $rowRegNewNum = mysql_fetch_assoc($queryRegNewNum);
                        $countNew = $rowRegNewNum['countNew'];
                    }
                }
            }
        }
    } else { //Mailer checkboxes
        $type = 'checked';
        $sql_part_ids = implode(',', $_POST['ids']);
        $sqlReg = "SELECT `$tableRegPrimary`, `guid` FROM $tableReg WHERE `$tableRegPrimary` IN ($sql_part_ids)";
        $queryReg = mysql_query($sqlReg);
        if ($queryReg) {
            $numReg = mysql_num_rows($queryReg);
        }
    }
    if ($numReg) {
        /**
         * @var $queryReg
         */
        preg_match_all("/\{\{(.*)\}\}/iU", $mail_form['body'], $output_array);
        while ($rowRegistration = mysql_fetch_assoc($queryReg)) {
            $params = array();
            $mailerSearch = $output_array[0];
            $regId = $rowRegistration[$tableRegPrimary];
            set_time_limit(60);
            $_GET['guid'] = $rowRegistration['guid'];
            include(Controller::getBasePath() . '/include/config.php');
            $language_part = $templateLanguage ? '_' . $templateLanguage : '';
            $variablesFilePath = $basePath . '/templates/mailer_vars/' . $template['file_name'] . $language_part . '.' . $template['file_extension'];
            if (file_exists($variablesFilePath)) {
                include($variablesFilePath);
            }
            $modelMailTemplate->clear();
            $modelMailTemplate->setAttributes($mail_form);
            $modelMailTemplate->to = $email;
            $modelMailTemplate->to_name = $lastname . ' ' . $firstname;
            $replace = array();
            foreach ($output_array[1] as $v) {
                $v = str_replace(']', '', htmlspecialchars_decode($v, ENT_QUOTES));
                $v = str_replace('"', '', $v);
                $v = str_replace("'", '', $v);
                $v_arr = explode('[', $v);
                $val = '';
                foreach ($v_arr as $k_one => $v_one) {
                    if ($k_one === 0) {
                        $val = ${$v_one};
                    } else {
                        $val = $val[$v_one];
                    }
                }


                $replace[] = $val; //eval('return $' . $v . ';');
            }

            if ($modelMailTemplate->cc) {
                $modelMailTemplate->cc = explode(';', replaceTemplateVars($modelMailTemplate->cc));
                $modelMailTemplate->cc_name = explode(';', replaceTemplateVars($modelMailTemplate->cc_name));
            }

            if ($modelMailTemplate->bcc) {
                $modelMailTemplate->bcc = explode(';', replaceTemplateVars($modelMailTemplate->bcc));
                $modelMailTemplate->bcc_name = explode(';', replaceTemplateVars($modelMailTemplate->bcc_name));
            }

            if (isset($_POST['embedded_images']) && ($pathCidString = $_POST['embedded_images'])) {
                $embeddedImages = explode('|', $pathCidString);
                if (count($embeddedImages) > 0) {
                    foreach ($embeddedImages as $embeddedImage) {
                        $pathCid = explode('=', $embeddedImage);
                        if (count($pathCid) === 2) {
                            $pathCid[0] = replaceTemplateVars($pathCid[0]);
                            $mailerSearch[] = $baseUrl . $pathCid[0];
                            $replace[] = 'cid:' . $pathCid[1];
                        }
                        $params['AddEmbeddedImage'][] = $pathCid;
                    }
                }
            }

            if (isset($_POST['attachments']) && ($pathAttachmentString = $_POST['attachments'])) {
                $attachments = explode('|', $pathAttachmentString);
                if (count($attachments) > 0) {
                    foreach ($attachments as $attachment) {
                        $pathAttachment = explode('=', $attachment);
                        $pathAttachment[0] = replaceTemplateVars($pathAttachment[0]);
                        $params['Attachments'][] = $pathAttachment;
                    }
                }
            }
            $modelMailTemplate->setBasePath($basePath);
            $modelMailTemplate->body = str_replace($mailerSearch, $replace, $modelMailTemplate->body);


            $sendRes = $modelMailTemplate->send_mail($params);
            $time = time();
            if ($sendRes['status']) {
                $result['success_count']++;
                if ($type === 'list') {
                    $sqlLog = "INSERT INTO `$tableSuccess` (`registration_id`, `list_id`, `template_id`, `created_at`) VALUES ($regId, $listId, $templateId, $time)";
                    mysql_query($sqlLog);
                }
            } else {
                $result['error_count']++;
                if ($type === 'list') {
                    $sqlError = "INSERT INTO `$tableError` (`registration_id`, `list_id`, `template_id`, `created_at`, `error_message`) VALUES ($regId, $listId, $templateId, $time, '{$sendRes['error_message']}')";
                    mysql_query($sqlError);
                }
            }
        }
    }
    echo json_encode($result);
}
exit;