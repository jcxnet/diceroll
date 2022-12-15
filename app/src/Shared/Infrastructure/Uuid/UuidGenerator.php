<?php

namespace App\Shared\Infrastructure\Uuid;

use App\Shared\Domain\Contracts\UuidGenerator as UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;

final class UuidGenerator implements UuidGeneratorInterface
{

    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}