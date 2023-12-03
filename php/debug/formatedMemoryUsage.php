<?php

function formatedMemoryUsage(): string 
{
    $mem_usage = memory_get_usage(true);

    if ($mem_usage < 1024) {
        return $mem_usage . " bytes";
    } elseif ($mem_usage < 1048576) {
        return round($mem_usage/1024,2) . " kilobytes";
    } else {
        return round($mem_usage/1048576,2) . " megabytes";
    }
}