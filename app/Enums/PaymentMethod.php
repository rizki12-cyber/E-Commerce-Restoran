<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case MANUAL_TRANSFER = 'manual_transfer';
    case COD = 'cod';
    case MIDTRANS = 'midtrans';
}