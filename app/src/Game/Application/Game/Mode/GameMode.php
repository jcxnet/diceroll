<?php

namespace Game\Application\Game\Mode;

use Game\Application\Game\Exceptions\GameModeNotExists;
use Game\Domain\Model\Game\GameMode as GameModeModel;
use Game\Domain\Model\Game\Mode;
use Game\Domain\Model\Game\ModeDetail;
use Game\Infrastructure\GameTerminal;

final class GameMode
{

    private const MODES = [
        GameModeModel::MODE_COMPLETE_ROUNDS => 'Each player rolls the dice until he finishes all his rounds',
        GameModeModel::MODE_ALTERNATE_ROUNDS => 'Each player rolls the dice per round',
    ];

    private GameTerminal $terminal;

    public function __construct(GameTerminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function __invoke(): GameModeModel
    {
        $options = self::MODES;
        $selected = $this->terminal->choice('<yellow>Select the mode to play:</yellow>', $options);

        return $this->createMode($selected);
    }

    private function createMode(int|string $modeSelected): GameModeModel
    {
        if (!array_key_exists($modeSelected, self::MODES)) {
            $this->terminal->exception(new GameModeNotExists());
        }

        return $this->newGameModeModel($modeSelected,self::MODES[$modeSelected]);
    }

    private function newGameModeModel(int|string $mode, string $description): GameModeModel
    {
        $mode = new Mode($mode);
        $detail = new ModeDetail($description);

        return new GameModeModel($mode, $detail);
    }


}