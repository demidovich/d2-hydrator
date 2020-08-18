<?php

namespace Performance\Hydrator;

class UserPreferences
{
    private string $locale;
    private string $language;
    private string $timezone;
    private string $theme;
    private bool   $subscribe_news;
    private bool   $subscribe_messages;
}