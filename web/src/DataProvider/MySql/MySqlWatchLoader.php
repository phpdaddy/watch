<?php

namespace App\DataProvider\MySql;

use App\DataProvider\WatchLoader;
use App\Dto\WatchDto;
use App\Entity\Watch;
use App\Repository\WatchRepository;

class MySqlWatchLoader implements WatchLoader
{
    /**
     * @var WatchRepository
     */
    private $watchRepository;

    public function __construct(WatchRepository $watchRepository)
    {
        $this->watchRepository = $watchRepository;
    }

    /**
     * @param string $id
     *
     * @return WatchDto
     *
     * @throws MySqlWatchNotFoundException Is thrown when the watch could
     * not be found in a mysql
     * database, eg. watch with the
     * associated id does not exist.
     *
     * @throws MySqlRepositoryException May be thrown on a fatal error,
     * such as connection
     * to a database failed.
     */
    public function loadById(string $id): ?WatchDto
    {
        /**
         * @var Watch $watch
         */

        $watch = $this->watchRepository->find($id);
        if (!isset($watch)) {
            throw new  MySqlWatchNotFoundException("Watch was not found");
        }
        return new WatchDto($watch->getId(), $watch->getTitle(), $watch->getPrice(), $watch->getDescription());
    }
}