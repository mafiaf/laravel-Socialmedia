<?php
namespace App\http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function postCreatePost(Request $request)
    {
       // validation
       $post = new Post();
       $post->body = $request['new-post'];
       $request->user()->posts()->save($post);
       //will save post as a related post to the user.
       return redirect()->route('dashboard');
    }
}
