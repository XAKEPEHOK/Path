<?php
/**
 * Created for Path
 * Datetime: 18.02.2020 18:38
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace XAKEPEHOK\Path;

use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{

    public function pathDataProvider(): array
    {
        return [
            ['C:\\Windows\\System32', 'C:\\Windows\\System32'],
            ['C:\\Windows/System32', 'C:\\Windows\\System32'],
            ['/etc/hosts', '/etc/hosts'],
            ['etc/hosts', 'etc/hosts'],
            [new Path('C:\\Windows\\System32'), 'C:\\Windows\\System32'],
            [new Path('C:\\Windows/System32'), 'C:\\Windows\\System32'],
            [new Path('/etc/hosts'), '/etc/hosts'],
            [new Path('etc/hosts'), 'etc/hosts'],
        ];
    }

    /**
     * @dataProvider pathDataProvider
     * @param $expected
     * @param string $actual
     */
    public function testConstruct($expected, string $actual)
    {
        $path = new Path($expected);
        $this->assertSame((string) $path, $actual);
    }

    public function upDataProvider(): array
    {
        return [
            [new Path('/'), ''],
            [new Path('C:\\Windows\\System32'), 'C:\\Windows'],
            [new Path('C:\\Windows/System32'), 'C:\\Windows'],
            [new Path('/etc/hosts'), '/etc'],
            [new Path('etc/hosts'), 'etc'],
        ];
    }

    /**
     * @dataProvider upDataProvider
     * @param $path
     * @param string $expected
     */
    public function testUp(Path $path, string $expected)
    {
        $this->assertSame(
            $expected,
            (string) $path->up()
        );
    }

    public function downDataProvider(): array
    {
        return [
            [new Path('/'), 'down', '/down'],
            [new Path('C:\\Windows\\System32'), 'down', 'C:\\Windows\\System32\\down'],
            [new Path('C:\\Windows/System32'), 'down', 'C:\\Windows\\System32\\down'],
            [new Path('C:\\Windows\\System32'), new Path('down\\down'), 'C:\\Windows\\System32\\down\\down'],
            [new Path('C:\\Windows/System32'), new Path('down/down'), 'C:\\Windows\\System32\\down\\down'],
            [new Path('C:\\Windows/System32'), new Path('/down/down'), 'C:\\Windows\\System32\\down\\down'],
            [new Path('/etc/hosts'), 'down', '/etc/hosts/down'],
            [new Path('/etc/hosts'), new Path('down/down'), '/etc/hosts/down/down'],
            [new Path('/etc/hosts'), new Path('/down/down'), '/etc/hosts/down/down'],
            [new Path('/etc/hosts'), new Path('\\down\\down'), '/etc/hosts/down/down'],
        ];
    }

    /**
     * @dataProvider downDataProvider
     * @param $path
     * @param $down
     * @param string $expected
     */
    public function testDown(Path $path, $down, string $expected)
    {
        $this->assertSame(
            $expected,
            (string) $path->down($down)
        );
    }

    public function endDataProvider(): array
    {
        return [
            [new Path('/'), null],
            [new Path('C:\\Windows\\System32'), 'System32'],
            [new Path('C:\\Windows/System32'), 'System32'],
            [new Path('/etc/hosts'), 'hosts'],
            [new Path('etc/hosts'), 'hosts'],
        ];
    }

    /**
     * @dataProvider endDataProvider
     * @param $path
     * @param string|null $expected
     */
    public function testEnd(Path $path, ?string $expected)
    {
        if (is_null($expected)) {
            $this->assertNull($path->end());
        } else {
            $this->assertEquals(new FileName($expected), $path->end());
        }
    }

}
