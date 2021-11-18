<?php

namespace Koisystems\MassEmails\Services\EmailTransactionService;



interface EmailTransactionServiceInterface
{
  public function get(int $id = null);
  public function insert(array $data);
  public function update(int $id, array $data);
  public function delete(int $id);
  public function getByToken(string $token);
}
