<?php

namespace Packages\URLShortener\DTOs;

use App\Interfaces\DtoInterface;
use Packages\URLShortener\Models\URL;

class GetURLShortenDTO implements DtoInterface
{
    public string $slug;

    public string $response;
}
