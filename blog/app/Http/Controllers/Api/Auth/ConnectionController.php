<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class ConnectionController extends Controller {

    public function login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if( !$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => ['E-mail ou senha incorretas.'],
            ]);
        }
        return $user->createToken('tkn_login')->plainTextToken;
    }

    public function user() {
        return $this->userLogged();
    }

    public function logoutAllUsers(Request $request) {
       // Verificar se o usuário atual é admin
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'message' => 'Apenas administradores podem executar esta ação'
            ], 403);
        }

        try {
            // Método 1: Deletar todos os tokens
            PersonalAccessToken::truncate();

            // Método 2: Ou deletar com condições
            // PersonalAccessToken::query()->delete();

            return response()->json([
                'message' => 'Todos os usuários foram deslogados do sistema'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deslogar todos os usuários',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
