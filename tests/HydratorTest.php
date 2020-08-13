<?php

namespace Tests;

use D2\Hydrator\Hydrator;
use Exception;
use PHPUnit\Framework\TestCase;
use Tests\Stub\EntityAddress;
use Tests\Stub\Example;
use Tests\Stub\ExampleEnum;

class CommandTest extends TestCase
{
    public function test_correct()
    {
        $data = [
            'id' => 1,
            'primitive_id' => 2,
            'primitive_string' => 'mystring',
            'datetime' => '2020-01-01 00:00:00',
            'enum' => 'example_status',
        ];

        $hydrator = new Hydrator(Example::class);
        $hydrator->addPrefix('address', EntityAddress::class);
        $entity = $hydrator->hydrate($data);

        $this->assertNotEmpty($entity);
        $this->assertInstanceOf(Example::class, $entity);

        // $this->assertEquals(100, $entity->integer);
        // $this->assertEquals('mystring', $entity->string);
        // $this->assertInstanceOf(\DateTimeImmutable::class, $entity->datetime);
        // $this->assertInstanceOf(ExampleEnum::class, $entity->enum);
        // $this->assertEquals('example_status', $entity->enum->value());
    }

    // public function test_missing_param_exception()
    // {
    //     $this->expectException(Exception::class);

    //     $data = [
    //         'integer__' => 100,   
    //         'string' => 'mystring',
    //         'datetime' => '2020-01-01 00:00:00',
    //         'enum' => 'example_status',
    //     ];

    //     Hydrator::hydrate(Example::class, $data);
    // }
}
