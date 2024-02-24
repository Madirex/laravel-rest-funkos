<?php

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use Illuminate\Http\Request;
use Tests\TestCase;

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
        $this->assertArrayHasKey('categories', $response->getData());
    }

    public function testShow()
    {
        $categoryMock = Mockery::mock('overload:App\Models\Category');
        $categoryMock->shouldReceive('findOrFail')
            ->andReturn(new Category());
        $controller = new CategoryController();
        $response = $controller->show('test-id');

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertArrayHasKey('category', $response->getData());
    }

    public function testStore()
    {
        $categoryMock = Mockery::mock('overload:App\Models\Category');
        $categoryMock->shouldReceive('save')
            ->andReturnTrue();

        $controller = new CategoryController();
        $response = $controller->store(new Request(['name' => 'test-name']));

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals('', $response->getSession()->get('success'), 'Success message should be empty');
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
        $this->assertEquals(route('categories.index'), $response->headers->get('Location'));
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
        $this->assertArrayHasKey('category', $response->getData());
    }


    protected function tearDown(): void
    {
        Mockery::close();
    }
}
