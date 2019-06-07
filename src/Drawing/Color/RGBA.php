<?php declare(strict_types=1);

namespace Wex\Drawing\Color;

use Wex\Image\FormatAbstract;

class RGBA
{
    public  $res;
    public  $r;
    public  $g = 0;
    public  $b = 0;
    public  $a = 0;

    public function __construct(FormatAbstract $image, int $r, int $g, int $b, int $a)
    {
        $this->r    = $r;
        $this->g    = $g;
        $this->b    = $b;
        $this->a    = $a;
        $this->res  = imagecolorallocatealpha($image->res, $this->r, $this->g, $this->b, $this->a);
    }
}