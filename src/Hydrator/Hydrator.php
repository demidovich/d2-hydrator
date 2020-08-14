<?php

namespace D2\Hydrator;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use RuntimeException;

class Hydrator
{
    private $class;
    private $prefixes = [];

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function addPrefix(string $prefix, string $class): void
    {
        $this->prefixes[$class] = $prefix;
    }

    public function hydrate(array $data)
    {
        // $instance    = new $this->class;
        // $reflection  = new ReflectionClass($instance);
        // $data       += $reflection->getDefaultProperties();

        $reflection  = new ReflectionClass($this->class);
        $instance    = $reflection->newInstanceWithoutConstructor();
        $data       += $reflection->getDefaultProperties();

        foreach ($reflection->getProperties() as $property) {

            $name = $property->getName();

            if (array_key_exists($name, $data)) {
                $value = $data[$name];
            }

            elseif ($this->isValueObject($property)) {
                $value = $this->valueObject($property, $data);
            }

            else {
                throw new RuntimeException(
                    "Error hydration \"{$this->class}\". " . 
                    "The value for the attribute \"{$name}\" is missing. " .
                    "Check initialize data prefixes."
                );
            }

            if ($property->hasType()) {
                $this->cast($value, $property->getType());
            }

            $property->setAccessible(true);
            $property->setValue($instance, $value);
        }

        return $instance;
    }

    private function cast(&$value, ReflectionNamedType $reflectionType): void
    {
        $type = $reflectionType->getName();

        if ($reflectionType->isBuiltin()) {
            settype($value, $type);
            return;
        }

        if ($value instanceof $type) {
            return;
        }

        $value = new $type($value);
    }

    private function isValueObject(ReflectionProperty $property): bool
    {
        if (! $property->hasType()) {
            return false;
        }

        if ($property->getType()->isBuiltin()) {
            return false;
        }

        return true;
    }

    private function valueObject(ReflectionProperty $property, array $data)
    {
        $class = $property->getType()->getName();

        if (isset($this->prefixes[$class])) {
            $data = $this->dataByPrefix($this->prefixes[$class], $data);
        }

        return (new Hydrator($class))->hydrate($data);
    }

    private function dataByPrefix(string $prefix, array $allData): array
    {
        $data = [];

        foreach ($allData as $name => $value) {
            if (preg_match("/^{$prefix}_(.+)$/", $name, $match)) {
                $data[$match[1]] = $value;
            }
        }

        if (! $data) {
            $class = array_search($prefix, $this->prefixes);
            throw new RuntimeException("Missing data with prefix {$prefix} for value object {$class}");
        }

        return $data;
    }
}