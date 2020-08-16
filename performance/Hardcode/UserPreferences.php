<?php

namespace Performance\Hardcode;

use D2\DataMapper\Entity;

class UserPreferences extends Entity
{
    private string $locale;
    private string $language;
    private string $timezone;
    private string $theme;
    private bool   $subscribe_news;
    private bool   $subscribe_messages;

    public static function fromState($state)
    {
        $self = new self;

        $self->locale             = $state['preferences_locale'];
        $self->language           = $state['preferences_language'];
        $self->timezone           = $state['preferences_timezone'];
        $self->theme              = $state['preferences_theme'];
        $self->subscribe_news     = $state['preferences_subscribe_news'];
        $self->subscribe_messages = $state['preferences_subscribe_messages'];

        return $self;
    }
}