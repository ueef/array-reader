<?php
declare(strict_types=1);

namespace Ueef\ArrayReader\Interfaces;


interface ReaderInterface
{
    public function slice(string ...$path): ReaderInterface;

    public function has(string ...$path): bool;

    public function get($default, string ...$path);
    public function getReq(string ...$path);

    public function getInt(int $default, string ...$path): int;
    public function getReqInt(string ...$path): int;

    public function getFloat(float $default, string ...$path): float;
    public function getReqFloat(string ...$path): float;

    public function getString(string $default, string ...$path): string;
    public function getReqString(string ...$path): string;

    public function getBool(bool $default, string ...$path): bool;
    public function getReqBool(string ...$path): bool;

    public function getArray(array $default, string ...$path): array;
    public function getReqArray(string ...$path): array;

    public function getIntArray(array $default, string ...$path): array;
    public function getReqIntArray(string ...$path): array;

    public function getFloatArray(array $default, string ...$path): array;
    public function getReqFloatArray(string ...$path): array;

    public function getStringArray(array $default, string ...$path): array;
    public function getReqStringArray(string ...$path): array;

    public function getBoolArray(array $default, string ...$path): array;
    public function getReqBoolArray(string ...$path): array;
}