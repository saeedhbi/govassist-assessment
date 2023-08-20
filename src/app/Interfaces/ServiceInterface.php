<?php

namespace App\Interfaces;

interface ServiceInterface
{
    public function process(DtoInterface $dto);
}
