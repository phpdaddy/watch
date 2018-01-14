<?php

namespace App\DataProvider\MySql;

use App\DataProvider\Cache\CacheService;
use App\DataProvider\Cache\CacheServiceException;
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
    /**
     * @var CacheService
     */
    private $cacheService;


    public function __construct(WatchRepository $watchRepository, CacheService $cacheService)
    {
        $this->watchRepository = $watchRepository;
        $this->cacheService = $cacheService;
    }

    /**
     * @param integer $id
     *
     * @return WatchDto
     *
     * @throws MySqlWatchNotFoundException Is thrown when the watch could
     * not be found in a mysql
     * database, eg. watch with the
     * associated id does not exist.
     *
     * @throws MySqlWatchLoaderException May be thrown on a fatal error,
     * such as connection
     * to a database failed.
     */
    public function loadById(int $id): ?WatchDto
    {
        try {
            $watch = $this->cacheService->loadById($id);
        } catch (CacheServiceException $exception) {
            throw new MySqlWatchLoaderException($exception->getMessage());
        }
        if (isset ($watch)) {
            return $watch;
        }
        $watchDto = $this->loadDtoFromDbById($id);
        try {
            $this->cacheService->addWatch($watchDto);
        } catch (CacheServiceException $exception) {
            throw new MySqlWatchLoaderException($exception->getMessage());
        }
        return $watchDto;
    }

    private function loadDtoFromDbById(int $id)
    {
        /**
         * @var Watch $watch
         */
        try {
            $watch = $this->watchRepository->find($id);
        } catch (\Exception $exception) {
            throw new MySqlWatchLoaderException($exception->getMessage());
        }
        if (!isset($watch)) {
            throw new MySqlWatchNotFoundException("Watch was not found");
        }

        return new WatchDto($watch->getId(), $watch->getTitle(), $watch->getPrice(), $watch->getDescription());
    }
}