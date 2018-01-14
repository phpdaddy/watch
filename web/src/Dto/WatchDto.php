<?php

namespace App\Dto;

use JMS\Serializer\Annotation\Type;

class WatchDto
{
    /**
     * @var int
     * @Type("integer")
     */
    public $id;
    /**
     * @var string
     * @Type("string")
     */
    public $title;
    /**
     * @var int
     * @Type("integer")
     */
    public $price;
    /**
     * @var string
     * @Type("string")
     */
    public $description;

    /**
     * @param int $id
     * @param string $title
     * @param int $price
     * @param string $description
     */
    public function __construct(
        int $id,
        string $title,
        int $price,
        string $description
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
    }
}