<?php
/**
 * Created for LeadVertex
 * Date: 25.05.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace XAKEPEHOK\Path;

use PHPUnit\Framework\TestCase;

class FileNameTest extends TestCase
{

    public function testConstructEmpty()
    {
        $this->expectException(EmptyFileNameException::class);
        new FileName('');
    }

    public function slashDataProvider(): array
    {
        return [
            ['file.zip/'],
            ['/file.zip'],
            ['//file.zip'],
            ['file.zip//'],
            ['\\file.zip'],
            ['file.zip\\'],
            ['file\.zip'],
            ['../file.zip'],
            ['..\file.zip'],
            ['/////'],
            ['\\\\\\'],
        ];
    }

    /**
     * @dataProvider slashDataProvider
     * @param string $name
     * @return void
     */
    public function testConstructWithSlash(string $name): void
    {
        $this->expectException(FileNameSlashException::class);
        new FileName($name);
    }

    public function dataProvider(): array
    {
        return [
            ['file.zip', 'file', 'zip'],
            ['file.zip.zip', 'file.zip', 'zip'],
            ['file', 'file', null],
            ['file.', 'file', ''],
            ['.file', '', 'file'],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param string $fullName
     * @param string $shortName
     */
    public function testGetName(string $fullName, string $shortName)
    {
        $file = new FileName($fullName);
        $this->assertSame($fullName, $file->getName());
        $this->assertSame($shortName, $file->getName(false));
    }

    /**
     * @dataProvider dataProvider
     * @param string $fullName
     * @param string $shortName
     * @param string|null $ext
     */
    public function testGetExtension(string $fullName, string $shortName, ?string $ext)
    {
        $file = new FileName($fullName);
        $this->assertSame($ext, $file->getExtension());
    }

    /**
     * @dataProvider dataProvider
     * @param string $fullName
     */
    public function testToString(string $fullName)
    {
        $file = new FileName($fullName);
        $this->assertSame($fullName, (string) $file);
    }

    /**
     * @dataProvider dataProvider
     * @param string $fullName
     */
    public function testJsonSerialize(string $fullName)
    {
        $file = new FileName($fullName);
        $this->assertSame(json_encode($fullName), json_encode($file));
    }
}
