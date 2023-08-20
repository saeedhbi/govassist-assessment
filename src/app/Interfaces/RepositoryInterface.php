<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function getAll();

    public function findBy(array $data);

    public function findFirstBy(array $data);

    public function findEntityById($id);

    public function deleteEntityById($id);

    public function createEntity(array $data);

    public function updateEntityById($id, array $data);
}
