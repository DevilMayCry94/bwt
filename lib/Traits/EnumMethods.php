<?php

namespace BWT\Traits;

trait EnumMethods
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
