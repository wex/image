<?php declare(strict_types=1);

namespace Wex\Drawing;

use Wex\Image\FormatAbstract;
use Wex\Drawing\Color\RGBA;

class Pen implements DrawInterface
{
    const   STYLE_SOLID     = 'solid';
    const   STYLE_DOTTED    = 'dotted';
    const   STYLE_DASHED    = 'dashed';

    public $size;
    public $color;
    public $style;

    public function __construct(int $size, RGBA $color, string $style = self::STYLE_SOLID)
    {
        $this->size     = $size;
        $this->color    = $color;
        $this->style    = $style;
    }

    public function __toString()
    {
        return sprintf("%s - %s px - color %s",
            $this->style,
            $this->size,
            (string) $this->color
        );
    }

    protected function getStyle()
    {
        switch ($this->style) {
            case self::STYLE_SOLID:
                return function($c) { return [$c->res]; };

            case self::STYLE_DOTTED:
                return function($c) { $tp = $this->color(0, 0, 0, 127); return [$c->res, $tp->res]; };

            case self::STYLE_DASHED:
                return function($c) { $tp = $this->color(0, 0, 0, 127); return [$c->res, $c->res, $c->res, $tp->res, $tp->res, $tp->res]; };
        }
    }

    public function apply(FormatAbstract $image): void
    {
        $styler = $this->getStyle();
        imagesetthickness($image->res, $this->size);
        imagesetstyle($image->res, $styler->call($image, $this->color));
    }
}