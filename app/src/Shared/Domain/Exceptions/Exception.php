<?php

namespace Shared\Domain\Exceptions;

use Shared\Domain\Contracts\Exception as ExceptionContract;

class Exception implements ExceptionContract
{
    private string $title;
    private string $message;

    public function __construct(string $title, string $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function message(): string
    {
        return $this->message;
    }

}