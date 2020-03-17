<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
//use Illuminate\Http\Response;

class CountryTest extends TestCase
{
    /**
     * Function to test UK IP test example.
     *
     * @return void
     */
    public function testUKIp()
    {
        $ip = strval("2.22.252.0");
        $response = $this->get('api/locationByIP/' . $ip);
        $this->assertEquals("United Kingdom", $response->getContent());
    }
}