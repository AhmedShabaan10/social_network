<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Services\PostsService;


class PostController extends Controller
{
    protected $postsService;

    public function __construct(PostsService $postsService)
    {
        $this->postsService = $postsService;
    }

    public function index()
    {
        $posts = $this->postsService->getMyPosts();
        return PostResource::collection($posts);
    }

    public function show($id)
    {
        $post = $this->postsService->getPostById($id);

        if (!$post) {
            return response()->json(['status' => false, 'message' => 'Post not found'], 404);
        }

        return new PostResource($post);
    }

    public function store(StorePostRequest $request)
    {
        $post = $this->postsService->createPost($request);
        return new PostResource($post);
    }

    public function update($id, StorePostRequest $request)
    {
        $post = $this->postsService->updatePost($id, $request);

        if (!$post) {
            return response()->json(['status' => false, 'message' => 'Post not found'], 404);
        }
        return new PostResource($post);
    }

    public function destroy($id)
    {
        $deleted = $this->postsService->deletePost($id);

        if (!$deleted) {
            return response()->json(['status' => false, 'message' => 'Post not found'], 404);
        }

        return response()->json(['status' => true, 'message' => 'Post deleted successfully']);
    }


    public function getAllPosts()
    {
        $posts = $this->postsService->getAllPosts();
        return PostResource::collection($posts);
    }

    public function like($id)
    {
        $result = $this->postsService->likePost($id);

        if (!$result) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'action' => $result
        ]);
    }

    public function showLikes($id)
    {
        $likes = $this->postsService->showPostLikes($id);

        if (!$likes) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'likes' => $likes->map(function ($user) {
                return [
                    'name' => $user->name,
                    'image' => $user->image,
                ];
            })
        ]);
    }

    public function addComment($id, StorePostRequest $request)
    {
        $comment = $this->postsService->commentOnPost($id, $request);
        if (!$comment) {
            return response()->json(['status' => false, 'message' => 'Post not found'], 404);
        }

        return response()->json(['status' => true, 'message' => 'Comment added successfully']);
    }

}