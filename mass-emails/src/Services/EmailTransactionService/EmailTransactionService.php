<?php


namespace Koisystems\MassEmails\Services\EmailTransactionService;

use Koisystems\MassEmails\Repositories\EmailTransactionRepository\EmailTransactionRepositoryInterface;

class EmailTransactionService implements EmailTransactionServiceInterface
{

 /**
     * @var EmailTransactionRepositoryInterface
     */
    private $filterRepository;

    public function __construct(
      EmailTransactionRepositoryInterface $filterRepository
    )
    {
      $this->filterRepository = $filterRepository;
    }


    public function get(int $id = null) {

        return $this->filterRepository->get($id);

    }

    public function insert(array $data) {
        return $this->filterRepository->insert($data);

    }

    public function update(int $id, array $data) {
        return $this->filterRepository->update($id, $data);

    }

    public function delete(int $id) {
        return $this->filterRepository->delete($id);
    }

    public function getByToken(string $token){
      return $this->filterRepository->getByToken($token);
    }
}
