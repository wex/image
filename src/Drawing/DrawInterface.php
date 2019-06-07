<?php declare(strict_types=1);

namespace Wex\Drawing;

use Wex\Image\FormatAbstract;

interface DrawInterface
{
    public function __toString();

    public function apply(FormatAbstract $image): void;
}