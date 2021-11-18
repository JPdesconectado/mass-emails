<?php

namespace Koisystems\MassEmails\Repositories\SearchFilterRepository;


interface SearchFilterRepositoryInterface
{
    public function get(int $id = null): array;
    public function insert(array $data): void;
    public function update(int $id, array $data): void;
    public function delete(int $id): void;

}
