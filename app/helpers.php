<?php

if (! function_exists('eur')) {
    function eur($value): string
    {
        return number_format($value, 2, ',', ' ').' €';
    }
}

if (! function_exists('random_color')) {
    function random_color(): string
    {
        $color = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark', 'bank'];

        return $color[random_int(0, 7)];
    }
}

if (! function_exists('random_string_alpha_upper')) {
    function random_string_alpha_upper($len = 10): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $var_size = strlen($chars);
        $random_str = '';
        for ($x = 0; $x < $len; $x++) {
            $random_str .= $chars[random_int(0, $var_size - 1)];
        }

        return $random_str;
    }
}

if (! function_exists('generatePassword')) {
    function generatePassword($len = 10): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&-_';
        $var_size = strlen($chars);
        $random_str = '';
        for ($x = 0; $x < $len; $x++) {
            $random_str .= $chars[random_int(0, $var_size - 1)];
        }

        return $random_str;
    }
}

if (! function_exists('random_numeric')) {
    function random_numeric($len = 10): string
    {
        $chars = '0123456789';
        $var_size = strlen($chars);
        $random_str = '';
        for ($x = 0; $x < $len; $x++) {
            $random_str .= $chars[random_int(0, $var_size - 1)];
        }

        return $random_str;
    }
}

if (! function_exists('sizeFormat')) {
    function sizeFormat($bytes)
    {
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        $tb = $gb * 1024;

        if (($bytes >= 0) && ($bytes < $kb)) {
            return $bytes.' B';

        } elseif (($bytes >= $kb) && ($bytes < $mb)) {
            return ceil($bytes / $kb).' KB';

        } elseif (($bytes >= $mb) && ($bytes < $gb)) {
            return ceil($bytes / $mb).' MB';

        } elseif (($bytes >= $gb) && ($bytes < $tb)) {
            return ceil($bytes / $gb).' GB';

        } elseif ($bytes >= $tb) {
            return ceil($bytes / $tb).' TB';
        } else {
            return $bytes.' B';
        }
    }
}

if (! function_exists('formatDateFrench')) {
    function formatDateFrench($date, $hours = false): string
    {
        $dayName = $date->locale('fr_FR')->dayName;
        $day = $date->day;
        $monthName = $date->locale('fr_FR')->monthName;

        if ($hours) {
            return $dayName.' '.$day.' '.$monthName.' '.$date->year.' '.$date->format('H:i');
        } else {
            return $dayName.' '.$day.' '.$monthName.' '.$date->year;
        }
    }
}

if (! function_exists('generateReference')) {
    function generateReference($length = 8)
    {
        return Str::upper(Str::random($length));
    }
}

/**
 * check directory exists and try to create it
 */
if (! function_exists('ckeckDirectory')) {
    function checkDirectory($directory): void
    {
        try {
            if (! file_exists(public_path('uploads/'.$directory))) {
                Storage::disk('public')->makeDirectory('uploads/'.$directory);
                Storage::disk('public')->setVisibility('uploads/'.$directory, 'public');
            }
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }
}

if (! function_exists('isoToEmoji')) {
    function isoToEmoji(string $code)
    {
        return implode(
            '',
            array_map(
                fn ($letter) => mb_chr(ord($letter) % 32 + 0x1F1E5),
                str_split($code)
            )
        );
    }
}

if (! function_exists('redirectAsError')) {
    function redirectAsError(): Illuminate\Http\RedirectResponse
    {
        return redirect()->back()->with('error', "Une erreur à eu lieu lors de l'execution! Contacter un administrateur (Code 500)");
    }
}

if (! function_exists('random_float')) {
    function random_float($st_num = 0, $end_num = 1, $mul = 1000000): float|bool|int
    {
        if ($st_num > $end_num) {
            return false;
        }

        return mt_rand($st_num * $mul, $end_num * $mul) / $mul;
    }
}

if (! function_exists('generateRandomFloat')) {
    function generateRandomFloat(float|int $minValue, float|int $maxValue): float|int
    {
        return $minValue + random_int(0, 99) / mt_getrandmax() * ($maxValue - $minValue);
    }
}

if (! function_exists('formatTextForSlugify')) {
    function formatTextForSlugify(string $string): string
    {
        $firstLetter = Str::substr($string, 0, 1);
        if ($firstLetter == 'a' || $firstLetter == 'e' || $firstLetter == 'i' || $firstLetter == 'o' || $firstLetter == 'u' || $firstLetter == 'y' || $firstLetter == 'A' || $firstLetter == 'E' || $firstLetter == 'I' || $firstLetter == 'O' || $firstLetter == 'U' || $firstLetter == 'Y') {
            return 'd\''.$string;
        } else {
            return 'de '.$string;
        }
    }
}

if (! function_exists('convertMinuteToHours')) {
    function convertMinuteToHours(string $minutes): string
    {
        $hours = floor($minutes / 60);
        $min = $minutes - ($hours * 60);

        return \Carbon\Carbon::createFromTimeString($hours.':'.$min.':00')->format('H:i');

    }
}

if (! function_exists('convertHoursToMinutes')) {
    function convertHoursToMinutes(string $hours): string
    {
        return floor($hours * 60);
    }
}

if (! function_exists('storageToUrl')) {
    function storageToUrl(string $uri): string
    {
        return '//s3.'.config('app.domain').'/'.$uri;
    }
}
