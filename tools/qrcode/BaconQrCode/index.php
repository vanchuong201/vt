<?php
$renderer = new \BaconQrCode\Renderer\Image\Png();
$renderer->setHeight(256);
$renderer->setWidth(256);
$writer = new \BaconQrCode\Writer($renderer);
$writer->writeFile('Hello World!', 'qrcode.png');
?>