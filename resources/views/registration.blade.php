<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/registration.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Teaching course enrollment :: registration !</title>
    </head>
    <div class="flex-center position-ref full-height">
      <div class="top-left links">
              <button id="Project" class="w3-bar-item w3-button" onclick=window.location.href="{{ url('/') }}"><i class="fa fa-home"></i>Lecturer Enrollment</button>
      </div>
    </div>
    <div class="container">
		<h2>REGISTERATION FORM</h2><br>
    @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif

		<form action="/register" method="POST">
      {{ csrf_field() }}
    <div class="form-group row">
  		<label class="col-sm-2 control-label">FirstName * : </label>
  			<div class="col-md-3">
    			<input class="form-control" type="text"  name="first_name" placeholder="First Name" value="{{ Request::old('first_name')}}" required >
  			</div>
		</div>

		<div class="form-group row">
  			<label class="col-sm-2 control-label">LastName * : </label>
  			<div class="col-md-3">
    			<input class="form-control" type="text"  name="last_name" placeholder="Last Name" value="{{ Request::old('last_name')}}" required >
  			</div>
		</div>

    <div class="form-group row">
      <label class="col-sm-2 control-label">ShortName * : </label>
      <div class="col-md-1">
        <input class="form-control" type="text"  name="short_name" placeholder="ABC" value="{{ Request::old('short_name')}}" required >
      </div>
  </div>

		<div class="form-group row">
  			<label class="col-sm-2 control-label">Password * : </label>
  			<div class="col-md-3">
    			<input class="form-control" type="password"  name="password" placeholder="Password" required>
  			</div>
		</div>

		<div class="form-group row">
  			<label class="col-sm-2 control-label" for="Password">ConfirmPassword * : </label>
  			<div class="col-md-3">
    			<input class="form-control" type="password"  name="password_confirmation" placeholder="Insert password again" required>
  			</div>
		</div>
    <br>
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
		<input type="submit" id="register" class="btn btn-success" value="register">
		<input type="button" id="cancel" class="btn btn-danger" value="Cancel" onclick="location.href='/';">
		</form>



</html>
