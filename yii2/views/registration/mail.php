<?
/**
 * @var Registration $model
 * @var Invoice $invoice
 */

use \common\models\Registration;
use \common\models\Invoice;
use yii\helpers\Url;

$this->title = 'Summary';
?>
<div style="margin: 10px 60px 0 60px; border: 1px solid lightgrey;">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3"><b>Receiver </b>:</div>
                    <div class="col-md-9"><?= $model->email ?></div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3"><b>Sender </b>:</div>
                    <div class="col-md-9"><?= Yii::$app->params['adminEmail'] ?></div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3"><b>BCC </b>:</div>
                    <div class="col-md-9"><?= \common\helpers\MailHelper::BCC ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<? if (Yii::$app->language === 'en-US') : ?>
    <table width="750"
           style="max-width: 100%; margin: 0 auto; border:1px solid #ddd;background:#ffffff; padding: 25px; margin-top: 25px;"
           cellpadding="0" cellspacing="10">
        <tr>
            <td colspan="2" style="color: #000;">
                Dear <?= $model->title . ' ' . $model->last_name ?>,<br><br>
                We confirm your hotel reservation:
            </td>
        </tr>
        <tr style="">
            <td style="color: #9ac21b;" valign="top" nowrap>Location:</td>
            <td style=""><?= ($model->hotel->hotelData) ? $model->hotel->hotelData->location : '' ?></td>
        </tr>
        <tr style="">
            <td style="color: #9ac21b;" valign="top" nowrap>Booking date:</td>
            <td style="">
                <b>Check-In: <?= date('d-m-Y', $model->check_in) ?></b>
                <br>
                <b>Check-out: <?= date('d-m-Y', $model->check_out) ?></b>
            </td>
        </tr>
        <tr>
            <td style="color: #9ac21b;" valign="top" nowrap><?= Yii::t('registration', 'Price Information') ?>:</td>
            <td style=""><?= ($model->hotel->hotelData) ? $model->hotel->hotelData->price_information : '' ?></td>
        </tr>
        <tr>
            <td colspan="2" style="color: #000;">
                Attached please find the invoice for the service fee. Your credit card will be debited by
                „coladaservices gmbh, Munich“.<br>
                Please note, booking changes are not being possible.<br>
                Attached please find the invoice of the service fee.<br><br>
                For any questions please do not hesitate to contact: <a href="mailto:frankfurt@cwt-me.com">frankfurt@cwt-me.com</a><br><br>
                Sincerely,<br>
                Your booking team<br>
            </td>
        </tr>
    </table>
<? else : ?>
    <table width="750"
           style="max-width: 100%; margin: 0 auto; border:1px solid #ddd;background:#ffffff; padding: 25px; margin-top: 25px;"
           cellpadding="0" cellspacing="10">
        <tr>
            <td colspan="2" style="color: #000;">
                Sehr
                geehrte<?= $model->title === 'Mr.' ? 'r ' . $model->title : ' ' . $model->title ?> <?= $model->last_name ?>
                ,<br><br>
                Wir haben für Sie verbindlich das folgende Hotel gebucht:
            </td>
        </tr>
        <tr style="">
            <td style="color: #9ac21b;" valign="top" nowrap>Lage:</td>
            <td style=""><?= ($model->hotel->hotelData) ? $model->hotel->hotelData->location : '' ?></td>
        </tr>
        <tr style="">
            <td style="color: #9ac21b;" valign="top" nowrap>Buchungsdaten</td>
            <td style="">
                <b>Check-In: <?= date('d-m-Y', $model->check_in) ?></b>
                <br>
                <b>Check-out: <?= date('d-m-Y', $model->check_out) ?></b>
            </td>
        </tr>
        <tr>
            <td style="color: #9ac21b;" valign="top" nowrap><?= Yii::t('registration', 'Price Information') ?>:</td>
            <td style=""><?= ($model->hotel->hotelData) ? $model->hotel->hotelData->price_information : '' ?></td>
        </tr>
        <tr>
            <td colspan="2" style="color: #000;">
                Im Anhang finden Sie die Rechnung für die Hotelreservierung. Ihre Kreditkarte wird von der
                „coladaservices gmbh, München“ belastet.<br>
                Bitte beachten Sie, dass eine Änderung der Hotelreservierung nicht möglich ist.<br>
                Im Anhang finden Sie die Quittung für die Reservierungsgebühr.<br><br>
                Bei Rückfragen wenden Sie sich bitte an: <a
                    href="mailto:frankfurt@cwt-me.com">frankfurt@cwt-me.com</a><br><br>
                Ihr<br>
                Buchungsteam<br>
            </td>
        </tr>
    </table>
<? endif; ?>
<div style="margin-top: 10px; margin-left: 60px; margin-right: 60px; padding: 5px; border: 1px solid lightgrey">
    Attached file:
    <?= ($invoice) ? \yii\helpers\Html::a($invoice->invoice, Url::to('/statics/pdfs/' . $invoice->invoice), ['target' => 'blank']) : ''; ?>
</div>

<div class="row">
    <div class="col-md-offset-6 text-right">
        <div style="margin-right: 75px; margin-top: 10px">
            <?= \yii\helpers\Html::a('Send Email',
                Yii::$app->getUrlManager()->createUrl(['registration/send-email', 'code' => $model->code]),
                ['class' => 'btn btn-primary'])
            ?>
        </div>
    </div>
</div>