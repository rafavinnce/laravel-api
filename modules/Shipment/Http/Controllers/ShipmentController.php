<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Shipment\Services\ShipmentService;
use Modules\Shipment\Validators\ShipmentValidator;

class ShipmentController extends Controller
{
    /**
     * The shipment service instance.
     *
     * @var ShipmentService
     */
    protected $shipmentService;

    public function __construct(ShipmentService $shipmentService)
    {
        $this->shipmentService = $shipmentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->shipmentService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(ShipmentValidator::create($request));
        $response = $this->shipmentService->create($request->all());
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
        return response()->json($this->shipmentService->find($id));
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
        $request->validate(ShipmentValidator::update($id, $request));
        $response = $this->shipmentService->update($request->all(), $id);
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
        $response = $this->shipmentService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
