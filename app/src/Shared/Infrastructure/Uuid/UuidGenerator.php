<?php

namespace Shared\Infrastructure\Uuid;

use Shared\Domain\Contracts\UuidGenerator as UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;

abstract class UuidGenerator implements UuidGeneratorInterface
{

    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}