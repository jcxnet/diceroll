<?php

namespace App\Game\Application\Game\Start;

use App\Shared\Domain\Contracts\Terminal;

final class GameStart
{
    private Terminal $terminal;

    public function __construct(Terminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function __invoke(): void
    {
        $this->terminal->subtitle("Game Start");
    }

}