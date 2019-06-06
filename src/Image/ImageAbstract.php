<?php declare(strict_types=1);

namespace Wex\Image;

use Wex\Rect;

abstract class ImageAbstract
{
    const       RESIZE_CONTAIN  = 0;
    const       RESIZE_COVER    = 1;
    const       RESIZE_CROP     = 2;

    protected   $res = null;
    protected   $width;
    protected   $height;

    static  $formats = [
        IMAGETYPE_JPEG  => JPEG::class,
        IMAGETYPE_PNG   => PNG::class,        
    ];

    public function __construct(int $width, int $height, $resource = null)
    {
        $this->width    = $width;
        $this->height   = $height;

        if (null === $resource) {
            $this->res      = \imagecreatetruecolor($this->width, $this->height);
        } else {
            $this->res      = $resource;
            $this->width    = imagesx($this->res);
            $this->height   = imagesy($this->res);
        }
    }

    public static function load(string $filename): self
    {
        if (!file_exists($filename))
            throw new \RuntimeException("File '{$filename}' not found.");

        if (!is_readable($filename))
            throw new \RuntimeException("File '{$filename}' could not be read.");

        $info       = getimagesize($filename);
        $instance   = static::$formats[ $info[2] ] ?? false;
        $width      = $info[0];
        $height     = $info[1];

        if (!$instance)
            throw new \RuntimeException("Invalid format: {$info[2]}");

        return new $instance($width, $height, $instance::resourceFromFile($filename));
    }

    public function getRect(): Rect
    {
        return new Rect(0, 0, $this->width, $this->height);
    }

    public function saveAs(string $foo, string $filename, int $quality = -1): bool
    {
        $instance = new $foo(0, 0, $this->res);
        if (!($instance instanceof FormatInterface))
            throw new \InvalidArgumentException("Invalid Format: {$foo}");

        return $instance->save($filename, $quality);
    }
}