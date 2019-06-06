# Wex\Image
GD wrapper

# Installing
`composer require nhujanen/image`

# Requirements
PHP 7.1+
ext-gd with JPEG & PNG

# Supports
- JPEG
- PNG

# Provides
- Resizing (contain / cover -modes)
- Cropping (middle focus / free focus)
- Rotating (with cropping)
- Rect (with X2/Y2 -support)

# Usage
See `test/test.php`

Basic usage example:
```php
// Load test.png
$image = Wex\Image::load('test.png');

// Resize to 300x200 (contained)
$thumb = $image->resize(300, 200);

// Save image as JPEG
$thumb->saveAs(Wex\Image\JPEG::class, "test_thumb.jpg");
```