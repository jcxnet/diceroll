<?php

namespace Shared\Domain\Contracts;

interface Exception
{
    public function title(): string;

    public function message(): string;
}