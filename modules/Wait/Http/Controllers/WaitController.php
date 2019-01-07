<?php

namespace Modules\Wait\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Wait\Services\WaitService;
use Modules\Utilities\Services\UtilitiesServices;
use Modules\Wait\Validators\WaitValidator;

class WaitController extends Controller
{
    /**
     * The wait service instance.
     *
     * @var WaitService
     */
    protected $waitService;

    public function __construct(WaitService $waitService)
    {
        $this->waitService = $waitService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->waitService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(WaitValidator::create($request));
        $response = $this->waitService->create($request->all());
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
        return response()->json($this->waitService->find($id));
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
        $request->validate(WaitValidator::update($id, $request));
        $response = $this->waitService->update($request->all(), $id);
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
            echo $this->waitService->download();
        }, 'waits_' . now() . '.csv');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id
     * @return Response
     */
    public function destroy($id)
    {
        $response = $this->waitService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
