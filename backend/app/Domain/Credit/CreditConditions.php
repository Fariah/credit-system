<?php

namespace App\Domain\Credit;

class CreditConditions
{
    public const MIN_SCORE = 501;

    public const MIN_INCOME = 1000;

    public const MIN_AGE = 18;

    public const MAX_AGE = 60;

    public const ALLOWED_REGIONS = ['PR', 'BR', 'OS'];

    public const REGION_RATE_MODIFIERS = [
        'OS' => 0.05,
    ];

    public const BASE_RATE = 0.10;

    public const RATE_MULTIPLIER = 100;
}
