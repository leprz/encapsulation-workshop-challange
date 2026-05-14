<?php

declare(strict_types=1);

namespace App\Printing;

class SectionPrinter
{
    public function __construct(private readonly Printer $output)
    {
    }

    public function print(string $title): void
    {
        $indent = str_repeat(' ', ConsoleLayout::INDENT);
        $divider = str_repeat(ConsoleLayout::SECTION_DIVIDER, ConsoleLayout::TOTAL_WIDTH - ConsoleLayout::INDENT);

        $this->output->writeLine('');
        $this->output->writeLine($indent . $divider);
        $this->output->writeLine($indent . $title);
        $this->output->writeLine($indent . $divider);
    }
}
