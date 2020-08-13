<?php

namespace Tests\Stub;

class ExampleAddress
{
    private string $city;
    private string $street;

    public function city(): string
    {
        return $this->city;
    }

    public function street(): string
    {
        return $this->street;
    }
}