<?php

namespace App\Shared\Domain\Contracts;

interface UuidGenerator
{
    public function generate(): string;
}