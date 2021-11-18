<?php


namespace Koisystems\MassEmails\Services\SearchFilterService;

use Koisystems\MassEmails\Repositories\SearchFilterRepository\SearchFilterRepositoryInterface;

class SearchFilterService implements SearchFilterServiceInterface
{

 /**
     * @var SearchFilterRepositoryInterface
     */
    private $filterRepository;

    public function __construct(
        SearchFilterRepositoryInterface $filterRepository
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
}
