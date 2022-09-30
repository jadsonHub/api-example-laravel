<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function register(AuthRequest $req)
    {
        return $this->userRepository->create($req->input());
    }

    public function login(LoginRequest $req)
    {
        return $this->userRepository->login($req->input());
    }

    public function logout($id)
    {
        return $this->userRepository->logout($id);
    }

    public function show($id)
    {
        return $this->userRepository->findById($id);
    }

    public function update(AuthRequest $req,$id)
    {
        
        return $this->userRepository->updateById($req->input(),$id);
    }

    public function destroy($id)
    {
        return $this->userRepository->deleteById($id);
    }
    
}
