<?php

namespace Performance\Hardcode;

use Performance\Hardcode\Entity;

class UserAddress implements Entity
{
    private string  $country;
    private string  $city;
    private string  $street;
    private string  $house;
    private ?string $flat = null;
    private int     $zip_code;

    public static function fromState($state): self
    {
        $self = new self;

        $self->country  = $state['address_country'];
        $self->city     = $state['address_city'];
        $self->street   = $state['address_street'];
        $self->house    = $state['address_house'];
        $self->flat     = $state['address_flat'];
        $self->zip_code = $state['address_zip_code'];

        return $self;
    }
}