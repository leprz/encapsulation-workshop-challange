<?php

declare(strict_types=1);

namespace App\Printing;

final class AnsiColor
{
    public const string GREEN = "\033[32m";
    public const string RED = "\033[31m";
    public const string BOLD_RED = "\033[1;31m";
    public const string RESET = "\033[0m";
}
