<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/welcome.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Teaching course enrollment</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>
    <body>
      @if (Session::has('message'))
      <div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>  ..{{ Session::get('message') }}..</strong>
        </div>
      @endif
      @if (count($errors) > 0)
           <div class = "alert alert-danger">
              <ul>
                 @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                 @endforeach
              </ul>
           </div>
        @endif
        <div class="flex-center position-ref full-height">
                <div class="top-right links">
                        <a href="{{ url('/register') }}"> Register</a>
                </div>

        <div class="content">
            <form action="/" method="POST">
                {{ csrf_field() }}
                <div class="title">
                    LECTURER ENROLLMENT
                </div><br><br><br><br><br><br>
                <div class="form-group row">
                  <label class="col-sm-4 control-label">ShortName * : </label>
                  <div class="col-sm-4">
                      <input class="form-control" type="text"  name="short_name" placeholder="ABC,DFG,NTS" value="{{ Request::old('short_name')}}" required >
                  </div>
                </div>
                <div class="form-group row">
                		<label class="col-sm-4 control-label">Password * : </label>
                		<div class="col-sm-4">
                  			<input class="form-control" type="password"  name="password" placeholder="Password" required>
                		</div>
              	</div><br><br>
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                <input type="submit" id="login" class="btn btn-success" value="login">
            </form>
      </div>
        </div>
    </body>
</html>
