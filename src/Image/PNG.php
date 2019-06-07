<?php declare(strict_types=1);

namespace Wex\Image;

class PNG extends ImageAbstract implements FormatInterface
{
    public function save(string $filename = null, int $quality = -1): bool
    {
        imagesavealpha($this->res, true);
        return imagepng($this->res, $filename, $quality);
    }

    public static function resourceFromFile(string $filename)
    {
        return imagecreatefrompng($filename);
    }
}