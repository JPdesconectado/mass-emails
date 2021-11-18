<?php

namespace Koisystems\MassEmails\Services\EmailTransactionItemService;



interface EmailTransactionItemServiceInterface
{
  public function get(int $id = null);
  public function insert(array $data);
  public function update(int $id, array $data);
  public function delete(int $id);
  public function getByTransactionId(int $transaction_id);
}
