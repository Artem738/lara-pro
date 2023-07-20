<?php

namespace App\Enum;

enum LimitEnum: int
{
    case LIMIT_10 = 10;
    case LIMIT_20 = 20;
    case LIMIT_50 = 50;
    case LIMIT_100 = 100;
    case LIMIT_200 = 200;
    case LIMIT_500 = 500;
    case LIMIT_1000 = 1000;
}
