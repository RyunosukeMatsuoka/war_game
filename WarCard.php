<?php

namespace War;

class WarCard
{
    public function __construct(private string $suit, private string $num)
    {
    }

    public function getCardInfo(): array
    {
        return [$this->suit, $this->num];
    }
}
