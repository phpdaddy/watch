<?php

namespace App\DataProvider;


use App\Dto\WatchDto;

interface WatchLoader
{
    /**
     * @param string $id
     *
     * @return WatchDto|null
     */
    public function loadById(string $id): ?WatchDto;
}
