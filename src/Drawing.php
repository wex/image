<?php declare(strict_types=1);

namespace Wex;

use Wex\Image\FormatAbstract;
use Wex\Drawing\Color;
use Wex\Drawing\Color\RGBA;
use Wex\Drawing\Pen;

class Drawing
{
    protected   $image;

    public function __construct(FormatAbstract &$image)
    {
        $this->image = $image;
    }

    public function with(...$arguments)
    {
        foreach ($arguments as $argument) {
            if (!is_object($argument))
                throw new \InvalidArgumentException("Invalid argument.");

            switch (get_class($argument)) {
                case Pen::class:
                    $argument->apply($this->image);
                    break;
                default:
                    throw new \InvalidArgumentException("Unknown argument.");
            }
        }

        return $this;
    }

    public function then(callable $callback) 
    {
        return $callback->call($this);
    }

    public function line($x1, int $y1 = 0, int $x2 = 0, int $y2 = 0): void
    {
        if ($x1 instanceof Rect) {
            $y1 = $x1->y;
            $x2 = $x1->x2;
            $y2 = $x1->y2;
            $x1 = $x1->x;
        }

        imageline($this->image->res, $x1, $y1, $x2, $y2, IMG_COLOR_STYLED);
    }
}