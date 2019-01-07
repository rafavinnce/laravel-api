<?php

namespace Modules\Configuration\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Configuration\Services\ConfigurationService;
use Modules\Configuration\Validators\ConfigurationValidator;

class ConfigurationController extends Controller
{
    /**
     * The configuration service instance.
     *
     * @var ConfigurationService
     */
    protected $configurationService;

    public function __construct(ConfigurationService $configurationService)
    {
        $this->configurationService = $configurationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->configurationService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(ConfigurationValidator
            ::create($request));
        $response = $this->configurationService->create($request->all());
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
        return response()->json($this->configurationService->find($id));
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
        $request->validate(ConfigurationValidator::update($id, $request));
        $response = $this->configurationService->update($request->except(['name']), $id);
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
        $response = $this->configurationService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
