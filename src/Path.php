<?php
/**
 * Datetime: 18.02.2020 17:27
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace XAKEPEHOK\Path;


use Composer\Autoload\ClassLoader;
use ReflectionClass;

class Path
{

    /** @var string */
    private $path;

    /** @var string */
    private $separator;

    /**
     * Path constructor.
     * @param string|self $path
     */
    public function __construct($path)
    {
        $chars = preg_split('//u', (string) $path, 0, PREG_SPLIT_NO_EMPTY);
        foreach ($chars as $char) {
            if (in_array($char, ['/', '\\'] , true)) {
                $this->separator = $char;
                $path = str_replace(['/', '\\'], $this->separator, $path);
                break;
            }
        }

        $this->path = rtrim((string) $path, $this->separator);
    }

    public function up(): self
    {
        if ($this->path === '') {
            return $this;
        }

        $parts = explode($this->separator, $this->path);
        return new Path(implode($this->separator, array_slice($parts, 0, -1)));
    }

    /**
     * @param string|self $path
     * @return $this
     */
    public function down($path): self
    {
        $path = ltrim((string) $path, '/\\');
        return new Path($this->path . $this->separator . $path);
    }

    public function end(): ?FileName
    {
        $parts = explode($this->separator, $this->path);
        $end = end($parts);
        if ($end === '') {
            return null;
        }
        return new FileName($end);
    }

    public function __toString()
    {
        return $this->path;
    }

    public static function root(): Path
    {
        $reflection = new ReflectionClass(ClassLoader::class);
        return (new Path($reflection->getFileName()))->up()->up()->up();
    }

}