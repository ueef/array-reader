<?php
declare(strict_types=1);

namespace Ueef\ArrayReader\Tests;

use PHPUnit\Framework\TestCase;
use Ueef\ArrayReader\Reader;
use Ueef\ArrayReader\Exceptions\UndefinedPathException;

class ReaderTest extends TestCase
{
    public function testSlice()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $slice = $reader->slice("e");
        $this->assertInstanceOf(Reader::class, $slice);

        $this->assertEquals($data["e"], $slice->getArray([]));

        $this->expectException(UndefinedPathException::class);
        $reader->slice("f");
    }

    public function testHas()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $this->assertTrue($reader->has("a"));
        $this->assertFalse($reader->has("f"));
    }

    public function testGet()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $this->assertEquals($data["a"], $reader->get(null, "a"));
        $this->assertEquals($data["b"], $reader->get(null, "b"));
        $this->assertEquals(null, $reader->get(null, "f"));
    }

    public function testGetReq()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $this->assertEquals($data["a"], $reader->getReq("a"));
        $this->assertEquals($data["b"], $reader->getReq("b"));

        $this->expectException(UndefinedPathException::class);
        $reader->getReq("f");
    }

    public function testGetInt()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $d = random_int(100, 1000);

        $v = $reader->getInt($d, "a");
        $this->assertIsInt($v);
        $this->assertEquals(1, $v);

        $v = $reader->getInt($d, "b");
        $this->assertIsInt($v);
        $this->assertEquals(0, $v);

        $v = $reader->getInt($d, "c");
        $this->assertIsInt($v);
        $this->assertEquals(1, $v);

        $v = $reader->getInt($d, "d");
        $this->assertIsInt($v);
        $this->assertEquals(0, $v);

        $v = $reader->getInt($d, "e");
        $this->assertIsInt($v);
        $this->assertEquals(0, $v);

        $v = $reader->getInt($d, "f");
        $this->assertIsInt($v);
        $this->assertEquals($d, $v);
    }

    public function testGetReqInt()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $v = $reader->getReqInt("a");
        $this->assertIsInt($v);
        $this->assertEquals(1, $v);

        $v = $reader->getReqInt("b");
        $this->assertIsInt($v);
        $this->assertEquals(0, $v);

        $v = $reader->getReqInt("c");
        $this->assertIsInt($v);
        $this->assertEquals(1, $v);

        $v = $reader->getReqInt("d");
        $this->assertIsInt($v);
        $this->assertEquals(0, $v);

        $v = $reader->getReqInt("e");
        $this->assertIsInt($v);
        $this->assertEquals(0, $v);

        $this->expectException(UndefinedPathException::class);
        $reader->getReqInt("f");
    }

    public function testGetStr()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $d = random_bytes(random_int(10, 100));

        $v = $reader->getString($d, "a");
        $this->assertIsString($v);
        $this->assertEquals("1", $v);

        $v = $reader->getString($d, "b");
        $this->assertIsString($v);
        $this->assertEquals("0.1", $v);

        $v = $reader->getString($d, "c");
        $this->assertIsString($v);
        $this->assertEquals("1", $v);

        $v = $reader->getString($d, "d");
        $this->assertIsString($v);
        $this->assertEquals("1", $v);

        $v = $reader->getString($d, "e");
        $this->assertIsString($v);
        $this->assertEquals("", $v);

        $v = $reader->getString($d, "f");
        $this->assertIsString($v);
        $this->assertEquals($d, $v);
    }

    public function testGetReqStr()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $v = $reader->getReqString("a");
        $this->assertIsString($v);
        $this->assertEquals("1", $v);

        $v = $reader->getReqString("b");
        $this->assertIsString($v);
        $this->assertEquals("0.1", $v);

        $v = $reader->getReqString("c");
        $this->assertIsString($v);
        $this->assertEquals("1", $v);

        $v = $reader->getReqString("d");
        $this->assertIsString($v);
        $this->assertEquals("1", $v);

        $v = $reader->getReqString("e");
        $this->assertIsString($v);
        $this->assertEquals("", $v);

        $this->expectException(UndefinedPathException::class);
        $reader->getReqInt("f");
    }

    public function testGetFloat()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $d = (float) random_int(10, 100);

        $v = $reader->getFloat($d, "a");
        $this->assertIsFloat($v);
        $this->assertEquals(1.0, $v);

        $v = $reader->getFloat($d, "b");
        $this->assertIsFloat($v);
        $this->assertEquals(0.1, $v);

        $v = $reader->getFloat($d, "c");
        $this->assertIsFloat($v);
        $this->assertEquals(1.0, $v);

        $v = $reader->getFloat($d, "d");
        $this->assertIsFloat($v);
        $this->assertEquals(0.0, $v);

        $v = $reader->getFloat($d, "e");
        $this->assertIsFloat($v);
        $this->assertEquals(0.0, $v);

        $v = $reader->getFloat($d, "f");
        $this->assertIsFloat($v);
        $this->assertEquals($d, $v);
    }

    public function testGetReqFloat()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $v = $reader->getReqFloat("a");
        $this->assertIsFloat($v);
        $this->assertEquals(1.0, $v);

        $v = $reader->getReqFloat("b");
        $this->assertIsFloat($v);
        $this->assertEquals(0.1, $v);

        $v = $reader->getReqFloat("c");
        $this->assertIsFloat($v);
        $this->assertEquals(1.0, $v);

        $v = $reader->getReqFloat("d");
        $this->assertIsFloat($v);
        $this->assertEquals(0.0, $v);

        $v = $reader->getReqFloat("e");
        $this->assertIsFloat($v);
        $this->assertEquals(0.0, $v);

        $this->expectException(UndefinedPathException::class);
        $reader->getReqFloat("f");
    }

    public function testGetBool()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $d = false;

        $v = $reader->getBool($d, "a");
        $this->assertIsBool($v);
        $this->assertEquals(true, $v);

        $v = $reader->getBool($d, "b");
        $this->assertIsBool($v);
        $this->assertEquals(true, $v);

        $v = $reader->getBool($d, "c");
        $this->assertIsBool($v);
        $this->assertEquals(true, $v);

        $v = $reader->getBool($d, "d");
        $this->assertIsBool($v);
        $this->assertEquals(true, $v);

        $v = $reader->getBool($d, "e");
        $this->assertIsBool($v);
        $this->assertEquals(true, $v);

        $v = $reader->getBool($d, "f");
        $this->assertIsBool($v);
        $this->assertEquals($d, $v);
    }

    public function testGetReqBool()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $v = $reader->getReqBool("a");
        $this->assertIsBool($v);
        $this->assertEquals(true, $v);

        $v = $reader->getReqBool("b");
        $this->assertIsBool($v);
        $this->assertEquals(true, $v);

        $v = $reader->getReqBool("c");
        $this->assertIsBool($v);
        $this->assertEquals(true, $v);

        $v = $reader->getReqBool("d");
        $this->assertIsBool($v);
        $this->assertEquals(true, $v);

        $v = $reader->getReqBool("e");
        $this->assertIsBool($v);
        $this->assertEquals(true, $v);

        $this->expectException(UndefinedPathException::class);
        $reader->getReqBool("f");
    }

    public function testGetArray()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $d = [1];

        $v = $reader->getArray($d, "a");
        $this->assertIsArray($v);
        $this->assertEquals([], $v);

        $v = $reader->getArray($d, "b");
        $this->assertIsArray($v);
        $this->assertEquals([], $v);

        $v = $reader->getArray($d, "c");
        $this->assertIsArray($v);
        $this->assertEquals([], $v);

        $v = $reader->getArray($d, "d");
        $this->assertIsArray($v);
        $this->assertEquals([], $v);

        $v = $reader->getArray($d, "e");
        $this->assertIsArray($v);
        $this->assertEquals($data["e"], $v);

        $v = $reader->getArray($d, "f");
        $this->assertIsArray($v);
        $this->assertEquals($d, $v);
    }

    public function testGetReqArray()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $v = $reader->getReqArray("a");
        $this->assertIsArray($v);
        $this->assertEquals([], $v);

        $v = $reader->getReqArray("b");
        $this->assertIsArray($v);
        $this->assertEquals([], $v);

        $v = $reader->getReqArray("c");
        $this->assertIsArray($v);
        $this->assertEquals([], $v);

        $v = $reader->getReqArray("d");
        $this->assertIsArray($v);
        $this->assertEquals([], $v);

        $v = $reader->getReqArray("e");
        $this->assertIsArray($v);
        $this->assertEquals($data["e"], $v);

        $this->expectException(UndefinedPathException::class);
        $reader->getReqArray("f");
    }

    public function testGetIntArray()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $d = [1, 1.0, "1", true, []];

        $v = $reader->getIntArray($d, "a");
        $this->assertEquals([], $v);

        $v = $reader->getIntArray($d, "b");
        $this->assertEquals([], $v);

        $v = $reader->getIntArray($d, "c");
        $this->assertEquals([], $v);

        $v = $reader->getIntArray($d, "d");
        $this->assertEquals([], $v);

        $v = $reader->getIntArray($d, "e");
        $this->assertEquals(["a" => 0, "b" => 0, "c" => 0, "d" => 0, "e" => 0], $v);

        $v = $reader->getIntArray($d, "f");
        $this->assertIsArray($v);
        $this->assertEquals([1,1,1,0,0], $v);
    }

    public function testGetReqIntArray()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $v = $reader->getReqIntArray("a");
        $this->assertEquals([], $v);

        $v = $reader->getReqIntArray("b");
        $this->assertEquals([], $v);

        $v = $reader->getReqIntArray("c");
        $this->assertEquals([], $v);

        $v = $reader->getReqIntArray("d");
        $this->assertEquals([], $v);

        $v = $reader->getReqIntArray("e");
        $this->assertEquals(["a" => 0, "b" => 0, "c" => 0, "d" => 0, "e" => 0], $v);

        $this->expectException(UndefinedPathException::class);
        $reader->getReqArray("f");
    }

    public function testGetFloatArray()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $d = [1, 1.0, "1", true, []];

        $v = $reader->getFloatArray($d, "a");
        $this->assertEquals([], $v);

        $v = $reader->getFloatArray($d, "b");
        $this->assertEquals([], $v);

        $v = $reader->getFloatArray($d, "c");
        $this->assertEquals([], $v);

        $v = $reader->getFloatArray($d, "d");
        $this->assertEquals([], $v);

        $v = $reader->getFloatArray($d, "e");
        $this->assertEquals(["a" => 0.0, "b" => 0.0, "c" => 0.0, "d" => 0.0, "e" => 0.0], $v);

        $v = $reader->getFloatArray($d, "f");
        $this->assertIsArray($v);
        $this->assertEquals([1.0, 1.0, 1.0, 0.0, 0.0], $v);
    }

    public function testGetReqFloatArray()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $v = $reader->getReqFloatArray("a");
        $this->assertEquals([], $v);

        $v = $reader->getReqFloatArray("b");
        $this->assertEquals([], $v);

        $v = $reader->getReqFloatArray("c");
        $this->assertEquals([], $v);

        $v = $reader->getReqFloatArray("d");
        $this->assertEquals([], $v);

        $v = $reader->getReqFloatArray("e");
        $this->assertEquals(["a" => 0.0, "b" => 0.0, "c" => 0.0, "d" => 0.0, "e" => 0.0], $v);

        $this->expectException(UndefinedPathException::class);
        $reader->getReqFloatArray("f");
    }

    public function testGetStringArray()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $d = [1, 1.0, "1", true, []];

        $v = $reader->getStringArray($d, "a");
        $this->assertEquals([], $v);

        $v = $reader->getStringArray($d, "b");
        $this->assertEquals([], $v);

        $v = $reader->getStringArray($d, "c");
        $this->assertEquals([], $v);

        $v = $reader->getStringArray($d, "d");
        $this->assertEquals([], $v);

        $v = $reader->getStringArray($d, "e");
        $this->assertEquals(["a" => "", "b" => "", "c" => "", "d" => "", "e" => ""], $v);

        $v = $reader->getStringArray($d, "f");
        $this->assertIsArray($v);
        $this->assertEquals(["1", "1", "1", "1", ""], $v);
    }

    public function testGetReqStringArray()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $v = $reader->getReqStringArray("a");
        $this->assertEquals([], $v);

        $v = $reader->getReqStringArray("b");
        $this->assertEquals([], $v);

        $v = $reader->getReqStringArray("c");
        $this->assertEquals([], $v);

        $v = $reader->getReqStringArray("d");
        $this->assertEquals([], $v);

        $v = $reader->getReqStringArray("e");
        $this->assertEquals(["a" => "", "b" => "", "c" => "", "d" => "", "e" => ""], $v);

        $this->expectException(UndefinedPathException::class);
        $reader->getReqStringArray("f");
    }

    public function testGetBoolArray()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $v = $reader->getReqBoolArray("a");
        $this->assertEquals([], $v);

        $v = $reader->getReqBoolArray("b");
        $this->assertEquals([], $v);

        $v = $reader->getReqBoolArray("c");
        $this->assertEquals([], $v);

        $v = $reader->getReqBoolArray("d");
        $this->assertEquals([], $v);

        $v = $reader->getReqBoolArray("e");
        $this->assertEquals(["a" => true, "b" => true, "c" => true, "d" => true, "e" => false], $v);

        $this->expectException(UndefinedPathException::class);
        $reader->getReqBoolArray("f");
    }

    public function testGetReqBoolArray()
    {
        $data = $this->makeReaderData();
        $reader = $this->makeReader($data);

        $d = [1, 1.0, "1", true, []];

        $v = $reader->getBoolArray($d, "a");
        $this->assertEquals([], $v);

        $v = $reader->getBoolArray($d, "b");
        $this->assertEquals([], $v);

        $v = $reader->getBoolArray($d, "c");
        $this->assertEquals([], $v);

        $v = $reader->getBoolArray($d, "d");
        $this->assertEquals([], $v);

        $v = $reader->getBoolArray($d, "e");
        $this->assertEquals(["a" => true, "b" => true, "c" => true, "d" => true, "e" => false], $v);

        $v = $reader->getBoolArray($d, "f");
        $this->assertIsArray($v);
        $this->assertEquals([true, true, true, true, false], $v);
    }

    private function makeReader(array $data): Reader
    {
        return new Reader($data);
    }

    private function makeReaderData(): array
    {
        return [
            "a" => 1,
            "b" => 0.1,
            "c" => "1",
            "d" => true,
            "e" => [
                "a" => [1, 2, 3],
                "b" => [.1,.2,.3],
                "c" => ["1", "2", "3"],
                "d" => [true, true, false],
                "e" => [],
            ],
        ];
    }
}