<?php

function echo_memory_usage() {

    $mem_usage = memory_get_usage(true);
    if ($mem_usage < 1024) {
        echo $mem_usage." bytes";
    } elseif ($mem_usage < 1048576) {
        echo round($mem_usage/1024,2)." kilobytes";
    } else {
        echo round($mem_usage/1048576,2)." megabytes";
    }
}

echo_memory_usage();
echo PHP_EOL;