<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Funko;
use App\Rules\CategoryNameNotExists;
use App\Rules\FunkoNameExists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Class FunkoController
 */
class FunkoController extends Controller
{

    /**
     * index
     * @param Request $request request
     * @return mixed view or json
     */
    public function index(Request $request)
    {
        $funkos = Funko::search($request->search)->orderBy('id', 'asc')->paginate(6);

        if ($request->expectsJson()) {
            return response()->json($funkos);
        }

        return view('funkos.index')->with('funkos', $funkos);
    }

    /**
     * show
     * @param $id id
     * @return mixed view or json
     */
    public function show($id)
    {
        try {
            $funko = Funko::findOrFail($id);
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Funko no encontrado'], 404);
            }
            flash('Funko no encontrado')->error()->important();
            return redirect()->back();
        }

        if (request()->expectsJson()) {
            return response()->json($funko);
        }

        return view('funkos.show')->with('funko', $funko);
    }

    /**
     * store
     * @param Request $request request
     * @return string | mixed
     */
    public function store(Request $request)
    {
        if ($errorResponse = $this->validateFunko($request)) {
            if ($request->expectsJson()) {
                return $errorResponse;
            }
            flash('Error al crear el Funko: ' . $errorResponse)->error()->important();
            return redirect()->back();
        }
        $funko = $this->getFunkoStore($request);
        $funko->save();

        //comprobar si espera json
        if ($request->expectsJson()) {
            return response()->json($funko, 201);
        }
        flash('Funko ' . $funko->name . '  creado con éxito.')->success()->important();
        return redirect()->route('funkos.index');
    }

    /**
     * update
     * @param Request $request request
     * @param string $id id
     * @return string | mixed
     */
    public function update(Request $request, string $id)
    {
        try {
            $funko = Funko::findOrFail($id);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Funko no encontrado'], 404);
            }
            flash('Funko no encontrado')->error()->important();
            return redirect()->back();
        }

        if ($errorResponse = $this->validateFunko($request, $funko->name)) {
            if ($request->expectsJson()) {
                return $errorResponse;
            }
            flash('Error al actualizar el Funko: ' . $errorResponse)->error()->important();
            return redirect()->back();
        }

        $funko->name = $request->input('name');
        $funko->description = $request->input('description');
        $funko->price = $request->input('price');
        $funko->stock = $request->input('stock');
        $funko->category_name = $request->input('category_name');
        $funko->save();

        if ($request->expectsJson()) {
            return response()->json($funko);
        }

        flash('Funko ' . $funko->name . ' actualizado con éxito.')->success()->important();
        return redirect()->route('funkos.index');
    }

    /**
     * destroy
     * @param string $id id
     * @return mixed view
     */
    public function destroy(string $id)
    {
        try {
            $funko = Funko::findOrFail($id);
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Funko no encontrado'], 404);
            }

            flash('Funko no encontrado')->error()->important();
            return redirect()->back();
        }
        $this->removeFunkoImage($funko);
        $funko->delete();

        if (request()->expectsJson()) {
            return response()->json(null, 204);
        }

        flash('Funko ' . $funko->name . '  eliminado con éxito.')->error()->important();
        return redirect()->route('funkos.index');
    }

    /**
     * updateImage
     * @param Request $request request
     * @param $id id
     * @return mixed view
     */
    public function updateImage(Request $request, $id)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $funko = Funko::find($id);
            $this->removeFunkoImage($funko);
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileToSave = $funko->id . '.' . $extension;
            $funko->image = $image->storeAs('funkos', $fileToSave, 'public'); // Guardamos en storage/app/public/funkos
            $funko->save();

            if ($request->expectsJson()) {
                return response()->json($funko);
            }

            flash('Imagen del Funko ' . $funko->name . ' actualizada con éxito.')->success()->important();
            return redirect()->route('funkos.index');
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Error al actualizar la imagen del Funko'], 400);
            }
            flash('Error al actualizar la imagen del Funko' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * validateFunko
     * @param Request $request request
     * @param $funkoName string|null
     * @return string|null error message
     */
    public function validateFunko(Request $request, $funkoName = null)
    {
        $rulesToAdd = '';
        if ($funkoName != null) {
            if (trim(strtolower($request->name)) != trim(strtolower($funkoName))) {
                $rulesToAdd = new FunkoNameExists;
            }
        } else {
            $rulesToAdd = new FunkoNameExists;
        }

        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', $rulesToAdd, 'max:255'],
                'description' => 'required|string|max:255',
                'price' => 'required|numeric|min:0|max:999999.99|regex:/^\d{1,6}(\.\d{1,2})?$/',
                'stock' => 'required|integer|min:0|max:1000000000',
                'category_name' => ['required', 'string', new CategoryNameNotExists],
            ]);


            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errorsString = implode(' ', $errors);
                return $errorsString;
            }
        } catch (\Brick\Math\Exception\NumberFormatException $e) {
            return response()->json(['message' => 'Error al procesar una propiedad por no tener un número válido. Evita que exceda del tamaño límite.'], 400);
        }

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        } else {
            return null;
        }
    }

    /**
     * removeFunkoImage
     * @param $funko Funko
     * @return void remove image
     */
    public function removeFunkoImage($funko): void
    {
        if ($funko->image != Funko::$IMAGE_DEFAULT && Storage::exists('public/' . $funko->image)) {
            Storage::delete('public/' . $funko->image);
        }
    }

    /// /// /// /// ///
    /// PARA VISTAS ///
    /// /// /// /// ///

    /**
     * create
     * @return mixed view
     */
    public function create()
    {
        $categories = Category::all();
        return view('funkos.create')->with('categories', $categories);
    }

    /**
     * edit
     * @param $id id
     * @return mixed view
     */
    public function edit($id)
    {
        $funko = Funko::find($id);
        $categories = Category::all();
        return view('funkos.edit')
            ->with('funko', $funko)
            ->with('categories', $categories);
    }

    /**
     * editImage
     * @param $id id
     * @return mixed view
     */
    public function editImage($id)
    {
        $funko = Funko::find($id);
        return view('funkos.image')->with('funko', $funko);
    }

    /**
     * getFunkoStore
     * @param Request $request
     * @return Funko Funko
     */
    public function getFunkoStore(Request $request): Funko
    {
        $funko = new Funko();
        $funko->name = $request->input('name');
        $funko->description = $request->input('description');
        $funko->price = $request->input('price');
        $funko->stock = $request->input('stock');
        $funko->category_name = $request->input('category_name');
        $funko->active = true;
        $funko->image = Funko::$IMAGE_DEFAULT;
        return $funko;
    }
}
