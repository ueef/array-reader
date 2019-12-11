<?php
declare(strict_types=1);

namespace Ueef\ArrayReader;

use Ueef\ArrayReader\Exceptions\UndefinedPathException;
use Ueef\ArrayReader\Interfaces\ReaderInterface;

class Reader implements ReaderInterface
{
    private $data = [];


    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function has(string ...$path): bool
    {
        return null !== $this->find($path);
    }

    public function slice(string ...$path): ReaderInterface
    {
        return new static($this->getReqArray(...$path));
    }

    public function get($default, string ...$path)
    {
        $v = $this->find($path);
        if (null === $v) {
            return $default;
        }

        return $v;
    }

    public function getReq(string ...$path)
    {
        $v = $this->find($path);
        if (null === $v) {
            throw new UndefinedPathException($path);
        }

        return $v;
    }

    public function getInt(int $default, string ...$path): int
    {
        return $this->parseInt($this->get($default, ...$path));
    }

    public function getReqInt(string ...$path): int
    {
        return $this->parseInt($this->getReq(...$path));
    }

    public function getFloat(float $default, string ...$path): float
    {
        return $this->parseFloat($this->get($default, ...$path));
    }

    public function getReqFloat(string ...$path): float
    {
        return $this->parseFloat($this->getReq(...$path));
    }

    public function getString(string $default, string ...$path): string
    {
        return $this->parseString($this->get($default, ...$path));
    }

    public function getReqString(string ...$path): string
    {
        return $this->parseString($this->getReq(...$path));
    }

    public function getBool(bool $default, string ...$path): bool
    {
        return $this->parseBool($this->get($default, ...$path));
    }

    public function getReqBool(string ...$path): bool
    {
        return $this->parseBool($this->getReq(...$path));
    }

    public function getArray(array $default, string ...$path): array
    {
        return $this->parseArray($this->get($default, ...$path));
    }

    public function getReqArray(string ...$path): array
    {
        return $this->parseArray($this->getReq(...$path));
    }

    public function getIntArray(array $default, string ...$path): array
    {
        return $this->parseIntArray($this->getArray($default, ...$path));
    }

    public function getReqIntArray(string ...$path): array
    {
        return $this->parseIntArray($this->getReqArray(...$path));
    }

    public function getFloatArray(array $default, string ...$path): array
    {
        return $this->parseFloatArray($this->getArray($default, ...$path));
    }

    public function getReqFloatArray(string ...$path): array
    {
        return $this->parseFloatArray($this->getReqArray(...$path));
    }

    public function getStringArray(array $default, string ...$path): array
    {
        return $this->parseStringArray($this->getArray($default, ...$path));
    }

    public function getReqStringArray(string ...$path): array
    {
        return $this->parseStringArray($this->getReqArray(...$path));
    }

    public function getBoolArray(array $default, string ...$path): array
    {
        return $this->parseBoolArray($this->getArray($default, ...$path));
    }

    public function getReqBoolArray(string ...$path): array
    {
        return $this->parseBoolArray($this->getReqArray(...$path));
    }

    private function find(array $path)
    {
        $v = &$this->data;
        foreach ($path as $k) {
            if (isset($v[$k])) {
                $v = &$v[$k];
            } else {
                return null;
            }
        }

        return $v;
    }

    private function parseInt($v): int
    {
        if (is_int($v)) {
            return $v;
        } elseif (is_numeric($v)) {
            return (int) $v;
        }

        return 0;
    }

    private function parseFloat($v): float
    {
        if (is_float($v)) {
            return $v;
        } elseif (is_numeric($v)) {
            return (float) $v;
        }

        return 0.0;
    }

    private function parseString($v): string
    {
        if (is_string($v)) {
            return $v;
        }

        if (is_scalar($v)) {
            return (string) $v;
        }

        return "";
    }

    private function parseBool($v): bool
    {
        return (bool) $v;
    }

    private function parseArray($v): array
    {
        if (is_array($v)) {
            return $v;
        }

        return [];
    }

    private function parseIntArray(array $e): array
    {
        foreach ($e as &$v) {
            $v = $this->parseInt($v);
        }

        return $e;
    }

    private function parseFloatArray(array $e): array
    {
        foreach ($e as &$v) {
            $v = $this->parseFloat($v);
        }

        return $e;
    }

    private function parseStringArray(array $e): array
    {
        foreach ($e as &$v) {
            $v = $this->parseString($v);
        }

        return $e;
    }

    private function parseBoolArray(array $e): array
    {
        foreach ($e as &$v) {
            $v = $this->parseBool($v);
        }

        return $e;
    }
}