<?php

namespace Game\Application\Game\Exceptions;

use Shared\Domain\Exceptions\Exception;

final class GameModeNotExists extends Exception
{
    public function __construct()
    {
        parent::__construct('Game mode not found', "I can't create the selected game mode");
    }

}