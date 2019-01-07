<?php

namespace Modules\Driver\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Driver\Services\DriverService;
use Modules\Driver\Validators\DriverValidator;

class DriverController extends Controller
{
    /**
     * The driver service instance.
     *
     * @var DriverService
     */
    protected $driverService;

    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->driverService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(DriverValidator::create($request));
        $response = $this->driverService->create($request->all());
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
        return response()->json($this->driverService->find($id));
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
        $request->validate(DriverValidator::update($id, $request));
        $response = $this->driverService->update($request->all(), $id);
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
        $response = $this->driverService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
