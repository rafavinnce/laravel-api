<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Comment\Services\CommentService;
use Modules\Comment\Validators\CommentValidator;

class CommentController extends Controller
{
    /**
     * The comment service instance.
     *
     * @var CommentService
     */
    protected $commentService;

    /**
     * The commentable type in class full qualify name.
     *
     * @var string
     */
    protected $commentableType;

    /**
     * The commentable id of entity.
     *
     * @var string
     */
    protected $commentableId;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json($this->commentService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(CommentValidator::create($request));
        $response = $this->commentService->create($request->all());
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
        return response()->json($this->commentService->find($id));
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
        $request->validate(CommentValidator::update($id, $request));
        $response = $this->commentService->update($request->all(), $id);
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
        $response = $this->commentService->destroy($id);
        return response()->json($response, Response::HTTP_NO_CONTENT);
    }
}
