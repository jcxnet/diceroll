<?php

namespace App\Shared\Domain\Contracts;

interface Terminal
{
    public function clear(): void;
    public function title(string $message): void;
    public function subtitle(string $message): void;
    public function output(string $message): void;
}