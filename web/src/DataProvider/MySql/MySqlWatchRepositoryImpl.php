<?php

namespace App\DataProvider\MySql;

class MySqlWatchRepositoryImpl implements MySqlWatchRepository
{
    /**
     * @param int $id
     *
     * @return MySqlWatchDTO
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
    public function getWatchById(int $id): MySqlWatchDTO
    {

    }
}