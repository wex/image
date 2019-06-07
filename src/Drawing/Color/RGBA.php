<?php declare(strict_types=1);

namespace Wex\Drawing\Color;

use Wex\Image\FormatAbstract;
use Wex\Drawing\DrawInterface;

class RGBA
{
    public  $res;
    public  $r;
    public  $g;
    public  $b;
    public  $a;

    public function __construct(FormatAbstract $image, int $r, int $g, int $b, int $a)
    {
        $this->r    = min(max(0, $r), 255);
        $this->g    = min(max(0, $g), 255);
        $this->b    = min(max(0, $b), 255);
        $this->a    = min(max(0, $a), 127);
        $this->res  = imagecolorallocatealpha($image->res, $this->r, $this->g, $this->b, $this->a);
    }

    public function __toString()
    {
        return sprintf("rgba(%d, %d, %d, %.2f) <span style='display: inline-block; width: 12px; height: 12px; background-color: #%02X%02X%02X;'></span>",
            $this->r, $this->g, $this->b, round($this->a / 127, 2),
            $this->r, $this->g, $this->b
        );
    }
}