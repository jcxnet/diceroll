<?php

namespace Game\Application\Dice\Exceptions;

use Shared\Domain\Exceptions\Exception;

final class DiceNotExists extends Exception
{
    public function __construct()
    {
        parent::__construct('Dice not found', "I can't create the selected dice");
    }

}