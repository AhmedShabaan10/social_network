<?php

namespace App\Http\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostsService
{
    public function getMyPosts()
    {
        return Post::with('user')
            ->orderBy('created_at', 'desc')
            ->where('user_id', auth()->id())
            ->paginate(10);
    }

    public function getPostById($id)
    {
        return Post::with('user')->where('id', $id)->first();
    }

    public function createPost($request)
    {
        $data = $request->only('content');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('posts_images', $imageName, 'public');

            $data['image'] = "storage/posts_images/{$imageName}";
        }

        return Post::create([
            'user_id' => auth()->id(),
            'content' => $data['content'],
            'image' => $data['image'] ?? null,
        ]);
    }

    public function updatePost($id, $request)
    {
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$post) {
            return false;
        }

        $data = $request->only('content');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('posts_images', $imageName, 'public');

            $data['image'] = "storage/posts_images/{$imageName}";

            if ($post->image) {
                $old = str_replace('storage/posts_images/', '', $post->image);
                Storage::disk('public')->delete('posts_images/' . $old);
            }
        }
        $post->update($data);
        return $post;
    }

    public function deletePost($postId)
    {
        $post = Post::where('id', $postId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$post) {
            return false;
        }

        if ($post->image) {
            $old = str_replace('storage/posts_images/', '', $post->image);
            Storage::disk('public')->delete('posts_images/' . $old);
        }
        return $post->delete();
    }

    public function getAllPosts()
    {
        return Post::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function likePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return false;
        }

        $userId = auth()->id();

        if ($post->likes()->where('user_id', $userId)->exists()) {

            $post->likes()->detach($userId);

            $post->decrement('likes_count');

            return 'unliked';
        }

        $post->likes()->attach($userId);

        $post->increment('likes_count');

        return 'liked';
    }

    public function showPostLikes($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return false;
        }
        return $post->likes()
            ->select('users.id', 'users.name', 'users.image')
            ->get();
    }

    public function commentOnPost($id, $content)
    {
        $post = Post::find($id);
        if (!$post) {
            return false;
        }
        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $content
        ]);

        $post->increment('comments_count');
        return true;
    }

}
