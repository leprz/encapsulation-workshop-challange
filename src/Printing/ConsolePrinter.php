<?php

declare(strict_types=1);

namespace App\Printing;

class ConsolePrinter implements Printer
{
    public function write(string $text): void
    {
        echo $text;
    }

    public function writeLine(string $line): void
    {
        echo $line . "\n";
    }

    public function writeError(string $message): void
    {
        fwrite(STDERR, "\n" . AnsiColor::BOLD_RED . "  ✖ Error:" . AnsiColor::RED . " {$message}" . AnsiColor::RESET . "\n\n");
    }
}
