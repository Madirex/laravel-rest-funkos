<?php

use App\Http\Controllers\FunkoController;
use App\Models\Category;
use App\Models\Funko;
use Illuminate\Http\Request;
use Tests\TestCase;

class FunkoControllerTest extends TestCase
{
    public function testIndex()
    {
        $funkoMock = Mockery::mock('overload:App\Models\Funko');
        $funkoMock->shouldReceive('search')
            ->andReturnSelf()
            ->shouldReceive('orderBy')
            ->andReturnSelf()
            ->shouldReceive('paginate')
            ->andReturn(collect([new Funko()]));

        $controller = new FunkoController();
        $response = $controller->index(new Request());

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertArrayHasKey('funkos', $response->getData());
        $this->assertEquals('funkos.index', $response->getName());
    }

    public function testShow()
    {
        $funkoMock = Mockery::mock('overload:App\Models\Funko');
        $funkoMock->shouldReceive('findOrFail')
            ->andReturn(new Funko());

        $controller = new FunkoController();
        $response = $controller->show('test-id');

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertEquals('funkos.show', $response->getName());
        $this->assertArrayHasKey('funko', $response->getData());

    }

    public function testStoreJsonResponse()
    {
        $funkoMock = Mockery::mock('overload:App\Models\Funko');
        $funkoMock->shouldReceive('__get')
            ->with('name')
            ->andReturn('mocked-name');
        $funkoMock->shouldReceive('save');

        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('expectsJson')->andReturn(true);
        $requestMock->shouldReceive('input')->andReturn('new-value');
        $requestMock->shouldReceive('all')->andReturn(['name' => 'mocked-name']);

        $controller = Mockery::mock(FunkoController::class)->makePartial();
        $controller->shouldReceive('validateFunko')->andReturn(null);
        $controller->shouldReceive('getFunkoStore')->andReturn($funkoMock);

        $response = $controller->store($requestMock);

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
    }

    public function testUpdate()
    {
        $funkoMock = Mockery::mock('overload:App\Models\Funko');
        $funkoMock->shouldReceive('findOrFail')
            ->andReturnSelf();
        $funkoMock->id = 1;
        $funkoMock->name = 'test-funko';
        $funkoMock->shouldReceive('save');

        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('expectsJson')->andReturn(false);
        $requestMock->shouldReceive('input')->andReturn('new-value');

        $controller = Mockery::mock(FunkoController::class)->makePartial();
        $controller->shouldReceive('validateFunko')->andReturn(null);

        $response = $controller->update($requestMock, 1);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function testDestroy()
    {
        $funkoMock = Mockery::mock('overload:App\Models\Funko');
        $funkoMock->shouldReceive('findOrFail')
            ->andReturnSelf();
        $funkoMock->id = 1;
        $funkoMock->name = 'test-funko';
        $funkoMock->shouldReceive('delete');

        $controller = Mockery::mock(FunkoController::class)->makePartial();
        $controller->shouldReceive('removeFunkoImage');

        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('expectsJson')->andReturn(false);

        $response = $controller->destroy($requestMock, 1);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function testUpdateImage()
    {
        $fileMock = Mockery::mock(UploadedFile::class);
        $fileMock->shouldReceive('getClientOriginalExtension')
            ->andReturn('jpg');
        $fileMock->shouldReceive('storeAs')
            ->andReturn('funkos/test-funko.jpg');

        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('validate');
        $requestMock->shouldReceive('file')
            ->andReturn($fileMock);
        $requestMock->shouldReceive('expectsJson')->andReturn(false); // Add this line

        $funkoMock = Mockery::mock('overload:App\Models\Funko');
        $funkoMock->shouldReceive('find')
            ->andReturnSelf();
        $funkoMock->id = 1;
        $funkoMock->name = 'test-funko';
        $funkoMock->shouldReceive('save');

        Storage::shouldReceive('exists')
            ->andReturnTrue();
        Storage::shouldReceive('delete');

        $controller = Mockery::mock(FunkoController::class)->makePartial();
        $controller->shouldReceive('removeFunkoImage');

        $response = $controller->updateImage($requestMock, 1);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function testValidateFunko()
    {
        $funkoMock = Mockery::mock('overload:App\Models\Funko');
        $funkoMock->shouldReceive('validateFunko')
            ->andReturn(collect([new Funko()]));

        $controller = new FunkoController();
        $response = $controller->validateFunko(new Request());

        $this->assertEquals('El campo name es obligatorio. El campo description es obligatorio. El campo price es obligatorio. El campo stock es obligatorio. El campo category name es obligatorio.', $response);

    }

    public function testCreate()
    {
        $categoryMock = Mockery::mock('overload:App\Models\Category');
        $categoryMock->shouldReceive('all')
            ->andReturn(collect([new Category()]));

        $controller = new FunkoController();
        $response = $controller->create();

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testEdit()
    {
        $funkoMock = Mockery::mock('overload:App\Models\Funko');
        $funkoMock->shouldReceive('find')
            ->andReturn(new Funko());

        $categoryMock = Mockery::mock('overload:App\Models\Category');
        $categoryMock->shouldReceive('all')
            ->andReturn(collect([new Category()]));

        $controller = new FunkoController();
        $response = $controller->edit('test-id');

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testEditImage()
    {
        $funkoMock = Mockery::mock('overload:App\Models\Funko');
        $funkoMock->shouldReceive('find')
            ->andReturn(new Funko());

        $controller = new FunkoController();
        $response = $controller->editImage('test-id');

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    protected function tearDown(): void
    {
        if (Mockery::getContainer() !== null) {
            Mockery::close();
        }
    }
}
