<?php

declare(strict_types=1);

namespace WPUtils;

class Logger
{
    public static function info(string $message, array $context = []): void
    {
        // if Simple History is installed, log the message there
        if (function_exists('SimpleLogger')) {
            SimpleLogger()->info($message, $context);
        } else {
            // fallback to error_log
            error_log("[INFO] " . $message . ' ' . json_encode($context));
        }
    }

    public static function error(string $message, array $context = []): void
    {
        // if Simple History is installed, log the message there
        if (function_exists('SimpleLogger')) {
            SimpleLogger()->error($message, $context);
        } else {
            // fallback to error_log
            error_log("[ERROR] " . $message . ' ' . json_encode($context));
        }
    }
}
