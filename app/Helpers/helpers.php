<?php

declare(strict_types=1);

if (!function_exists('settings')) {
    function settings($key = null)
    {
        $settings = cache()->rememberForever('settings', static function () {
            return \App\Models\Settings::pluck('value', 'key');
        });

        if ($key !== null) {
            return $settings->get($key);
        }

        return $settings;
    }
}

if (!function_exists('format_currency')) {
    function format_currency($value, $format = true)
    {
        if (!$format) {
            return $value;
        }

        $currency = \App\Models\Currency::find(1); // Assuming you want to retrieve the currency from the database based on a specific condition

        $position = $currency->position;
        $symbol = $currency->symbol;
        $decimalSeparator = $currency->decimal_separator;
        $thousandSeparator = $currency->thousand_separator;

        return $position === 'prefix'
            ? $symbol . number_format((float) $value, 2, $decimalSeparator, $thousandSeparator)
            : number_format((float) $value, 2, $decimalSeparator, $thousandSeparator) . $symbol;
    }
}

if (!function_exists('format_date')) {
    function format_date($value)
    {
        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d');
        }

        // Check if value is non-empty and is a string
        if (empty($value) || !is_string($value)) {
            return null;
        }

        // Ensure that the value is at least 10 characters long to avoid warnings with substr
        if (strlen($value) < 10) {
            return null;
        }

        $dateString = substr($value, 0, 10);

        try {
            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $dateString);
        } catch (Exception) {
            return null; // Return null if date creation fails
        }

        return $date->format('Y-m-d');
    }
}

if (!function_exists('make_reference_id')) {
    function make_reference_id(string $prefix, $number): string
    {
        return $prefix . '-' . str_pad((string) $number, 5, '0', STR_PAD_LEFT);
    }
}
