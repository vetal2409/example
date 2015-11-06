<?php
//require_once '../../../components/Model.php';
/**
 * This is the model class for table "mail_templates".
 *
 * The followings are the available columns in table 'mail_templates':
 * @property integer $id
 * @property string $name
 * @property string $subject
 * @property string $from
 * @property string $from_name
 * @property string $cc
 * @property string $cc_name
 * @property string $bcc
 * @property string $bcc_name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted
 */
class MailTemplates extends Model
{
    public $to;
    public $to_name;
    public $body;

    public $subject;
    public $from;
    public $from_name;
    public $reply_to;
    public $reply_to_name;
    public $cc;
    public $cc_name;
    public $bcc;
    public $bcc_name;

    private $basePath = '../..';

    /**
     * @param $path
     */
    public function setBasePath($path)
    {
        $this->basePath = $path;
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'mailer_template';
    }

    public function initMailer()
    {
        include dirname(__FILE__) . '/../../../extensions/PHPMailer/PHPMailerAutoload.php';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'subject' => 'Subject',
            'from' => 'From',
            'from_name' => 'From Name',
            'cc' => 'Cc',
            'cc_name' => 'Cc Name',
            'bcc' => 'Bcc',
            'bcc_name' => 'Bcc Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted' => 'Deleted'
        );
    }

    /**
     * @param array $params
     * @return bool
     */
    public function send_mail(array $params)
    {
        //require dirname(__FILE__) . '/../extensions/PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;

        if ($_SERVER['SERVER_ADDR'] !== '127.0.0.1' || $_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = '195.30.255.129';  // Specify main and backup server
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'events@seera.de'; // SMTP username
            $mail->Password = 'seera#TM&99';                           // SMTP password
            //$mail->SMTPSecure = 'tls'; ted
        }

        $mail->From = $this->from;
        $mail->FromName = $this->from_name;

        $mail->addAddress($this->to, $this->to_name); // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional

        if ($this->reply_to) {
            $mail->addReplyTo($this->reply_to, $this->reply_to_name);
        } else {
            $mail->addReplyTo($this->from, $this->from_name);
        }

        if (is_array($this->cc) && count($this->cc)) {
            foreach ($this->cc as $cc_key => $cc) {
                $mail->addCC($cc, $this->cc_name[$cc_key]);
            }
        }

        if (is_array($this->bcc) && count($this->bcc)) {
            foreach ($this->bcc as $bcc_key => $bcc) {
                $mail->addBCC($bcc, $this->bcc_name[$bcc_key]);
            }
        }

        if (array_key_exists('AddEmbeddedImage', $params) && (count($params['AddEmbeddedImage']))) {
            foreach ($params['AddEmbeddedImage'] as $pathCid) {
                $mail->AddEmbeddedImage($this->basePath . $pathCid[0], $pathCid[1]);
            }
        }

        if (array_key_exists('Attachments', $params) && (count($params['Attachments']))) {
            foreach ($params['Attachments'] as $pathAttachment) {
                if (isset($pathAttachment[1]) && $pathAttachment[1]) {
                    $mail->addAttachment($this->basePath . $pathAttachment[0], $pathAttachment[1]);
                } else {
                    $mail->addAttachment($this->basePath . $pathAttachment[0]);
                }
            }
        }
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name*/

        $mail->WordWrap = 50; // Set word wrap to 50 characters
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $this->subject;
        $mail->Body = $this->body;
        //$mail->AltBody = $this->body;
        $mail->CharSet = 'UTF-8';
        $res['status'] = $mail->send();
        if (!$res['status']) {
            $res['error_message'] = $mail->ErrorInfo;
        }
        return $res;
    }
}