<?php

namespace App\DataProvider;


use App\Dto\WatchDto;

interface WatchLoader
{
    /**
     * @param int $id
     *
     * @return WatchDto|null
     */
    public function loadById(int $id): ?WatchDto;
}
