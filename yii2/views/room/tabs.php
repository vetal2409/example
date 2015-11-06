<?php
use kartik\tabs\TabsX;

/**
 * @var $items array()
 */
?>

<?= TabsX::widget([
    'items' => $items,
    'position' => TabsX::POS_ABOVE,
    'encodeLabels' => false
])
?>