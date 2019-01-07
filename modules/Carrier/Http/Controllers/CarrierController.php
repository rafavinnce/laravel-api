<?php

namespace Modules\Carrier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Carrier\Services\CarrierService;
use Modules\Carrier\Validators\CarrierValidator;

class CarrierController extends Controller
{
    /**
     * The carrier service instance.
     *
     * @var CarrierService
     */
    protected $carrierService;

    public function __construct(CarrierService $carrierService)
    {
        $this->carrierService = $carrierService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->carrierService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(CarrierValidator::create($request));
        $response = $this->carrierService->create($request->all());
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
        return response()->json($this->carrierService->find($id));
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
        $request->validate(CarrierValidator::update($id, $request));
        $response = $this->carrierService->update($request->all(), $id);
        return response()->json($response);
    }

    /**
     * Force download csv
     *
     * @param  Request $request
     * @return Response
     */
    public function download()
    {
        return response()->streamDownload(function () {
            echo $this->carrierService->download();
        }, 'carriers_' . now() . '.csv');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id
     * @return Response
     */
    public function destroy($id)
    {
        $response = $this->carrierService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
