<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ValidatorUser;
use App\Http\Resources\Users\UserJson;
use App\Http\Resources\Users\UserCollection;
use App\User;
use Exception;
use \Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ValidatorUser;
    /**
     * Lista de usuários cadastrados no sistema.
     *
     */
    public function index(){
        return UserCollection::make(User::with('roles')->orderBy('id')->paginate());
    }

    /**
     * Não precisa estar autenticado para criar o novo usuário.
     * Criação de um novo usuário no sistema.
     *
     */
    public function store(Request $request){
        try{
            $validated = $this->validator($request->all())->validate();
            $user = app()->make(UserService::class)->createUser($validated);

            $token = $user->createToken('tkn_login')->plainTextToken;

            return response()->json([
                'user' => UserJson::make($user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);
        }catch(ValidationException $error){
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $error->errors(),
            ], 409);
        }catch(Exception $e){
            return response()->json([
                'message' => 'Erro ao cadastrar',
                'errors' => $e->getMessage(),
            ], 409);
        }
    }

    /**
     * Usuário autenticado sendo administrador pode criar um novo usuário.
     * ADMIN - criar usuário
     */
    public function adminStore(Request $request){
        try {
            if($request->user()->isAdmin()){
                $validated = $this->validator($request->all())->validate();
                $user = app()->make(UserService::class)->createUser($validated);

                return response()->json([
                    'user' => UserJson::make($user)
                ], 201);
            }else {
                return response()->json(['message' => 'Usuário não autorizado.'], 403);
            }
        } catch(Exception $e){
            return response()->json([
                'message' => 'Erro ao criar novo usuário. ',
                'errors' => $e->getMessage()
            ], 409);
        }
    }

    /**
     * Usuários autenticados podem ver registro de outros usuários.
     * Mostra um usuário em específico.
     *
     * @param  int  $id
     */
    public function show($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }
        return UserJson::make($user);
    }

    /**
     * Atualiza os seus dados
     * Admin pode atualizar dados de outros usuários
     *
     * @param  int  $id
     */
    public function update(Request $request, $id){
        try{
            $authenticatedUser = $request->user();
            if($authenticatedUser->isAdmin() || $authenticatedUser->id === intval($id)){
                $validated = $this->updateValidator($request->all(), $id)->validate();
                $existRoles = false;
                $isAdmin = $authenticatedUser->isAdmin() ? true : false;
                if($request->has('roles')){
                    $existRoles = true;
                }
                $editedUser = app()->make(UserService::class)->updateUser($validated, $existRoles, $isAdmin, $id);

                return UserJson::make($editedUser)
                ->response()
                ->setStatusCode(200);
            }else {
                return response()->json([
                    'message' => 'Você não tem permissão para atualizar este usuário.'
                ], 403);
            }

        }catch(ValidationException $error){
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $error->errors(),
            ], 409);
        }catch(Exception $error){
            return response()->json([
                'message' => 'Erro ao atualizar.',
                'errors' => $error->getMessage(),
            ], 409);
        }
    }

    /**
     * Deletar usuário autenticado. ADMIN pode deletar outros usuários.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $authenticatedUser = request()->user();
            $user = User::find($id);
            if(!$user){
                return response()->json(['message' => 'Usuário não encontrado.'], 404);
            }

            if($authenticatedUser->isAdmin() || $authenticatedUser->id === $user->id){
                $user->tokens()->delete();
                if($user->posts()->exists()){
                    return response()->json([
                        'message' => 'Deletado token com sucesso.',
                        'alert' => 'Usuário mantém no sistema devido a ter posts em seu perfil.'
                    ], 200);
                }
                $user->delete();
                return response()->json(['message' => 'Deletado com sucesso'], 200);
            }else {
                return response()->json(['message' => 'Não autorizado'], 404);
            }
        }catch(Exception $error){
            return response()->json([
                'message' => 'Erro ao deletar.',
                'errors' => $error->getMessage(),
            ], 500);
        }
    }

    /*
    "SQLSTATE[23503]: Foreign key violation: 7 ERROR:

    update or delete on table \"users\" violates foreign key constraint
    \"posts_user_id_foreign\" on table \"posts\"\nDETAIL:  Key (id)=(3) is still referenced from table \"posts\". (SQL: delete from \"users\" where \"id\" = 3)"

    */
}
