<?php

namespace Game\Domain\Model\Game;

final class GameMode
{
    public const MODE_COMPLETE_ROUNDS = 'COMPLETE';
    public const MODE_ALTERNATE_ROUNDS = 'ALTERNATE';

    private Mode $mode;
    private ModeDetail $detail;

    public function __construct(Mode $mode, ModeDetail $detail)
    {
        $this->mode = $mode;
        $this->detail = $detail;
    }

    public function mode(): string
    {
        return $this->mode->value();
    }

    public function detail(): string
    {
        return $this->detail->value();
    }


}