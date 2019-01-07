<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Shipment\Services\PendencyService;
use Modules\Shipment\Validators\PendencyValidator;

class PendencyController extends Controller
{
    /**
     * The pendency service instance.
     *
     * @var PendencyService
     */
    protected $pendencyService;

    public function __construct(PendencyService $pendencyService)
    {
        $this->pendencyService = $pendencyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->pendencyService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(PendencyValidator::create($request));
        $response = $this->pendencyService->create($request->all());
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
        return response()->json($this->pendencyService->find($id));
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
        $request->validate(PendencyValidator::update($id, $request));
        $response = $this->pendencyService->update($request->all(), $id);
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
        $response = $this->pendencyService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
