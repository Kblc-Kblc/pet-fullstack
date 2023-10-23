<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePostRequest;


class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return $this->postService->getAllPosts();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $result = $this->postService->createPost($request->all());
        
        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], $result['code']);
        }

        return response()->json($result['post'], $result['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */

    public function show(Post $post)
    {
        return $this->postService->getPost($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */

    public function update(UpdatePostRequest $request, Post $post)
    {
        $result = $this->postService->updatePost($post, $request->all());

        if (isset($result['error'])) {
        return response()->json(['error' => $result['error']], $result['code']);
        }

        return response()->json($result['post'], $result['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */

    public function destroy(Post $post)
    {
        $result = $this->postService->deletePost($post);
        return response()->json(null, $result['code']);
    }
}
