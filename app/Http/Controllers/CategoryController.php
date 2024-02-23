<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Rules\CategoryNameExists;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::all();

        if ($request->expectsJson()) {
            return response()->json($categories);
        }

        return view('categories.index', compact('categories'));
    }

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
            if (strtolower($request->name) != strtolower($category->name)) {
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

        $category->name = $request->input('name');
        $category->save();

        if ($request->expectsJson()) {
            return response()->json($category);
        }
        flash('Categoría actualizada correctamente')->success();
        return redirect()->route('categories.index');
    }

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
}
