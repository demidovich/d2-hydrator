<?php

namespace Tests\Stub;

use DateTimeImmutable;
use Tests\Stub\ExampleId;
use Tests\Stub\ExampleAddress;

/**
 * @property ExampleId         $id
 * @property int               $primitive_id
 * @property string            $primitive_string
 * @property int               $nullable_primitive_id
 * @property ExampleAddress    $address
 * @property DateTimeImmutable $nullable_datetime
 */
class Example
{
    private  ExampleId         $id;
    private  int               $primitive_id;
    private  string            $primitive_string;
    private ?int               $nullable_primitive_id = null;
    private  ExampleAddress    $address;
    private ?DateTimeImmutable $nullable_datetime = null;

    public function __get($name)
    {
        return $this->$name;
    }
}
