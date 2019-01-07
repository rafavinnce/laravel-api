<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Shipment\Services\StepService;
use Modules\Shipment\Validators\StepValidator;

class StepController extends Controller
{
    /**
     * The step service instance.
     *
     * @var StepService
     */
    protected $stepService;

    public function __construct(StepService $stepService)
    {
        $this->stepService = $stepService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->stepService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(StepValidator::create($request));
        $response = $this->stepService->create($request->all());
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
        return response()->json($this->stepService->find($id));
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
        $request->validate(StepValidator::update($id, $request));
        $response = $this->stepService->update($request->all(), $id);
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
        $response = $this->stepService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
