<?php

namespace Tests\Feature;

use Tests\TestCase;

class UpcomingMoviesTest extends TestCase
{
    /**
     * @return void
     */
    public function testEndpointResponse()
    {
        $response = $this->get('/api/upcoming-movies');

        $response->assertStatus(200);
    }
}
