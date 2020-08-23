<?php

namespace Performance\Hydrator;

use DateTimeImmutable;

class User
{
    private UserId $id;
    private UserName $name;
    private UserEmail $email;
    private UserAddress $address;
    private UserPreferences $preferences;
    private DateTimeImmutable $created_at;
    private UserFields $fields;

    public function init(): void
    {
        
    }
}