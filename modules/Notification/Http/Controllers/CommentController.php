<?php

namespace Modules\Notification\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Comment\Services\CommentService;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Validators\CommentValidator;

class CommentController extends Controller
{
    /**
     * The comment service instance.
     *
     * @var CommentService
     */
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $notification
     * @return Response
     */
    public function index($notification)
    {
        return response()->json($this->commentService->paginate($notification, Notification::class));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param string $notification
     * @return Response
     */
    public function store(Request $request, $notification)
    {
        $request->validate(CommentValidator::create($request));
        $response = $this->commentService->create($request->except([
            'commentable_id', 'commentable_type',
        ]), $notification, Notification::class);
        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Show the specified resource.
     *
     * @param string $id
     * @param string $notification
     * @return Response
     */
    public function show($notification, $id)
    {
        return response()->json($this->commentService->find($id, $notification, Notification::class));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  string $notification
     * @param  string $id
     * @return Response
     */
    public function update(Request $request, $notification, $id)
    {
        $request->validate(CommentValidator::update($id, $request));
        $response = $this->commentService->update($request->except([
            'commentable_id', 'commentable_type',
        ]), $id, $notification, Notification::class);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $notification
     * @param string $id
     * @return Response
     */
    public function destroy($notification, $id)
    {
        $response = $this->commentService->destroy($id, $notification, Notification::class);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
