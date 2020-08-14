<?php

namespace Tests;

use D2\Hydrator\Hydrator;
use Exception;
use PHPUnit\Framework\TestCase;
use Tests\Stub\EntityAddress;
use Tests\Stub\Example;
use Tests\Stub\ExampleEnum;
use Tests\Stub\ExampleId;

class CommandTest extends TestCase
{
    public function test_correct()
    {
        $data = [
            'id' => 1,
            'primitive_id' => 2,
            'primitive_string' => 'mystring',
        ];

        $hydrator = new Hydrator(Example::class);
        $hydrator->addPrefix('address', EntityAddress::class);
        $entity = $hydrator->hydrate($data);

        $this->assertNotEmpty($entity);
        $this->assertInstanceOf(Example::class, $entity);

        $this->assertInstanceOf(ExampleId::class, $entity->id);
        $this->assertEquals($data['id'], $entity->id->toPrimitive());

        $this->assertEquals($data['primitive_id'], $entity->primitive_id);
        $this->assertEquals($data['primitive_string'], $entity->primitive_string);
    }

    public function test_missing_param_exception()
    {
        $this->expectException(Exception::class);

        $data = [
            'integer__' => 100,   
            'string' => 'mystring',
            'datetime' => '2020-01-01 00:00:00',
            'enum' => 'example_status',
        ];

        $hydrator = new Hydrator(Example::class);
        $hydrator->addPrefix('address', EntityAddress::class);
        $entity = $hydrator->hydrate($data);
    }
}
