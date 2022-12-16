<?php

namespace Shared\Infrastructure\Terminal;

use Shared\Domain\Contracts\Exception;
use Shared\Domain\Contracts\Terminal as TerminalInterface;
use League\CLImate\CLImate;

abstract class Terminal implements TerminalInterface
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

    public function subtitle(string $message): void
    {
        $this->console->green()->flank($message, '--');
        $this->console->br();
    }

    public function clear(): void
    {
        $this->console->clear();
    }

    public function choice(string $message, array $options): string
    {
        return $this->console->radio($message, $options)->prompt();
    }

    public function inputIntegerRange(string $message, int $min, int $max): int
    {
        $input = $this->console->input($message);

        $input->accept(function ($response) use ($min, $max) {
            return ($response >= $min && $response <= $max);
        });

        return (int)$input->prompt();
    }

    public function info(array $data): void
    {
        $this->console->info()->table($data);
    }

    public function goodBye(string $message): void
    {
        $this->console->br()->blue()->border('-*-*');
        $this->console->backgroundYellow()->black()->flank($message);
        $this->console->br()->blue()->border('-*-*');

        exit(1);
    }

    public function exception(Exception $exception): void
    {
        $data = [
            ["<background_red><white>{$exception->title()}</white></background_red>" => $exception->message()],
        ];
        $this->console->br()->red()->table($data);

        exit(1);
    }

    public function title(string $message): void
    {
        $this->console->br()->backgroundBlue()->white()->flank($message);
        $this->console->br();
    }
}