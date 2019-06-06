<?php declare(strict_types=1);

namespace Wex;

class Rect
{
    protected $_x;
    protected $_y;
    protected $_w;
    protected $_h;

    public function __construct(int $x = 0, int $y = 0, int $w = 0, int $h = 0, int $x2 = null, int $y2 = null)
    {
        $this->_x = $x;
        $this->_y = $y;
        $this->_w = $w;
        $this->_h = $h;

        if (null !== $x2) {
            $this->x2 = $x2;
        }
        if (null !== $y2) {
            $this->y2 = $y2;
        }
    }

    public function __get(string $name)
    {
        switch ($name) {
            case 'x':   return $this->_x;
            case 'y':   return $this->_y;
            case 'w':   return $this->_w;
            case 'h':   return $this->_h;
            case 'x2':  return $this->_x + $this->_w;
            case 'y2':  return $this->_y + $this->_h;
        }
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'x':   return ($this->_x = (int) $value);
            case 'y':   return ($this->_y = (int) $value);
            case 'w':   return ($this->_w = (int) $value);
            case 'h':   return ($this->_h = (int) $value);
            case 'x2':  return ($this->_w = intval($value) - $this->_x);
            case 'y2':  return ($this->_h = intval($value) - $this->_y);
        }
    }
}