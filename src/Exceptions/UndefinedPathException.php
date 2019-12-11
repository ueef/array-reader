<?php
declare(strict_types=1);

namespace Ueef\ArrayReader\Exceptions;

use Exception;
use Throwable;
use Ueef\ArrayReader\Interfaces\ErrorInterface;

class UndefinedPathException extends Exception implements ErrorInterface
{
    /** @var array */
    private $path;

    public function __construct(array $path, Throwable $previous = null)
    {
        parent::__construct(sprintf("The path \"%s\" is undefined", implode($path)), 0, $previous);
    }
}