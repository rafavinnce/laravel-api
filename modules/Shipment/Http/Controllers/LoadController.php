<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Shipment\Services\LoadService;
use Modules\Shipment\Validators\LoadValidator;

class LoadController extends Controller
{
    /**
     * The load service instance.
     *
     * @var LoadService
     */
    protected $loadService;

    public function __construct(LoadService $loadService)
    {
        $this->loadService = $loadService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->loadService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(LoadValidator::create($request));
        $response = $this->loadService->create($request->all());
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
        return response()->json($this->loadService->find($id));
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
        $request->validate(LoadValidator::update($id, $request));
        $response = $this->loadService->update($request->all(), $id);
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
        $response = $this->loadService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
