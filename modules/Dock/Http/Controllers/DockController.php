<?php

namespace Modules\Dock\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Dock\Services\DockService;
use Modules\Dock\Validators\DockValidator;

class DockController extends Controller
{
    /**
     * The carrier service instance.
     *
     * @var DockService
     */
    protected $dockService;

    public function __construct(DockService $dockService)
    {
        $this->dockService = $dockService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->dockService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(DockValidator::create($request));
        $response = $this->dockService->create($request->all());
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
        return response()->json($this->dockService->find($id));
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
        $request->validate(DockValidator::update($id, $request));
        $response = $this->dockService->update($request->all(), $id);
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
        $response = $this->dockService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
