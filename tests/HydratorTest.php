<?php

namespace Tests;

use ArgumentCountError;
use D2\Hydrator\Hydrator;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Tests\Stub\EntityAddress;
use Tests\Stub\Example;
use Tests\Stub\ExampleAddress;
use Tests\Stub\ExampleId;

class CommandTest extends TestCase
{
    private function data()
    {
        return [
            'id'               => 1,
            'primitive_id'     => 2,
            'primitive_string' => 'mystring',
            'address_city'     => 'Krasnodar',
            'address_street'   => 'Krasnaya',
        ];
    }

    public function test_on_class_correct()
    {
        $data = $this->data();

        $hydrator = Hydrator::onClass(Example::class);
        $hydrator->addPrefix('address', ExampleAddress::class);
        $entity = $hydrator->hydrate($data);

        $this->assertNotEmpty($entity);
        $this->assertInstanceOf(Example::class, $entity);

        $this->assertInstanceOf(ExampleId::class, $entity->id);
        $this->assertEquals($data['id'], $entity->id->toPrimitive());

        $this->assertEquals($data['primitive_id'], $entity->primitive_id);
        $this->assertEquals($data['primitive_string'], $entity->primitive_string);
        $this->assertEquals(null, $entity->nullable_datetime);

        $this->assertInstanceOf(ExampleAddress::class, $entity->address);
        $this->assertEquals($data['address_city'], $entity->address->city());
        $this->assertEquals($data['address_street'], $entity->address->street());
    }

    public function test_on_instance_correct()
    {
        $data = $this->data();

        $instance = new Example();
        $hydrator = Hydrator::onInstance($instance);
        $hydrator->addPrefix('address', ExampleAddress::class);
        
        $hydrator->hydrate($data);

        $this->assertInstanceOf(ExampleId::class, $instance->id);
        $this->assertEquals($data['id'], $instance->id->toPrimitive());

        $this->assertEquals($data['primitive_id'], $instance->primitive_id);
        $this->assertEquals($data['primitive_string'], $instance->primitive_string);
    }

    public function test_on_prebuild_value_object()
    {
        $data = $this->data();
        $data['id'] = new ExampleId($data['id']);

        $hydrator = Hydrator::onClass(Example::class);
        $hydrator->addPrefix('address', ExampleAddress::class);
        $entity = $hydrator->hydrate($data);

        $this->assertTrue($entity->id->equalsTo($data['id']));
    }

    public function test_value_object_construct_exception()
    {
        $data = $this->data();
        unset($data['id']);

        $this->expectException(ArgumentCountError::class);

        $hydrator = Hydrator::onClass(Example::class);
        $hydrator->addPrefix('address', EntityAddress::class);
        $hydrator->hydrate($data);
    }

    public function test_missing_primitive_exception()
    {
        $data = $this->data();
        unset($data['primitive_string']);

        $this->expectException(RuntimeException::class);

        $hydrator = Hydrator::onClass(Example::class);
        $hydrator->addPrefix('address', EntityAddress::class);
        $hydrator->hydrate($data);
    }
}
