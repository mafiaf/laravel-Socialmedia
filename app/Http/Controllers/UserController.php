<?php
namespace App\http\Controllers;

use App\User;
use Illuminate\Http\Request;  
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
  public function postSignUp(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|email|unique:users',
      'first_name' => 'required|max:40',
      'password' => 'required|min:5'
      ]);

    $email = $request['email'];
    $first_name = $request ['first_name'];
    $password = bcrypt($request ['password']);

    $user = new User();
    $user->email = $email;
    $user->first_name = $first_name;
    $user->password = $password;

    $user->save();

    Auth::login($user);


    return redirect()->route('dashboard');
  }

  public function postSignIn(Request $request)
  {
    $this->validate($request, [
      'email' => 'required',
      'password' => 'required'
      ]);

      if (Auth::attempt(['email' => $request ['email'], 'password' => $request ['password']])); {
        return redirect()->route('dashboard');
      }
      return redirect()->back();
  }

  public function getLogout()
  {
    Auth::logout();
    return redirect()->route('home');
  }

  public function getAccount()
  {
    return view('account', ['user' => Auth::user()]);
  }

  public function postSaveAccount(Request $request)
  {
    $this->validate($request, [
    'first_name' => 'required|max:40'
  ]);

  $user = Auth::user();
  $user->first_name = $request['first_name'];
  $user->update();
  //update cause you are not making a new account but overiding an old one
  $file = $request->file('image');
  $filename = $request['first_name'] . '-' . $user->id . '.jpg';
  //only want jpg extension, nothing else BUT there is no check.
  if ($file) {
    storage::disk('local')->put($filename, File::get($file));
    //Use laravel storage engine in facade. uses Disk area local on our server.
    }
    return redirect()->route('account');
  }

  public function getUserImage($filename)
  {
    $file = Storage::disk('local')->get($filename);
    // gets image if it exists
    return new Response($file, 200);
  }
}
