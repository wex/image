<?php declare(strict_types=1);

namespace Wex\Image;

class GIF extends ImageAbstract implements FormatInterface
{
    public function save(string $filename, int $quality = -1): bool
    {
        return imagegif($this->res, $filename);
    }

    public static function resourceFromFile(string $filename)
    {
        return imagecreatefromgif($filename);
    }
}