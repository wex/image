<?php declare(strict_types=1);

namespace Wex\Image;

use Wex\Rect;
use Wex\Drawing\Color\RGBA;

abstract class FormatAbstract extends ImageAbstract implements FormatInterface
{
    protected   $_colors = [];

    public function resize(int $width, int $height, int $method = self::RESIZE_CONTAIN, int $x = null, int $y = null): self
    {
        $target = new Rect;
        $source = $this->getRect();

        switch ($method) {
            // Keep image between given (width, height)
            case self::RESIZE_CONTAIN:
                if (($this->width / $width) > ($this->height / $height)) {
                    $target->w      = $width;
                    $target->h      = round($this->height / ($this->width / $width));
                } else {
                    $target->h      = $height;
                    $target->w      = round($this->width / ($this->height / $height));
                }
                $image = new static($target->w, $target->h);
                break;

            // Fit image to fill (width, height)
            case self::RESIZE_COVER:
                if (($this->width / $width) > ($this->height / $height)) {
                    $target->h      = $height;
                    $target->w      = round($this->width / ($this->height / $height));
                    $target->x      = round(($width - $target->w) / 2);
                } else {
                    $target->w      = $width;
                    $target->h      = round($this->height / ($this->width / $width));
                    $target->y      = round(($height - $target->h) / 2);
                }
                $image = new static($width, $height);
                break;

            // Crop from image to fit (width, height)
            case self::RESIZE_CROP:
                $target->w          = $width;
                $target->h          = $height;
                $source->x          = is_null($x) ? round(($source->w - $width) / 2) : $x;
                $source->y          = is_null($y) ? round(($source->h - $height) / 2) : $y;
                $source->w          = $width;
                $source->h          = $height;
                $image = new static($width, $height);
                break;
        }

        $image->resample($this, $target, $source);

        return $image;
    }

    public function resample(self $image, Rect $target, Rect $source = null): self
    {
        
        if (null === $source) {
            $source = $image->getRect();
        }

        if (!imagecopyresampled(
            $this->res, 
            $image->res,
            $target->x,
            $target->y,
            $source->x,
            $source->y,
            $target->w,
            $target->h,
            $source->w,
            $source->h
        )) throw new \RuntimeException("Resampling failed.");

        return $this;
    }

    public function copy(): self
    {
        return clone $this;
    }

    public function crop(Rect $rect): self
    {
        return $this->resize($rect->w, $rect->h, self::RESIZE_CROP, $rect->x, $rect->y);
    }

    public function rotate(float $deg): self
    {
        $resource = imagerotate($this->res, $deg, 0);

        $image = new static(
            imagesx($resource),
            imagesy($resource),
            $resource
        );

        // Crop back to original size (½-focus)
        $result = $image->resize($this->width, $this->height, self::RESIZE_CROP);

        // GC is less trustworthy than Jewish Nazi.
        unset($image);
        imagedestroy($resource);

        return $result;
    }

    public function mirror(bool $x = true, bool $y = false): self
    {
        $image = clone $this;
        
        if ($x && $y) {
            imageflip($image->res, IMG_FLIP_BOTH);
        } else if ($x) {
            imageflip($image->res, IMG_FLIP_HORIZONTAL);
        } else if ($y) {
            imageflip($image->res, IMG_FLIP_VERTICAL);
        }

        return $image;
    }

    public function color($r, $g, $b, $a = 0)
    {
        $hash = sprintf("%02X%02X%02X%02X", $r, $g, $b, $a);

        if (!isset($this->_colors[$hash])) {
            $this->_colors[$hash] = new RGBA($this, $r, $g, $b, $a);
        }

        return $this->_colors[$hash];
    }
}