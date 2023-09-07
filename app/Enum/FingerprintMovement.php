<?php

namespace App\Enum;

enum FingerprintMovement: string
{
    case LOGIN = 'تسجيل دخول';
    case LOGOUT = 'تسجيل خروج';
    case ENTRY_TAG_ASSIGNMENT = 'تكليف بصمة دخول';
    case EXIT_TAG_ASSIGNMENT = 'تكليف بصمة خروج';
    case CALCULATION_OF_ENTRY_FINGERPRINT = "احتساب دخول بدون جزاء";
    case CALCULATION_OF_EXIT_FINGERPRINT =  "احتساب خروج بدون جزاء";
    case PUNISHMENT_DAY_DISCOUNT = "خصم يوم جزاء";
    case PUNISHMENT_2_DAY_DISCOUNT = "خصم يومين جزاء";
    case PUNISHMENT_3_DAY_DISCOUNT = "خصم ثلاثة جزاء";
}
