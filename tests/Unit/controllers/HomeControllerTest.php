<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;

class HomeControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIndex()
    {
        Session::put('visits', 3);
        $controller = new HomeController();
        $response = $controller->index();
        $this->assertEquals(4, Session::get('visits'));
    }
}
