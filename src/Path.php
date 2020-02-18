<?php
/**
 * Created for Path
 * Datetime: 18.02.2020 17:27
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace XAKEPEHOK\Path;


class Path
{

    /**
     * @var string
     */
    private $path;

    /**
     * Path constructor.
     * @param string|self $path
     */
    public function __construct($path)
    {
        $path = str_replace('\\', '/', $path);
        $this->path = rtrim((string) $path, '/');
    }

    public function up(): self
    {
        if ($this->path === '') {
            return $this;
        }

        $parts = explode('/', $this->path);
        return new Path(implode('/', array_slice($parts, 0, -1)));
    }

    /**
     * @param string|self $path
     * @return $this
     */
    public function down($path): self
    {
        $path = ltrim((string) $path, '/');
        return new Path($this->path . '/' . $path);
    }

    public function end(): string
    {
        $parts = explode('/', $this->path);
        return end($parts);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->path;
    }

    public function __toString()
    {
        return $this->path;
    }

}