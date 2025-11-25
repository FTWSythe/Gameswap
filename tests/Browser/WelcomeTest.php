<?php

namespace Tests\Browser;

use Pest\Browser\Pages\Page;

test('welcome screen can be rendered', function () {
    visit('/')
        ->assertNoConsoleLogs()
        ->assertNoJavaScriptErrors()
        ->assertSee('Trade, sell, or discover games nearby')
        ->assertSee('Sign in')
        ->assertSee('Create account');
});

test('guests can browse to register page from welcome page', function () {
    visit(route('home'))
        ->click('Create account')
        ->assertUrlIs(route('register'))
        ->assertNoConsoleLogs()
        ->assertNoJavaScriptErrors()
        ->assertSee('Create an account');
});

test('guests can browse to login page from welcome page', function () {
    visit(route('home'))
        ->click('Sign in')
        ->assertUrlIs(route('login'))
        ->assertNoConsoleLogs()
        ->assertNoJavaScriptErrors()
        ->assertSee('Log in to your account');
});