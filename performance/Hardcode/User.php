<?php

namespace Performance\Hardcode;

use DateTimeImmutable;
use Performance\Hardcode\Entity;

class User implements Entity
{
    private UserId $id;
    private UserName $name;
    private UserEmail $email;
    private UserAddress $address;
    private UserPreferences $preferences;
    private DateTimeImmutable $created_at;
    private UserFields $fields;

    protected function init(): void
    {
        
    }

    public static function fromState($state): self
    {
        $self = new self;

        $self->id          = new UserId($state['id']);
        $self->name        = new UserName($state['name']);
        $self->email       = new UserEmail($state['email']);
        $self->fields      = UserFields::fromState($state);
        $self->address     = UserAddress::fromState($state);
        $self->preferences = UserPreferences::fromState($state);

        return $self;
    }
}