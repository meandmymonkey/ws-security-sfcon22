<?php

declare(strict_types=1);

namespace App\Security;

use RandomLib\Generator;

final class BackupCodeGenerator
{
    private Generator $generator;
    private int $batchSize;
    private int $codeLength;
    private string $chars;

    public function __construct(Generator $generator, int $batchSize = 8, int $codeLength = 12, string $chars = 'ABCDEFGHKLMNPQRSTUVWXYZ23456789')
    {
        $this->generator = $generator;
        $this->batchSize = $batchSize;
        $this->codeLength = $codeLength;
        $this->chars = $chars;
    }

    public function newCode(): string
    {
        return $this->generator->generateString($this->codeLength, $this->chars);
    }

    public function newBatch(): \Generator
    {
        for ($i = 0; $i < $this->batchSize; ++$i) {
            yield $this->newCode();
        }
    }
}
