<?php declare(strict_types=1);

namespace Wex\Image;

class JPEG extends FormatAbstract
{
    public function save(string $filename = null, int $quality = -1): bool
    {
        return imagejpeg($this->res, $filename, $quality);
    }

    public static function resourceFromFile(string $filename)
    {
        return imagecreatefromjpeg($filename);
    }
}