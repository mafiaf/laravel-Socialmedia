@extends('layouts.master')

@section('title')
  welcome!
@endsection

@section('content')
  <div class="row">
    <div class="col-md-6">
      <h3>Sign Up</h3>
      <form action="#" method="post"</form>
        <div class="form-group">
          <label for="email"> Your E-Mail</label>
          <input class="form-control" type="text" name="email" id="email">
        </div>
        <div class="form-group">
          <label for="first_name"> Your First Name</label>
          <input class="form-control" type="text" name="First_name" id="first_name">
        </div>
        <div class="form-group">
          <label for="Password"> Your Password</label>
          <input class="form-control" type="Password" name="Password" id="Password">
        </div>
        <button type="submit" class="btn-primary">Submit</button>
      </form>
    </div>
    <div class="col-md-6">
      <h3>Sign In</h3>
      <form action="#" method="post"</form>
        <div class="form-group">
          <label for="email"> Your E-Mail</label>
          <input class="form-control" type="text" name="email" id="email">
        </div> 
        <div class="form-group">
          <label for="Password"> Your Password</label>
          <input class="form-control" type="Password" name="Password" id="Password">
        </div>
        <button type="submit" class="btn-primary">Submit</button>
      </form>
    </div>
  </div>
@endsection
