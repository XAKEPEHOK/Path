# Path [![Build Status](https://travis-ci.com/XAKEPEHOK/Path.svg?branch=master)](https://travis-ci.com/XAKEPEHOK/Path)
Path class help you easy manipulate to any path (unix-style, windows-style, uri path), going up and down, extract last
path item, detect project root and more. This lib not work with file system. Its just help you manipulate path string. 

### Installation:
```bash
composer require xakepehok/path
```

## Path manipulation

### Unix-style path:
```php
# Create path object with some path and define path separator.
# If separator not defined, it will be detected from passed path string
$path = new \XAKEPEHOK\Path\Path('/any/path/here');

# /any/path
echo $path->up(); 

# /any/path/here/down_1/down_2
echo $path->down('down_1')->down('down_2'); 

# /any/path/here/down_1/down_2
echo $path->down('down_1/down_2'); 

# Backslash will be replaced by slash, because path already contain slash
# /any/path/here/down_1/down_2
echo $path->down('down_1\down_2'); 

$subPath = new \XAKEPEHOK\Path\Path('dir_1/dir_2')

# /any/path/here/dir_1/dir_2
echo $path->down($subPath); 

# /any/path/down_1/dir_1/dir_2
echo $path->up()->down('down_1/down_2')->up()->down($subPath);
```

### Windows-style path:
```php
$path = new \XAKEPEHOK\Path\Path('C:\\Windows');

# C:\
echo $path->up(); 

# C:\Windows\System32\drivers
echo $path->down('System32')->down('drivers'); 

# C:\Windows\System32\drivers
echo $path->down('System32\drivers'); 

# Slash will be replaced by backslash, because path already contain backslash
# C:\Windows\System32\drivers\etc
echo $path->down('System32/drivers\etc'); 

$subPath = new \XAKEPEHOK\Path\Path('Adobe/Photoshop')

# C:\Windows\System32\drivers
echo $path->down($subPath); 

# C:\Program Files\Adobe\Photoshop
echo $path->up()->down('Program Files\\Microsoft')->up()->down($subPath);
```

### Uri path (works like unix-style path):
```php
$path = new \XAKEPEHOK\Path\Path('https://example.com/path');

# https://example.com
echo $path->up(); 

# https://example.com/path/dir_1/dir_2
echo $path->down('dir_1')->down('dir_2'); 

# https://example.com/path/down_1/down_2
echo $path->down('down_1/down_2'); 

# Backslash will be replaced by slash, because path already contain slash
# https://example.com/path/down_1/down_2
echo $path->down('down_1\down_2'); 

$subPath = new \XAKEPEHOK\Path\Path('dir_1/dir_2')
```

### End of path
```php
$path = new \XAKEPEHOK\Path\Path('/etc/nginx/nginx.conf');

# Return FileName object
$filename = $path->end();

# nginx
echo $filename->getName(false); //without extension

# nginx.conf
echo $filename->getName(true); //with extension

# conf
echo $filename->getExtension(); //extension

# true
echo $filename->hasExtension(); //bool true if file has extension
```

## Detect project root path
```php
# Return you project root path (dir that contain composer's vendor dir).
# Its detected by reflection of \Composer\Autoload\ClassLoader.php placement
$path = \XAKEPEHOK\Path\Path::root();
```