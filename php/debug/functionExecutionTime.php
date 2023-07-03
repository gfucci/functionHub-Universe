<?php

$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
$time = $time / 60;
echo "O script executou em $time minutos.";