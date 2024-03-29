<?php
/**
 * Created for LeadVertex
 * Date: 25.05.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace XAKEPEHOK\Path;


use JsonSerializable;

class FileName implements JsonSerializable
{

    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new EmptyFileNameException('File name should not be empty');
        }

        if (preg_match('~[/\\\]~u', $name)) {
            throw new FileNameSlashException('File name should not contain slash or backslash');
        }

        $this->name = $name;
    }

    public function getName(bool $withExtension = true): string
    {
        if ($withExtension || !$this->hasExtension()) {
            return $this->name;
        }

        return substr($this->name, 0, strrpos($this->name, '.'));
    }

    public function hasExtension(): bool
    {
        return strpos($this->name, '.') !== false;
    }

    public function getExtension(): ?string
    {
        if (!$this->hasExtension()) {
            return null;
        }
        return substr($this->name, strrpos($this->name, '.') + 1);
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): string
    {
        return $this->name;
    }
}