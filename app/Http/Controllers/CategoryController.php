<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Funko;
use App\Rules\CategoryNameExists;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 */
class CategoryController extends Controller
{

    /**
     * index
     * @param Request $request request
     * @return mixed view or json
     */
    public function index(Request $request)
    {
        $categories = Category::search($request->search)->orderBy('name', 'asc')->paginate(8);


        if ($request->expectsJson()) {
            return response()->json($categories);
        }

        return view('categories.index', compact('categories'));
    }

    /**
     * show
     * @param string $id id
     * @return mixed view or json
     */
    public function show(string $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Categoría no encontrada'], 404);
            }
            flash('Categoría no encontrada')->error()->important();
            return redirect()->back();
        }

        if (request()->expectsJson()) {
            return response()->json($category);
        }

        return view('categories.show')->with('category', $category);;
    }

    /**
     * store
     * @param Request $request request
     * @return mixed view
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', new CategoryNameExists, 'max:255']
            ]);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Error al crear la categoría: debe ser única, tener máximo 255 caracteres y no debe estar vacía'], 400);
            }

            flash('Error al crear la categoría: debe ser única, tener máximo 255 caracteres y no debe estar vacía')->error()->important();
            return redirect()->back();
        }
        $category = new Category();
        $category->name = $request->input('name');

        $category->save();

        if ($request->expectsJson()) {
            return response()->json($category, 201);
        }

        flash('Categoría creada correctamente')->success();
        return redirect()->route('categories.index');
    }

    /**
     * update
     * @param Request $request request
     * @param string $id id
     * @return mixed view
     */
    public function update(Request $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (\Exception $e) {

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Categoría no encontrada'], 404);
            }
            flash('Categoría no encontrada')->error()->important();
            return redirect()->back();
        }

        try {
            $rulesToAdd = '';
            if (trim(strtolower($request->name)) != trim(strtolower($category->name))) {
                $rulesToAdd = new CategoryNameExists;
            }

            $request->validate([
                'name' => ['required', 'string', $rulesToAdd, 'max:255']
            ]);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Error al crear la categoría: debe ser única, tener máximo 255 caracteres y no debe estar vacía'], 400);
            }
            flash('Error al crear la categoría: debe ser única, tener máximo 255 caracteres y no debe estar vacía')->error()->important();
            return redirect()->back();
        }

        // Obtener todos los funkos relacionados con la categoría
        $funkos = Funko::where('category_name', $category->name)->get();

        $category->name = $request->input('name');

        // Actualizar el nombre de la categoría en los funkos relacionados
        foreach ($funkos as $funko) {
            $funko->category_name = $category->name;
            $funko->save();
        }

        $category->save();

        if ($request->expectsJson()) {
            return response()->json($category);
        }
        flash('Categoría actualizada correctamente')->success();
        return redirect()->route('categories.index');
    }

    /**
     * destroy
     * @param string $id id
     * @return mixed view
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Categoría no encontrada'], 404);
            }
            flash('Categoría no encontrada')->error()->important();
            return redirect()->back();
        }
        $category->delete();

        if (request()->expectsJson()) {
            return response()->json(null, 204);
        }

        flash('Categoría eliminada correctamente')->success();
        return redirect()->route('categories.index');
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
        return view('categories.create');
    }

    /**
     * edit
     * @param $id id
     * @return mixed view
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit')
            ->with('category', $category);
    }
}
