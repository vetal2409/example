<?
use common\models\Registration;
use common\models\Payment;
use yii\helpers\Html;

/**
 * @var $model common\models\Registration
 * @var $payment common\models\Payment
 * @var $invoice common\models\Invoice
 */
?>
<?
$payment = new Payment();

$price = (double)$invoice->newAmount - round(($invoice->newAmount * 0.19), 2);

$percent = round(($invoice->newAmount * 0.19), 2);
$summ = round(($price + $percent), 2);
?>

<table style="margin:0px auto;padding:20px;">
    <tr>
        <td colspan="2" align="right">
            <?= Html::img('/statics/images/Logo_magenta.jpg') ?>
        </td>
    </tr>

    <tr>
        <td colspan="2" align="right" style="padding:10px">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" align="right" style="padding:10px">&nbsp;</td>
    </tr>
    <tr>
        <td width="70%;padding-top:20px">
            <p style="padding-bottom:10px;font-size:6pt;">CWT Beheermaatschappij B.V. Deutschland, Campus Kronberg 7,
                61476 Kronberg</p>

            <p><?php echo $model->company ?><br><?php echo $model->first_name ?> <?php echo $model->last_name ?>
                <br><?php echo $model->street ?><br><?php echo $model->zip ?> <?php echo $model->city ?></p>

            <p>&nbsp;</p>

            <p>&nbsp;</p>

            <p>&nbsp;</p>

            <p style="font-size:12pt"><b>Buchungsgebühr für die Zimmerreservierung Kontingent ABB anlässlich der
                    Hannover Messe 2015<br></b></p>

            <p>&nbsp;</p>

            <p><b>Rechnung CWT2015-<?php echo str_pad($invoice->id, 4, '0', STR_PAD_LEFT) ?></b></p>

            <p><?= $invoice->subject ?></p>

            <p><?= '<b>Referred to invoice CWT2015-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT).'</b>' ?></p>

            <p></p>
        </td>

        <td width="30%" align="right">
            <table style="width:100%;">

                <tr>
                    <td align="right">Datum:</td>
                    <td align="right"><?php echo date('d.m.Y', $model->created_at) ?></td>
                </tr>
            </table>
        </td>

    </tr>


    <!--    <tr>
        <td colspan="2"><p><?php echo Yii::t('general', $model->title); ?>
                , <?= $model->first_name . ' ' . $model->last_name ?></p></td>
    </tr>-->
    <tr>
        <td colspan="2">
            <p>&nbsp;</p>

            Wir erlauben uns, Ihnen für die Zimmerreservierung anlässlich der Hannover Messe 2015 folgende Summe in
            Rechnung zu stellen:<br><br></td>
    </tr>
    <tr>


        <td colspan="2">
            <table width="640">
                <tr>


                    <td style="border-bottom:1px solid #333333;color:#1d0e46"><b>Leistung</b></td>
                    <td align="right" style="border-bottom:1px solid #333333;color:#1d0e46"><b>Gesamtkosten € Netto</b>
                    </td>
                    <td align="right" style="border-bottom:1px solid #333333;color:#1d0e46"><b>MWSt.</b></td>
                </tr>

                <tr>
                    <td style="border-bottom:1px solid #cccccc"><?= $payment->orderDescription ?></td>
                    <td align="right" style="border-bottom:1px solid #cccccc"><?= $price ?> €</td>
                    <td align="right" style="border-bottom:1px solid #cccccc">19%</td>
                </tr>

                <!--                --><?php //if($roomtype=="Doppelzimmer"){?>
                <!--                    <tr>-->
                <!--                        <td style="border-bottom:1px solid #cccccc">2. Doppelzimmerzuschlag, 25,00 EUR/ Nacht</td>-->
                <!--                        <td align="right" style="border-bottom:1px solid #cccccc">-->
                <? //= $hotelnetto?><!-- €</td>-->
                <!--                        <td align="right" style="border-bottom:1px solid #cccccc">19%</td>-->
                <!--                    </tr>-->
                <!--                --><?php //} ?>




                <tr>
                    <td style="border-bottom:1px solid #333333;color:#1d0e46">&nbsp;</td>
                    <td align="right" style="border-bottom:1px solid #333333;color:#1d0e46">&nbsp;</td>
                    <td style="border-bottom:1px solid #333333;color:#1d0e46">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #cccccc"><b>Gesamtsumme (netto)</b></td>
                    <td align="right" style="border-bottom:1px solid #cccccc"><?= $price ?> €</td>
                    <td style="border-bottom:1px solid #cccccc">&nbsp;</td>

                </tr>

                <tr>
                    <td style="border-bottom:2px solid #000000">Umsatzsteuer 19%</td>
                    <td align="right" style="border-bottom:2px solid #000000"><?= $percent ?> €</td>
                    <td style="border-bottom:2px solid #000000">&nbsp;</td>

                </tr>

                <tr>
                    <td style="border-bottom:3px solid double #000000"><b>Gesamtsumme (brutto)</b></td>
                    <td align="right" style="border-bottom:3px solid double #000000"><b><?= $summ ?> €</b></td>
                    <td style="border-bottom:3px solid double #000000">&nbsp;</td>

                </tr>


                <tr>
                    <td style="border-bottom:1px solid #333333;color:#1d0e46">&nbsp;</td>
                    <td align="right" style="border-bottom:1px solid #333333;color:#1d0e46">&nbsp;</td>
                    <td style="border-bottom:1px solid #333333;color:#1d0e46">&nbsp;</td>
                </tr>

                <tr>
                    <td style="border-bottom:1px solid #cccccc">Bezahlung über WIRECARD</td>
                    <td align="right" style="border-bottom:1px solid #cccccc">(<?= $summ ?> €)</td>
                    <td style="border-bottom:1px solid #cccccc">&nbsp;</td>

                </tr>

                <tr>
                    <td style="border-bottom:3px solid #000000"><b>Gesamtsumme offen</b></td>
                    <td align="right" style="border-bottom:3px solid #000000"><b>0.00 €</b></td>
                    <td style="border-bottom:3px solid #000000">&nbsp;</td>

                </tr>


            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">


            <p>&nbsp;</p>

            <p>coladaservices GmbH ist für die Zahlungsabwicklung dieser Veranstaltung verantwortlich und handelt im
                Namen und Auftrag der CWT Beheermaatschappij B.V. Deutschland . Auf Ihrer Kreditkartenabrechnung
                erscheint deshalb coladaservices GmbH.</p>

            <p>&nbsp;</p>

            <p><b><?= $invoice->finalText?></b></p>

            <p>&nbsp;</p>

            <p>&nbsp;</p>

            <p style="font-size:9pt"><b>On behalf of CWT Beheermaatschappij B.V. Deutschland</b><br>
                coladaservices gmbh<br>
                Schwanthaler Str. 73<br>
                80336 München<br>
                Telefon: +49 89 7806 0892<br>
                Email: support@coladaservices.com
                <br><br>
                <b>CWT Beheermaatschappij B.V. Deutschland</b> <br>
                Deutsche Zweigniederlassung der CWT Beheermaatschappij B.V.<br>
                Sitz der Zweigniederlassung: Frankfurter Straße 10-14, 65760 Eschborn, Deutschland<br>
                Registergericht: Amtsgericht Frankfurt/Main HRB 44172 <br>
                Umsatzsteuer-Identifikationsnummer gemäß § 27 a Umsatzsteuergesetz: DE 191 187 110 </p>
        </td>
    </tr>


</table>