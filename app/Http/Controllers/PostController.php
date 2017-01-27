<?php
namespace App\http\Controllers;

use App\Post;
use App\Like;
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

      public function postLikePost(Request $request)
      {
          $post_id = $request['postId'];
          $is_like = $request['isLike'] === 'true';
          //check if it's true, otherwise it's false. is interpreted as string and not as boolean
          $update = false;
          $post = Post::find($post_id);
          if (!$post) {
              return null;
          }
          $user = Auth::user();
          $like = $user->likes()->where('post_id', $post_id)->first();
          if ($like) {
              $already_like = $like->like;
              //when true we already like, when not true we already dislike
              $update = true;
              if ($already_like == $is_like) {
                  $like->delete();
                  return null;
              }
          } else {
              $like = new Like();
          }
          $like->like = $is_like;
          $like->user_id = $user->id;
          //accessing logged in user id
          $like->post_id = $post->id;
          if ($update) {
              $like->update();
              //if you already have an entry it updates
          } else {
              $like->save();
              //if no entry it saves the like/dislike
              // 0 is dislike in db 1 is like 
          }
          return null;
      }
  }
