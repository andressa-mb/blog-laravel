<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreRequest;
use App\Http\Requests\Categories\UpdateRequest;
use App\Models\Category;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Lista de categorias
     *
     * @return View
     */
    public function index()
    {
        return view('categories.index', ['categories' => Category::orderBy('id', 'desc')->paginate(10)]);
    }

    /**
     * Salvar a categoria.
     *
     * @param  App\Http\Requests\Categories\StoreRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(StoreRequest $request)
    {
        try{
            $validatedRules = $request->validated();
            Category::create([
                'name' => $validatedRules['name']
            ]);

            return redirect()->back()->with('success', 'Nova categoria salva com sucesso.');

        }catch(Throwable $error){
            throw $error;
            return back()->withErrors($error->getMessage());
        }
    }

    /**
     * Atualizar categoria em específico.
     *
     * @param  App\Http\Requests\Categories\UpdateRequest $request
     * @param  \App\Models\Category $category
     * @return \Illuminate\Routing\Redirector
     */
    public function update(UpdateRequest $request, Category $category)
    {
        try{
            $validatedRules = $request->validated();
            $category->update([
                'name' => $validatedRules['name'],
            ]);

            return redirect()->back()->with('message', 'Categoria atualizada!');
        }catch(Throwable $error){
            throw $error;
            return back()->withErrors($error->getMessage());
        }
    }

    /**
     * Remover categoria em específico.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Category $category)
    {
        try{
            $category->delete();
            return redirect()->back()->with('success', 'Excluído com sucesso.');
        }catch(Throwable $error){
            throw $error;
            return back()->withErrors($error->getMessage());
        }
    }
}
