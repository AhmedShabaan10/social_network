<?php

namespace App\Http\Controllers;

use App\Http\Services\PostsService;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    protected $postsService;

    public function __construct(PostsService $postsService)
    {
        $this->postsService = $postsService;
    }

    // public function index()
    // {
    //     $user = auth()->user();
    //     $posts = $this->postsService->getMyPosts();

    //     return view('myposts', compact('user', 'posts'));
    // }

    public function showPost($id)
    {
        $post = $this->postsService->getPostById($id);

        if (!$post) {
            return back()->with('error', 'Post not found');
        }

        return view('show', compact('post'));
    }

    public function create()
    {
        return view('creat_post');
    }

    public function storePost(Request $request)
    {
        $this->postsService->createPost($request);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully');
    }
    public function editPost($id)
    {
        $post = $this->postsService->getPostById($id);

        if (!$post) {
            return back()->with('error', 'Post not found');
        }

        return view('edit', compact('post'));
    }


    public function updatePost($id, Request $request)
    {
        $updated = $this->postsService->updatePost($id, $request);

        if (!$updated) {
            return back()->with('error', 'Post not found');
        }

        return back()->with('success', 'Post updated successfully');
    }

    public function deletePost($id)
    {
        $deleted = $this->postsService->deletePost($id);

        if (!$deleted) {
            return back()->with('error', 'Post not found');
        }

        return back()->with('success', 'Post deleted successfully');
    }

    public function like($id)
    {
        $status = $this->postsService->likePost($id);

        return back()->with('status', $status);
    }

    public function showLikes($id)
    {
        $likes = $this->postsService->showPostLikes($id);

        return view('likes', compact('likes'));
    }

    public function comment(Request $request, $id)
    {
        $result = $this->postsService->commentOnPost($id, $request->input('content'));

        if (!$result) {
            return back()->with('error', 'Post not found');
        }

        return back()->with('success', 'Comment added');
    }

    public function getAllPosts()
    {
        $posts = $this->postsService->getAllPosts();

        return view('posts', compact('posts'));
    }
}
