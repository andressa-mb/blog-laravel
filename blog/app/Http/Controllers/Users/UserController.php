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
        $bloggers->when($request->filled('usersId'), function (Builder $query){
            $query->where(['id' => request('usersId')]);
        });

        $this->data['bloggers'] = $bloggers->paginate();
        return view('users.index', $this->data);
    }

    /**
     * Mostra um usuário em específico.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $blogger = User::findOrFail($user->id);
        return view('users.show', ['blogger' => $blogger]);
    }

    /**
     * Atualiza no sistema os dados de um usuário em específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

    }
}
