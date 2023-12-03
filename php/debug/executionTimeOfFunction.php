<?php

function executionTimeOfFunction (): string
{
    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    $time = $time / 60;

    return "O script executou em $time minutos.";
}
