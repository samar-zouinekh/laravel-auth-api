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
}
