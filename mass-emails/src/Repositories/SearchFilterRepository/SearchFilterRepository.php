<?php

namespace Koisystems\MassEmails\Repositories\SearchFilterRepository;

use Koisystems\MassEmails\Models\SearchFilter;
use Koisystems\MassEmails\Repositories\Repository;

class SearchFilterRepository extends Repository implements SearchFilterRepositoryInterface
{
    protected $model;

    public function __construct(SearchFilter $model)
    {
        parent::__construct($model);
    }

    public function get(int $id = null): array
    {
      if( is_null($id))
      return $this->model->all()->toArray();
      else {
      return $this->model->where("id", $id)->get()->toArray();
  }
    }

    public function insert(array $data): void
    {
      $this->model->insert($data);
    }

    public function update(int $id, array $data): void
    {
      $this->model->where("id", $id)->update($data);
    }

    public function delete(int $id): void
    {
      $this->model->find($id)->delete($id);
    }

}
