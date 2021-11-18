<?php

namespace Koisystems\MassEmails\Services\SearchFilterService;



interface SearchFilterServiceInterface
{
  public function get(int $id = null);
  public function insert(array $data);
  public function update(int $id, array $data);
  public function delete(int $id);
}
