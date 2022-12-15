<?php

namespace App\Game\Application\Game\Intro;

use App\Shared\Domain\Contracts\Terminal;

final class GameIntro
{
    private Terminal $terminal;

    public function __construct(Terminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function __invoke(): void
    {
        $this->terminal->clear();
        $this->terminal->title("Dice Roll Game");
    }

}