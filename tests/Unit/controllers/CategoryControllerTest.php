<?php

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use Illuminate\Http\Request;
use Tests\TestCase;
use Mockery;

class CategoryControllerTest extends TestCase
{
    public function testIndex()
    {
        $categoryMock = Mockery::mock('overload:App\Models\Category');
        $categoryMock->shouldReceive('search')
            ->andReturnSelf()
            ->shouldReceive('orderBy')
            ->andReturnSelf()
            ->shouldReceive('paginate')
            ->andReturn(collect([new Category()]));

        $controller = new CategoryController();
        $response = $controller->index(new Request());

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testShow()
    {
        $categoryMock = Mockery::mock('overload:App\Models\Category');
        $categoryMock->shouldReceive('findOrFail')
            ->andReturn(new Category());
        $controller = new CategoryController();
        $response = $controller->show('test-id');
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testStore()
    {
        $categoryMock = Mockery::mock('overload:App\Models\Category');
        $categoryMock->shouldReceive('save')
            ->andReturnTrue();

        $controller = new CategoryController();
        $response = $controller->store(new Request(['name' => 'test-name']));

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function testUpdate()
    {
        $categoryMock = Mockery::mock('overload:App\Models\Category');
        $categoryMock->shouldReceive('findOrFail')
            ->andReturnSelf()
            ->shouldReceive('save')
            ->andReturnTrue();

        $controller = new CategoryController();
        $response = $controller->update(new Request(['name' => 'test-name']), 'test-id');

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function testDestroy()
    {
        $categoryMock = Mockery::mock('overload:App\Models\Category');
        $categoryMock->shouldReceive('findOrFail')
            ->andReturnSelf()
            ->shouldReceive('delete')
            ->andReturnTrue();

        $controller = new CategoryController();
        $response = $controller->destroy('test-id');

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function testCreate()
    {
        $controller = new CategoryController();
        $response = $controller->create();
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testEdit()
    {
        $categoryMock = Mockery::mock('overload:App\Models\Category');
        $categoryMock->shouldReceive('find')
            ->andReturn(new Category());

        $controller = new CategoryController();
        $response = $controller->edit('test-id');

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }


    protected function tearDown(): void
    {
        Mockery::close();
    }
}
