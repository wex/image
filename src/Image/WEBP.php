<?php declare(strict_types=1);

namespace Wex\Image;

class WEBP extends ImageAbstract implements FormatInterface
{
    public function save(string $filename = null, int $quality = -1): bool
    {
        return imagewebp($this->res, $filename, ($quality >= 0) ? $quality : 80);
    }

    public static function resourceFromFile(string $filename)
    {
        return imagecreatefromwebp($filename);
    }
}