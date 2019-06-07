<?php

require_once '../vendor/autoload.php';

use Wex\Image;
use Wex\Drawing\Pen;

$image = Image::load("test.jpg");

$image->draw(
    new Pen(5, $image->color(255, 0, 0), Pen::STYLE_SOLID)
)->then(function() {
    
    $this->line(50, 50, 250, 50);
    $this->line(250, 50, 250, 250);
    $this->line(250, 250, 50, 250);
    $this->line(50, 250, 50, 50);

});

$image->render();