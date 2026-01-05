<?php
declare(strict_types=1);

namespace App\Helpers;

final class Str
{
    /** @return array{0:string,1:string} */
    public static function explodeOnce(string $value, string $delimiter): array
    {
        $pos = strpos($value, $delimiter);
        if ($pos === false) {
            return [$value, ''];
        }
        return [substr($value, 0, $pos), substr($value, $pos + strlen($delimiter))];
    }
}

