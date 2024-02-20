<?php

namespace App\Http\Controllers;

use App\Models\Funko;
use App\Rules\CategoryNameNotExists;
use App\Rules\FunkoNameExists;
use Illuminate\Http\Request;
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
        $funkos = Funko::search($request->search)->orderBy('id', 'asc')->paginate(4);

        if ($request->expectsJson()) {
            return response()->json($funkos);
        }

        return view('funkos.index')->with('funkos', $funkos);
    }


    public function show($id)
    {
        try {
            $funko = Funko::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Funko no encontrado'], 404);
        }
        return response()->json($funko);
    }


   /* public function create() // TODO: do
    {
        $categories = Category::all();
        return view('funkos.create')->with('categories', $categories);
    }*/

    public function store(Request $request)
    {
        if ($errorResponse = $this->validateFunko($request)) {return $errorResponse;}
        $funko = new Funko();
        $funko->name = $request->input('name');
        $funko->description = $request->input('description');
        $funko->price = $request->input('price');
        $funko->stock = $request->input('stock');
        $funko->category_name = $request->input('category_name');
        $funko->active = true;
        $funko->image = Funko::$IMAGE_DEFAULT;
        $funko->save();
        return response()->json($funko, 201);
    }


    public function update(Request $request, string $id)
    {
        try {
            $funko = Funko::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Funko no encontrado'], 404);
        }

        if ($errorResponse = $this->validateFunko($request)) {return $errorResponse;}

        $funko->name = $request->input('name');
        $funko->description = $request->input('description');
        $funko->price = $request->input('price');
        $funko->stock = $request->input('stock');
        $funko->category_name = $request->input('category_name');
        $funko->save();

        return response()->json($funko);
    }

    public function destroy(string $id)
    {
        try {
            $funko = Funko::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Funko no encontrado'], 404);
        }
        $funko->delete();

        return response()->json(null, 204);
    }

    public function validateFunko(Request $request, $funkoid = null)
    {
        $funkoaddid = '';
        if ($funkoid != null){
            $funkoaddid = ',' . $funkoid->id;
        }

        try{
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', new FunkoNameExists, 'max:255'],
                'description' => 'required|string|max:255',
                'price' => 'required|numeric|min:0|max:999999.99|regex:/^\d{1,6}(\.\d{1,2})?$/',
                'stock' => 'required|integer|min:0|max:1000000000',
                'category_name' => ['required', 'string', new CategoryNameNotExists],
            ]);


            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return response()->json(['errors' => $errors], 400);
            }
        } catch (\Brick\Math\Exception\NumberFormatException $e) {
            return response()->json(['message' => 'Error al procesar una propiedad por no tener un número válido. Evita que exceda del tamaño límite.'], 400);
        }

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }else{
            return null;
        }
    }
}
