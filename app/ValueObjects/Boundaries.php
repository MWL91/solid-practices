<?php

namespace App\ValueObjects;

final class Boundaries
{
    private float $from;
    private ?float $to;

    /**
     * Boundaries constructor.
     */
    public function __construct(float $from, ?float $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom(): float
    {
        return $this->from;
    }

    public function getTo(): ?float
    {
        return $this->to;
    }
}