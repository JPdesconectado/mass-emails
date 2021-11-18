<?php

namespace Koisystems\MassEmails\Repositories\EmailTransactionRepository;

use Koisystems\MassEmails\Models\EmailTransaction;
use Koisystems\MassEmails\Repositories\Repository;

class EmailTransactionRepository extends Repository implements EmailTransactionRepositoryInterface
{
  protected $model;

  public function __construct(EmailTransaction $model)
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

    public function getByToken(string $token): array
    {
      return $this->model->where("token", $token)->get()->toArray();
    }

}
