<?php

namespace Performance\Hardcode;

use Performance\Hardcode\Entity;

class UserFields implements Entity
{
    private string $field0;
    private string $field1;
    private string $field2;
    private string $field3;
    private string $field4;
    private string $field5;

    public static function fromState($state): self
    {
        $self = new self;

        $self->field0 = $state['field0'];
        $self->field1 = $state['field1'];
        $self->field2 = $state['field2'];
        $self->field3 = $state['field3'];
        $self->field4 = $state['field4'];
        $self->field5 = $state['field5'];

        return $self;
    }
}