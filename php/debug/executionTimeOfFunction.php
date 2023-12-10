<?php

function executionTimeOfFunction (): string
{
    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    $time = $time / 60;

    return "The script executed in $time minutes.";
}
