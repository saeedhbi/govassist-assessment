<?php

namespace Packages\URLShortener\DTOs;

use App\Interfaces\DtoInterface;
use Packages\URLShortener\Models\URL;

class PostURLShortenDTO implements DtoInterface
{
    public string $destination;

    public URL $response;
}
