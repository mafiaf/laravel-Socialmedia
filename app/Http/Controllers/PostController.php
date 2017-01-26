<?php
namespace App\http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class PostController extends Controller
{
  public function getDashboard()
 {
    $posts = Post::orderBy('created_at', 'desc')->get();
    return view('dashboard', ['posts' => $posts]);
 }
    public function postCreatePost(Request $request)
    {
       $this->validate($request, [
         'new-post' => 'required|max:800'
       ]); //pass back error if validation fails.
       $post = new Post();
       $post->body = $request['new-post'];
       $message = 'There was an error';
       if ($request->user()->posts()->save($post)) {
       //will save post as a related post to the user.
          $message = 'Post successfully created!';
        }
       return redirect()->route('dashboard')->with(['message' => $message]);
       //giving back the message
    }

      public function getDeletePost($post_id)
      {
        $post = Post::where('id', $post_id)->first();
        if (Auth::user() != $post->user) {
          return redirect()->back();
        }
        $post->delete();
        return redirect()->route('dashboard')->with(['message' => 'Successfully deleted!']);
      }

      public function postEditPost(Request $request)
      {
          $this->validate($request, [
              'body' => 'required'
          ]);
          $post = Post::find($request['postId']);
          if (Auth::user() != $post->user) {
              return redirect()->back();
          }
          $post->body = $request['body'];
          $post->update();
          return response()->json(['new_body' => $post->body], 200);
      }
}
