<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Permission\Services\RoleService;
use Modules\Permission\Validators\RoleValidator;

class RoleController extends Controller
{
    /**
     * The role service instance.
     *
     * @var RoleService
     */
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->roleService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(RoleValidator::create($request));
        $response = $this->roleService->create($request->all());
        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Show the specified resource.
     *
     * @param  string $id
     * @return Response
     */
    public function show($id)
    {
        return response()->json($this->roleService->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  string $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(RoleValidator::update($id, $request));
        $response = $this->roleService->update($request->all(), $id);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id
     * @return Response
     */
    public function destroy($id)
    {
        $response = $this->roleService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
