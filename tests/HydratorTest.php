<?php

namespace Tests;

use ArgumentCountError;
use D2\Hydrator\Hydrator;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Tests\Stub\EntityAddress;
use Tests\Stub\Example;
use Tests\Stub\ExampleId;

class CommandTest extends TestCase
{
    public function test_on_class_correct()
    {
        $data = [
            'id' => 1,
            'primitive_id' => 2,
            'primitive_string' => 'mystring',
        ];

        $hydrator = Hydrator::onClass(Example::class);
        $hydrator->addPrefix('address', EntityAddress::class);
        $entity = $hydrator->hydrate($data);

        $this->assertNotEmpty($entity);
        $this->assertInstanceOf(Example::class, $entity);

        $this->assertInstanceOf(ExampleId::class, $entity->id);
        $this->assertEquals($data['id'], $entity->id->toPrimitive());

        $this->assertEquals($data['primitive_id'], $entity->primitive_id);
        $this->assertEquals($data['primitive_string'], $entity->primitive_string);
    }

    public function test_on_instance_correct()
    {
        $data = [
            'id' => 1,
            'primitive_id' => 2,
            'primitive_string' => 'mystring',
        ];

        $instance = new Example();
        $hydrator = Hydrator::onInstance($instance);
        $hydrator->addPrefix('address', EntityAddress::class);
        $hydrator->hydrate($data);

        $this->assertInstanceOf(ExampleId::class, $instance->id);
        $this->assertEquals($data['id'], $instance->id->toPrimitive());

        $this->assertEquals($data['primitive_id'], $instance->primitive_id);
        $this->assertEquals($data['primitive_string'], $instance->primitive_string);
    }

    public function test_value_object_construct_exception()
    {
        $this->expectException(ArgumentCountError::class);

        $data = [
            //'id' => 1,
            'primitive_id' => 2,
            'primitive_string' => 'mystring',
        ];

        $hydrator = Hydrator::onClass(Example::class);
        $hydrator->addPrefix('address', EntityAddress::class);
        $hydrator->hydrate($data);
    }

    public function test_missing_primitive_exception()
    {
        $this->expectException(RuntimeException::class);

        $data = [
            'id' => 1,
            'primitive_id' => 2,
            //'primitive_string' => 'mystring',
        ];

        $hydrator = Hydrator::onClass(Example::class);
        $hydrator->addPrefix('address', EntityAddress::class);
        $hydrator->hydrate($data);
    }
}
