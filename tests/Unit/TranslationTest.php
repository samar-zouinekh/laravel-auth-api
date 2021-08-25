<?php

namespace MedianetDev\LaravelAuthApi\Tests\Unit;

use MedianetDev\LaravelAuthApi\Tests\TestCase;

class TranslationTest extends TestCase
{
    /** @test */
    public function check_if_translation_is_working()
    {
        app('translator')->setLocale('en');
        $this->assertEquals('en', app('translator')->getLocale());
        app('translator')->setLocale('fr');
        $this->assertEquals('fr', app('translator')->getLocale());
        app('translator')->setLocale('ar');
        $this->assertEquals('ar', app('translator')->getLocale());
    }

    /** @test */
    public function check_if_translation_keys_exists_for_all_locales()
    {
        $keys = ['failed_authentication', 'account_created'];
        $locales = ['en', 'fr', 'ar'];
        foreach ($locales as $locale) {
            foreach ($keys as $key) {
                $this->assertTrue(
                    \Lang::hasForLocale('laravel-auth-api::translation.'.$key, $locale),
                    "The key '$key' does not exists in the locale '$locale'"
                );
            }
        }
    }
}
