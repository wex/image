<?php declare(strict_types=1);

namespace Wex\Image;

use Wex\Rect;
use Wex\Drawing\Color;

abstract class ImageAbstract
{
    const       RESIZE_CONTAIN  = 0;
    const       RESIZE_COVER    = 1;
    const       RESIZE_CROP     = 2;

    public      $res = null;
    protected   $_width;
    protected   $_height;

    static  $formats = [
        IMAGETYPE_JPEG  => JPEG::class,
        IMAGETYPE_PNG   => PNG::class,      
        IMAGETYPE_GIF   => GIF::class,
        IMAGETYPE_WEBP  => WEBP::class,  
    ];

    public function __construct(int $width, int $height, $resource = null)
    {
        $this->_width    = $width;
        $this->_height   = $height;

        if (null === $resource) {
            $this->res      = \imagecreatetruecolor($this->_width, $this->_height);
        } else {
            $this->res      = $resource;
            $this->_width   = imagesx($this->res);
            $this->_height  = imagesy($this->res);
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
        return new Rect(0, 0, $this->_width, $this->_height);
    }

    public function saveAs(string $foo, string $filename, int $quality = -1): bool
    {
        $instance = new $foo(0, 0, $this->res);
        if (!($instance instanceof FormatInterface))
            throw new \InvalidArgumentException("Invalid Format: {$foo}");

        return $instance->save($filename, $quality);
    }

    public function createColor($r, int $g = 0, int $b = 0, int $a = 0): Color
    {
        return new Color($this, $r, $g, $b, $a);
    }

    public function __get($name)
    {
        switch ($name) {
            case 'width':   return $this->_width;
            case 'height':  return $this->_height;
        }
    }
}