<?php

declare(strict_types=1);

namespace App\Printing;

interface Printer
{
    public function write(string $text): void;

    public function writeLine(string $line): void;
}
