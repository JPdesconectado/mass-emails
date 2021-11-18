<?php

namespace Koisystems\MassEmails\Repositories\EmailTransactionItemRepository;


interface EmailTransactionItemRepositoryInterface
{
  public function get(int $id = null): array;
  public function insert(array $data): void;
  public function update(int $id, array $data): void;
  public function delete(int $id): void;
  public function getByTransactionId(int $transaction_id): array;
}
