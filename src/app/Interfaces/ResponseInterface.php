<?php

namespace App\Interfaces;

interface ResponseInterface
{
    public function response(DtoInterface $dto);

    public function error(\Exception $exception);
}
