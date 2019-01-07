<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Services\AccountService;
use Modules\Account\Validators\AccountValidator;

class AccountController extends Controller
{
    /**
     * The account service instance.
     *
     * @var AccountService
     */
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(app(AccountValidator::class)->getRules('create'));
        $response = $this->accountService->create($request->all());
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
        return response()->json($this->accountService->find($id));
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
        $user = $this->accountService->find($id);

        $request->validate(app(AccountValidator::class)->setId($user->id)->getRules('update'));
        $response = $this->accountService->update($request->all(), $id);
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
        $response = $this->accountService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
