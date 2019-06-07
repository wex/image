<?php

    use Wex\Image;
    use Wex\Rect;

    require_once '../vendor/autoload.php';

    $image = Image::load('test.jpg');

    $rect = new Rect(230, 40, 0, 0, 400, 180);
    $crop = $image->crop($rect);
    $crop->save('crop.jpg');

    $wheel = $image->rotate(90);
    $wheel->save('rotate.jpg');

    $thumb = $image->resize(160, 120);
    $thumb->saveAs(Image\PNG::class, 'resize.png');

    $mirror = $image->mirror(true);
    $mirror->saveAs(Image\WEBP::class, 'mirror.webp');