<?php

namespace Packages\URLShortener\DTOs;

use App\Interfaces\DtoInterface;
use Carbon\Carbon;

class CommandDeleteUnvisitedLinksDTO implements DtoInterface
{
    public Carbon $date;
}
