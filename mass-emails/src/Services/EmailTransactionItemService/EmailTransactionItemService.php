<?php


namespace Koisystems\MassEmails\Services\EmailTransactionItemService;

use Koisystems\MassEmails\Repositories\EmailTransactionItemRepository\EmailTransactionItemRepositoryInterface;

class EmailTransactionItemService implements EmailTransactionItemServiceInterface
{

 /**
     * @var EmailTransactionItemRepositoryInterface
     */
    private $filterRepository;

    public function __construct(
      EmailTransactionItemRepositoryInterface $filterRepository
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

    public function getByTransactionId(int $transaction_id){
      return $this->filterRepository->getByTransactionId($transaction_id);
    }
}
