# Example projects

##nodejs/chat
real-time using socket.io


##crypto-cookie-with-sign
template for authentication user using cookie, crypt and sign


##clear php/grid-data 
Demo (login: example   password: example): https://www.seera.de/example/backend/index.php

extension for generating  Grid Data Table
-sort
-pagination
-search
-flaxible manage columns
-fast editable
-Comfortable manipulation of data:
```php
    'SerialColumn' => array(
        'type' => 'template'
    ),
    'CheckboxColumn' => array(
        'type' => 'template',
        'attributeValue' => 'regid'
    ),
    'edit-reg' => array(
        'type' => 'new',
        'label' => 'Frontend',
        'value' => function ($data) {
            return '<a href="../registration.php?regid=' . $data['regid'] . '&guid=' . $data['guid'] . '&
            step=1&para=backend" class="new-window">Link</a>';
        }
    ),
    'rechnungsanschrift' => array(
        'label' => 'Rechnungsadresse',
        'value' => function ($data) {
            return $data['rechnungsanschrift'] . ' - test';
        },
        'valueExport' => function ($data) {
            return $data['rechnungsanschrift'] . ' - test';
        },
        'headerOptions' => array(
            'id' => 'some-id',
            'style' => array(
                'min-width' => '275px'
            )
        ),
        'labelOptions' => array(
            'id' => 'some-id-for-text',
            'style' => array(
                'color' => 'red',
                'font-size' => '13px',
            )
        )
    )
 ```
 
 
##js&php/MailerTemplate
Demo (login: example   password: example): https://www.seera.de/example/backend/index.php  Action->Mailer

JavaScript plugin for Mass mailing
- create Mailer lists
- Send to cheched participants or to List
- opportunity to continue sending after pausa (when we use lists)
- flexible manage params for Mail
- opportunity to edit Mailer template
- generating passkit, qr/bar codes, invoices, print@home, attachments 


##yii2
Hotel Booking module
MultiLanguage + lang ID in url

##yii1
TLS: Big and old project where peolpe can find jobs. There are a lot of datails, but here are only "Skill" part.
