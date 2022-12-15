<?php

namespace App\Shared\Infrastructure\Terminal;

use App\Shared\Domain\Contracts\Terminal as TerminalInterface;
use League\CLImate\CLImate;

final class Terminal implements TerminalInterface
{
    private CLImate $console;
    public function __construct()
    {
        $this->console = new CLImate();
    }

    public function output(string $message): void
    {
        $this->console->out($message);
    }

    public function title(string $message): void
    {
        $this->console->br()->backgroundBlue()->white()->flank($message);
        $this->console->br();
    }

    public function subtitle(string $message): void
    {
        $this->console->green()->flank($message, '--');
        $this->console->br();
    }

    public function clear(): void
    {
        $this->console->clear();
    }
}