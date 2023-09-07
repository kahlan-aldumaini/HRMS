<?php

namespace App\Enum\MaritalState;

enum MaritalState: string
{
    case SINGLE = 'عازب';
    case MARRIED = 'متزوج';
    case WIDOWER = 'ارمل';
    case DIVORCED = 'مطلق';
}
