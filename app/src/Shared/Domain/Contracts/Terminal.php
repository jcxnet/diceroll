<?php

namespace Shared\Domain\Contracts;

interface Terminal
{
    public function clear(): void;

    public function title(string $message): void;

    public function subtitle(string $message): void;

    public function inputIntegerRange(string $message, int $min, int $max): int;

    public function output(string $message): void;

    public function choice(string $message, array $options): string;

    public function info(array $data): void;

    public function goodBye(string $message): void;

    public function exception(Exception $exception): void;
}