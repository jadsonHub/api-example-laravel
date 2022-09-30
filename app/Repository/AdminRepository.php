<?php

namespace App\Repository;

use App\Models\User;
use Exception;


class AdminRepository
{

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    protected function arrayResponse($data = '', $msg = '', $error = '', $succes = '', $type = '', $token = '')
    {
        return [
            'success' => $succes,
            'error' => $error,
            'msg' => $msg ?? [],
            'data' => $data ?? [],
            'token' => $token ?? [],
            'type_error' => $type ?? []
        ];
    }

    public function create($user)
    {
        try {
            $user['password'] = bcrypt($user['password']);
            $user = $this->userModel->create($user);
            $token  = $user->createToken($user['email'])->plainTextToken;
            return response($this->arrayResponse($user, 'Usuario criado com sucesso', false, true, [], $token), 201);
        } catch (Exception $e) {
            return response($this->arrayResponse([], 'Error ao criar conta', true, false, $e->getMessage()), 401);
        }
    }

    public function findById($id)
    {
        try {
            $user = $this->userModel->find($id);

            if (!$user) {
                return response($this->arrayResponse([], 'Usuario não encontrado', true, false), 200);
            }

            return response($this->arrayResponse($user, 'Usuario encontrado', false, true), 200);
        } catch (Exception $e) {
            return response($this->arrayResponse([], 'Aconteceu algum error', true, false, $e->getMessage()), 401);
        }
    }


    public function deleteById($id)
    {

        try {

            $user = $this->userModel->where('id', $id)->delete();
            if (!$user) {
                return response($this->arrayResponse([], 'Falha ao deletar usuario', true, false), 200);
            }
            auth()->user()->tokens()->where('tokenable_id', $id)->delete();
            return response($this->arrayResponse([], 'Usuario deletado!', false, true), 200);
        } catch (Exception $e) {

            return response($this->arrayResponse([], 'Aconteceu algum error', true, false, $e->getMessage()), 401);
        }
    }

    public function logout($id)
    {
        try {
            auth()->user()->tokens()->where('tokenable_id', $id)->delete();
            return response($this->arrayResponse([], 'Usuario deslogado', false, true), 200);
        } catch (Exception $e) {
            return response($this->arrayResponse([], 'Aconteceu algum error', true, false, $e->getMessage()), 401);
        }
    }

    public function updateById($user_date, $id)
    {
        try {
            unset($user_date['password_confirmation']);
            $user_date['id'] = $id;
            $user_date['password'] = bcrypt($user_date['password']);
            $user = $this->userModel->where('id', $id)->update($user_date);
            if (!$user) {
                return response($this->arrayResponse([], 'Usuario não encontrado', true, false), 401);
            }
            $userUp = $this->userModel->where('id', $user_date['id'])->first();
            return response($this->arrayResponse($userUp, 'Usuario atualizado com sucesso', false, true), 201);
        } catch (Exception $e) {
            return response($this->arrayResponse([], 'Aconteceu algum error', true, false, $e->getMessage()), 401);
        }
    }

    public function list()
    {
        try {
            $user = $this->userModel->all();
            if (!$user) {
                return response($this->arrayResponse([], 'Sem usuarios cadastrados', false, true), 200);
            }
            return response($this->arrayResponse($user, 'Lista de usuarios', false, true), 200);
        } catch (Exception $e) {
            return response($this->arrayResponse([], 'Aconteceu algum error', true, false, $e->getMessage()), 401);
        }
    }
}
