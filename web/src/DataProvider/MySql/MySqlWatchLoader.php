<?php

namespace App\DataProvider\MySql;

use App\DataProvider\WatchLoader;
use App\Dto\WatchDto;

class MySqlWatchLoader implements WatchLoader
{
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
        // TODO: Implement loadById() method.
    }
}