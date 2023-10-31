<?php


namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function getAllPosts()
    {
        return Post::all();
    }

    public function getPostsByUser()
    {
        $userId = Auth::id();
        return Post::where('user_id', $userId)->get();
    }


    public function createPost(array $data)
    {
        $user = Auth::user();

        if (!$user) {
            return ['error' => 'Неавторизованный пользователь', 'code' => 403];
        }

        $data['user_id'] = $user->id;

        return ['post' => Post::create($data), 'code' => 201];
    }

    public function getPost(Post $post)
    {
        return $post;
    }

    public function updatePost(Post $post, array $data)
    {
        $post->update($data);
        return ['post' => $post, 'code' => 200];
    }

    public function deletePost(Post $post)
    {
        $post->delete();
        return ['code' => 204];
    }
}
