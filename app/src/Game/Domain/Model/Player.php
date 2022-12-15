<?php

namespace App\Game\Domain\Model;

final class Player
{
    private PlayerName $name;

    public function __construct(PlayerName $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name->value();
    }


}