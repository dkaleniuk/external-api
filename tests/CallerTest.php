<?php

declare(strict_types=1);

use App\Caller;
use PHPUnit\Framework\TestCase;

final class CallerTest extends TestCase
{
    /**
     * Test default make call to https://api.github.com/users with GET method type.
     */
    public function testDefaultMakeCall(): void
    {
        $response = (new Caller)->make('https://api.github.com/users', 'GET')->get();

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }

    /**
     * Test call to not-existing path.
     */
    public function testCallToBadPath(): void
    {
        $response = (new Caller)->make('https://bad.request', 'GET')->get();

        $this->assertEmpty($response);
    }

    /**
     * Call with incorrect method type.
     */
    public function testCallToWithIncorrectMethodType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Caller)->make('https://api.github.com/users', 'method')->get();
    }

    /**
     * Test that all default present in reponse array.
     */
    public function testAllDefaultFieldsPresent(): void
    {
        $response = (new Caller)->make('https://api.github.com/users', 'get')->get();

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);

        $requiredFields = [
            'login',
            'id',
            'node_id',
            'avatar_url',
            'gravatar_id',
            'url',
            'html_url',
            'followers_url',
            'following_url',
            'gists_url',
            'starred_url',
            'subscriptions_url',
            'organizations_url',
            'repos_url',
            'events_url',
            'received_events_url',
            'type',
            'site_admin',
        ];

        foreach ($requiredFields as $field) {
            $this->assertArrayHasKey($field, current($response));
        }
    }

    /**
     * Test where function from Caller class.
     */
    public function testWhere(): void
    {
        $response = (new Caller)->make('https://api.github.com/users', 'GET')
            ->where('id', '=', 1)
            ->get();

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals('1', current($response)['id']);
    }

    /**
     * Test sort function from Caller class.
     */
    public function testSort(): void
    {
        $descResponse = (new Caller)->make('https://api.github.com/users', 'GET')
            ->sort('login', 'desc')
            ->get();

        $this->assertIsArray($descResponse);
        $this->assertNotEmpty($descResponse);
        $this->assertEquals('wycats', current($descResponse)['login']);

        $ascResponse = (new Caller)->make('https://api.github.com/users', 'GET')
            ->sort('login', 'asc')
            ->get();

        $this->assertIsArray($ascResponse);
        $this->assertNotEmpty($ascResponse);
        $this->assertEquals('anotherjesse', current($ascResponse)['login']);
    }

    /**
     * Test only function from Caller class.
     */
    public function testOnly(): void
    {
        $response = (new Caller)->make('https://api.github.com/users', 'GET')
            ->sort('login', 'desc')
            ->only(['login']);

        $includedFields = [
            'login',
        ];

        $excludedFields = [
            'id',
            'node_id',
            'avatar_url',
            'gravatar_id',
            'url',
            'html_url',
            'followers_url',
            'following_url',
            'gists_url',
            'starred_url',
            'subscriptions_url',
            'organizations_url',
            'repos_url',
            'events_url',
            'received_events_url',
            'type',
            'site_admin',
        ];

        $firstElement = array_shift($response);
        foreach ($excludedFields as $field) {
            $this->assertArrayNotHasKey($field, $firstElement);
        }

        foreach ($includedFields as $field) {
            $this->assertArrayHasKey($field, $firstElement);
        }
    }
}