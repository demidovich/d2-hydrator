<?php

namespace Tests\Stub;

use Tests\Stub\ExampleId;
use Tests\Stub\ExampleAddress;

/**
 * @property ExampleId      $id
 * @property int            $primitive_id
 * @property string         $primitive_string
 * @property int            $nullable_primitive_id
 * @property ExampleAddress $nullable_address
 */
class Example
{
    private ExampleId       $id;
    private int             $primitive_id;
    private string          $primitive_string;
    private ?int            $nullable_primitive_id = null;
    private ?ExampleAddress $nullable_address = null;

    public function __get($name)
    {
        return $this->$name;
    }
}
