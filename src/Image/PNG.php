<?php declare(strict_types=1);

namespace Wex\Image;

class PNG extends ImageAbstract implements FormatInterface
{
    public function save(string $filename, int $quality = -1): bool
    {
        return imagepng($this->res, $filename, $quality);
    }

    public static function resourceFromFile(string $filename)
    {
        return imagecreatefrompng($filename);
    }
}