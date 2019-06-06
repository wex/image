<?php declare(strict_types=1);

namespace Wex\Image;

interface FormatInterface
{
    public static function resourceFromFile(string $filename);

    public function save(string $filename, int $quality = -1): bool;
}