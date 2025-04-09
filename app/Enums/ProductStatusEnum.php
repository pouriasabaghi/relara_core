<?php

namespace App\Enums;

enum ProductStatusEnum: string
{
    case Available = 'available';
    case Unavailable = 'unavailable';
    case Call = 'call';
}