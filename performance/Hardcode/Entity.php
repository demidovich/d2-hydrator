<?php

namespace Performance\Hardcode;

interface Entity
{
    public static function fromState($state): self;
}