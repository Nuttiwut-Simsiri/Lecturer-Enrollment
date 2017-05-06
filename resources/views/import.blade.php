<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title> Import Courses to Database </title>

        <!-- scripts -->
        <script type="text/javascript" src="{{ URL::to('js/jquery-3.2.0.min.js') }}"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/import.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <script>
    $(document).ready(function(){
      $('#uploadFile').on('click', function(){
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var fd = new FormData($("#fileinfo"));
          $.ajax({
              url: '/ImportNewCourses',
              type: 'POST',
              data: fd,
              success:function(data){
                  console.log(data);
              },
              cache: false,
              contentType: false,
              processData: false
          });
      });
    })
    </script>
    <body>
      <div class="flex-center position-ref full-height">
              <div class="top-left links">
                    <button id="Project" class="w3-bar-item w3-button" onclick=window.location.href="{{ url('/home') }}"><i class="fa fa-home"></i>Lecturer Enrollment</button>
              </div>
              <div class="top-right links">
                      @if(Sentinel::check())
                         <strong><b>Welcome back,</b> {{ Sentinel::getUser()->first_name}} !</strong> &nbsp;<button class="btn-link" onclick=window.location.href="{{ url('/logout') }}">Sign-out</button>
                      @else
                        <meta HTTP-EQUIV="Refresh" CONTENT="0; URL=http://localhost:8000/">
                      @endif
                      <br><br>

              </div>
              <div class="top-center">
                <form id="fileinfo" method="POST" enctype="multipart/form-data">
                    Select csv to upload <br>
                    column name formatt : course_id,course_code<br>
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                    <input type="file" name="fileToUpload" id="fileToUpload" required />
                    <input type="submit"  class="btn btn-success" id="uploadFile" value="Upload csv file"/>
                </form>

              </div>

        </div>

    </body>
</html>
