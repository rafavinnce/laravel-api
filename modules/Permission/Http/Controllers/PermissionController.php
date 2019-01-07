<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Permission\Services\PermissionService;
use Modules\Permission\Validators\PermissionValidator;

class PermissionController extends Controller
{
    /**
     * The permission service instance.
     *
     * @var PermissionService
     */
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Sync the permissions from all modules in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function sync(Request $request)
    {
        return response()->json($this->permissionService->sync(), Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->permissionService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(PermissionValidator::create($request));
        $response = $this->permissionService->create($request->all());
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
        return response()->json($this->permissionService->find($id));
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
        $request->validate(PermissionValidator::update($id, $request));
        $response = $this->permissionService->update($request->all(), $id);
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
        $response = $this->permissionService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
