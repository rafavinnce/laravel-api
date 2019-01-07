<?php

namespace Modules\Lobby\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Lobby\Services\LobbyService;
use Modules\Lobby\Validators\LobbyValidator;

class LobbyController extends Controller
{
    /**
     * The carrier service instance.
     *
     * @var LobbyService
     */
    protected $lobbyService;

    public function __construct(LobbyService $lobbyService)
    {
        $this->lobbyService = $lobbyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->lobbyService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(LobbyValidator::create($request));
        $response = $this->lobbyService->create($request->all());
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
        return response()->json($this->lobbyService->find($id));
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
        $request->validate(LobbyValidator::update($id, $request));
        $response = $this->lobbyService->update($request->all(), $id);
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
        $response = $this->lobbyService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
