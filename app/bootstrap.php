<?php

use Game\Application\Game\Intro\GameIntro;
use Game\Application\Game\Setup\GameSetup;
use Game\Application\Game\Start\GameStart;
use Game\Application\Player\Create\CreatePlayer;

use Game\Infrastructure\GameTerminal;
use Game\Infrastructure\UuidGenerator;

set_time_limit(0);

require __DIR__.'/vendor/autoload.php';

$terminal = new GameTerminal();
$uuidGenerator = new UuidGenerator();

$builder = new DI\ContainerBuilder();
$builder->addDefinitions([
    GameIntro::class => new GameIntro($terminal),
    GameSetup::class => new GameSetup($terminal),
    GameStart::class => new GameStart($terminal),
    CreatePlayer::class => new CreatePlayer($uuidGenerator, $terminal),
]);
$container = $builder->build();