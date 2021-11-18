<?php

namespace Koisystems\MassEmails\Repositories\EmailTransactionItemRepository;

use Koisystems\MassEmails\Models\EmailTransactionItem;
use Koisystems\MassEmails\Repositories\Repository;

class EmailTransactionItemRepository extends Repository implements EmailTransactionItemRepositoryInterface
{
  protected $model;

  public function __construct(EmailTransactionItem $model)
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

    public function getByTransactionId(int $transaction_id): array
    {
      return $this->model->where("transaction_id", $transaction_id)->get()->toArray();
    }

}
