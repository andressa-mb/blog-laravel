<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Lista de usuários cadastrados no sistema.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $bloggers = User::orderBy('name');
        $name = $request->input('userName');
        $bloggers->when($request->filled('userName'), function (Builder $query) use($name){
            $query->where('name', 'ilike', "%$name%");
        });

        $this->data['bloggers'] = $bloggers->paginate();
        return view('users.index', $this->data);
    }

    /**
     * Mostra um usuário em específico.
     *
     * @param  \App\User  $user
     * @return View
     */
    public function show(User $user)
    {
        $blogger = User::findOrFail($user->id);
        return view('users.show', ['blogger' => $blogger]);
    }

    /**
     * Atualiza no sistema os dados de um usuário em específico.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, User $user)
    {
        try{
            $this->authorize('update', $user);
            $validated = $request->validate([
                'name'  => 'required|string|min:2',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'roles' => 'array',
                'roles.*' => 'exists:roles,id',
            ]);

            if($request->has('roles')){
                $user->roles()->sync($request->roles);
            }

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email']
            ]);

            return back()->with('message', 'Alterado com sucesso.');
        }catch(Exception $e){
            return back()->with('error', "Não pôde ser alterado os dados do usuário selecionado.");
        }
    }

    /**
     * Deleta o usuário selecionado.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(User $user)
    {
        try{
            $this->authorize('delete', $user);
            $user->delete();

            return back()->with('success', 'Usuário excluído com sucesso.');
        }catch(Exception $e){
            return back()->with('error', "Não pôde ser excluído o usuário selecionado, pode haver posts vinculados. ");
        }
    }
}
