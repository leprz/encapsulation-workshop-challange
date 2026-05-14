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
}
