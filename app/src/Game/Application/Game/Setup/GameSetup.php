<?php

namespace App\Game\Application\Game\Setup;

use App\Shared\Domain\Contracts\Terminal;

final class GameSetup
{
    private Terminal $terminal;

    public function __construct(Terminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function __invoke(): void
    {
        $this->terminal->subtitle("Game Setup");
    }

}