<?php

namespace App\Service;

use App\Entity\Entity;

abstract class AbstractService
{
    public abstract function getOne(int $id): ?Entity;

    public abstract function getAll(): array;
}
