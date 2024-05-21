<?php

namespace App\Contracts\Enums;

enum ApiResponseEnum : int
{
    case AUTHENTICATION_FAILED = 401;
    case AUTHORIZATION_FAILED = 403;
    case MODAL_NOT_FOUND = 404;
    case VALIDATION_FAILED = 422;
    case UNHANDLED = 500;
}
