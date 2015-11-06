<?php
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//var_dump($_REQUEST);
//var_dump($_SERVER);exit;
require_once('../../components/Controller.php');
require_once(Controller::getBasePath() . '/include/config.php');
require_once('./models/MailTemplates.php');
?>

<div class="edit-category-page send-mail">
    <div class="wrap">
        <form action="" method="POST" id="f_register" class="mail-form">
            <input type="hidden" name="from" value=""/>
            <input type="hidden" name="from_name" value=""/>
            <input type="hidden" name="reply_to" value=""/>
            <input type="hidden" name="reply_to_name" value=""/>
            <input type="hidden" name="bcc" value=""/>
            <input type="hidden" name="bcc_name" value=""/>
            <input type="hidden" name="cc" value=""/>
            <table id="table_reg">
                <tr>
                    <td><label for="template">Template:</label></td>
                    <td>
                        <select id="template">
                            <option value=""></option>
                            <?php
                            foreach (MailTemplates::listData('id', 'name') as $t_id => $t_name):?>
                                <option value="<?= $t_id ?>"><?= $t_name ?></option>
                            <? endforeach; ?>
                        </select>
                    </td>

                </tr>

                <tr>
                    <td><label for="language-template">Language:</label></td>
                    <td>
                        <select id="language-template">
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="cc">Carbon Copy:</label></td>
                    <td><input type="text" name="cc" id="cc" value=""/></td>
                </tr>

                <tr>
                    <td><label for="cc_name">Carbon Copy Name:</label></td>
                    <td><input type="text" name="cc_name" id="cc_name" value=""/></td>
                </tr>

                <tr>
                    <td><label for="subject">Email subject:</label></td>
                    <td><input type="text" name="subject" id="subject"
                               value=""/></td>
                </tr>

                <tr>
                    <td colspan="2"><label for="mail-editor">Body:</label>
                        <textarea name="body" id="mail-editor" cols="60" rows="20"></textarea>
                        <script type="text/javascript">var body_editor = CKEDITOR.replace('mail-editor');</script>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div class="attachment-list-label"><label>Attachments:</label></div>
                        <ul class="attachment-list"><li>none</li></ul>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="last-sub">
<!--                        <input type="submit" class="update-btn" value="Send confirmation mail">-->
                        <button class="update-btn">Send Email</button>
                    </td>
                </tr>
            </table>
            <br/>
        </form>
    </div>
</div>