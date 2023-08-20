<?php

namespace Packages\URLShortener\DTOs;

use App\Interfaces\DtoInterface;
use Packages\URLShortener\Models\URL;

class GetURLsListDTO implements DtoInterface
{
    public $response;
}
