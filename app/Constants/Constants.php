<?php

namespace App\Constants;

use App\Models\User;
use Carbon\Carbon;

class Constants
{
    public const ID = 'id';
    public const CODE = 'code';
    public const RESPONSE_SERVER_ERROR = 'Server error';
    public const BAD_REQUEST = 'Bad Request';
    public const RESOURCE_NOT_FOUND = 'Resource not found';
    public const DEFAULT_PER_PAGE = 20;
    public const DEFAULT_ORDER_ASC = 'ASC';
    public const DEFAULT_ORDER_DESC = 'DESC';
    public const DATETIME_Y_M_D_H_I_S = 'datetime:Y-m-d h:i:s';
}
