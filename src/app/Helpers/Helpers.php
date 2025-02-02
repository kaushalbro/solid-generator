<?php

use Carbon\Carbon;

function path($name): string
{
     if ($name == 'contoller'){
        return 'app/Http/Controllers';
     }
    if ($name == 'model'){
        return 'app/Models';
    }
    if ($name == 'request'){
        return 'app/Http/Requests';
    }
    if ($name == 'repo'){
        return 'app/Repositories';
    }
    return base_path();
}

function dateTimeFormated(?string $value, ?string $format = null): ?string
{
    $format ??= config('solid.datetime_format');

    return $value ? Carbon::parse($value)->format($format) : null;
}
