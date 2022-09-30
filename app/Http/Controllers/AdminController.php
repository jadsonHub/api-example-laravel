<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Repository\AdminRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $admRepository;

    public function __construct()
    {
        $this->admRepository = new AdminRepository();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->admRepository->list();
    }

    public function logout($id)
    {
        return $this->admRepository->logout($id);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $req)
    {
        return $this->admRepository->create($req->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->admRepository->findById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $req, $id)
    {
        return $this->admRepository->updateById($req->input(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->admRepository->deleteById($id);
    }
}
