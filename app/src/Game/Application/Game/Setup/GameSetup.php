<?php

namespace Game\Application\Game\Setup;

use Game\Application\Dice\Select\SelectDice;
use Game\Application\Game\Mode\GameMode;
use Game\Application\Game\Players\SelectPlayers;
use Game\Application\Game\Rounds\SelectRounds;
use Game\Domain\Model\Dice\Dice;
use Game\Domain\Model\Game\GameMode as GameModeModel;
use Game\Domain\Model\Game\GameSetup as GameSetupModel;
use Game\Domain\Model\Game\Players;
use Game\Domain\Model\Game\Rounds;
use Game\Infrastructure\GameTerminal;

final class GameSetup
{

    private const OPTION_OK = 'OK';
    private const OPTION_RESET = 'RESET';
    private const OPTION_EXIT = 'EXIT';
    private const SETUP_OPTIONS = [
        self::OPTION_OK => 'Continue',
        self::OPTION_RESET => 'Change the options',
        self::OPTION_EXIT => 'Exit game',
    ];

    private GameTerminal $terminal;

    private GameSetupModel $gameSetup;

    public function __construct(
        GameTerminal $terminal
    )
    {
        $this->terminal = $terminal;
    }

    public function __invoke(): GameSetupModel
    {
        $option = self::OPTION_OK;
        do {
            if ($option === self::OPTION_RESET) {
                $this->terminal->clear();
            }
            $this->terminal->subtitle("Game Setup");
            $this->gameSetup = new GameSetupModel(
                $this->selectDice(),
                $this->selectMode(),
                $this->selectRounds(),
                $this->selectPlayers()
            );
            $this->info();
            $option = $this->terminal->choice('<background_green><white>All options are OK?</white></background_green>', self::SETUP_OPTIONS);
        } while ($option === self::OPTION_RESET);

        if ($option === self::OPTION_OK) {
            return $this->gameSetup;
        }

        $this->terminal->goodBye('Thanks for play');
    }

    private function selectDice(): Dice
    {
        $selectDice = new SelectDice($this->terminal);

        return $selectDice();
    }

    private function selectMode(): GameModeModel
    {
        $selectMode = new GameMode($this->terminal);

        return $selectMode();
    }

    private function selectRounds(): Rounds
    {
        $selectRounds = new SelectRounds($this->terminal);

        return $selectRounds();
    }

    private function selectPlayers(): Players
    {
        $selectPlayers = new SelectPlayers($this->terminal);

        return $selectPlayers();
    }

    public function info(): void
    {
        $data = $this->gameSetup->info();
        $this->terminal->subtitle('Options selected');
        $this->terminal->info($data);
    }

}