<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> TCE: Course enroll</title>

        <!-- scripts -->
        <script src="js/jquery-3.2.0.min.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/course.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
    function create_table(data){
      var string ="";
      for(i = 0; i < data.length; i++)
      {
            string +=
              `
                <tr>
                  <td style="width:10%" id="id">`+data[i].id+`</td>
                  <td style="width:10%" id="course_id">`+data[i].course_id+`</td>
                  <td style="width:10%" id="course_name">`+data[i].course_name+`</td>
                  <td style="width:10%"><button id="btn_enroll" data-id3="`+data[i].id+`,`+data[i].course_id+`,`+data[i].course_name+`"  class="btn btn-xs btn-success"> Enroll  </button> </td>
                </tr>
              `;
      }
      string +=
                `
                </tbody>
              </table>
                `;
      return string;
    }
      $(document).ready(function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#search-box').keyup(function () {
        var key = $(this).val();
        if(key.length >=2) {
          $.ajax({
              type: 'POST',
              url: '/Allcourses',
              data: {Key_search :key,_token:CSRF_TOKEN},
              dataType: 'json',
              success: function(data) {
                  var start="";
                  start +=
                  `
                  <table class="table" width="70%">
                    <thead class="thead-inverse" align="center">
                      <tr>
                        <th>  id          </th>
                        <th>  Course_id   </th>
                        <th>  Course_name </th>
                        <th>  Enroll      </th>
                      </tr>
                    </thead>
                      <tbody>
                  `;
              var table_string = start + create_table(data);
              $("#result_table").empty();
              $("#status").empty();
              $("#result_table").append(table_string);

              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
      }
    });
    $(document).on('click', '#btn_enroll', function(){
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       $(this).hide();
       var data = $(this).data("id3");
       var course_array = data.split(',');
       console.log(course_array);
       $.ajax({
            url:"/enroll",
            type:"POST",
            data:{_token: CSRF_TOKEN, course_id: course_array[1].toString(), course_name: course_array[2].toString() },
            dataType:"json",
            success:function(data)
            {
              console.log(data);
              $("#status").html(data);
            },
            error: function (data) {
                console.log('Error:', data);
                $("#status").html(data);
            }
       })
  });
});
    </script>
    </head>

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
                      <input type="text" class="form-control"  id="search-box" placeholder="Search by Course name or Couse ID" >
                      <div id="status"> </div>

              </div>

              <div id="mySidenav" class="sidenav">
                  <a id="Export">Export to csv</a>
              </div>

        </div>
        <div id="result_table">
        </div>

    </body>
</html>
