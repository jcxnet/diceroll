<?php

namespace Shared\Domain\Contracts;

interface UuidGenerator
{
    public function generate(): string;
}