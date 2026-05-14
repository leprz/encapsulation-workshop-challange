<?php

declare(strict_types=1);

namespace App\Printing;

final class AnsiColor
{
    public const GREEN = "\033[32m";
    public const RED = "\033[31m";
    public const BOLD_RED = "\033[1;31m";
    public const RESET = "\033[0m";
}
