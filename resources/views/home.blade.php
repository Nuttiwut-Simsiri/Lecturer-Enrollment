<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>

        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Teaching course enrollment :: Welcome !</title>

        <!-- scripts -->
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="js/jquery-3.2.0.min.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/home.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script type="text/javascript">

          function create_table(data){
            var string ="";
            for(i = 0; i < data.length; i++)
            {
                  string +=
                    `
                      <tr>
                        <td style="width:10%" id="id">`+(i+1)+`</td>
                        <td style="width:10%" id="course_id">`+data[i].course_id+`</td>
                        <td style="width:10%" id="course_name">`+data[i].course_name+`</td>
                        <td style="width:10%"><button id="btn_unenroll" data-id3="`+(i+1)+`,`+data[i].course_id+`,`+data[i].course_name+`"  class="btn btn-xs btn-success"> Unenroll  </button> </td>
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
          function fetch_data()
          {
               var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
               $("#result_table").empty();
               $.ajax({
                    url:"/query",
                    type:"POST",
                    data:{_token: CSRF_TOKEN},
                    success:function(data){
                      var start="";
                      start +=
                      `
                      <table class="table" width="70%">
                        <thead class="thead-inverse" align="center">
                          <tr>
                            <th>  #          </th>
                            <th>  Course_id   </th>
                            <th>  Course_name </th>
                            <th>  Unenroll      </th>
                          </tr>
                        </thead>
                          <tbody>
                      `;
                      var table_string = start + create_table(data);
                      $("#result_table").append(table_string);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
               });
          }
          function create_admin_table(data){
            var string ="";
            console.log(data);
            for(i = 0; i < data.length; i++)
            {
                  string +=
                    `
                      <tr>
                        <td style="width:10%" id="id">`+data[i].id+`</td>
                        <td style="width:10%" id="course_id">`+data[i].course_id+`</td>
                        <td style="width:10%" id="course_name">`+data[i].course_name+`</td>
                        <td style="width:10%"><button id="btn_remove" data-id3="`+(i+1)+`,`+data[i].course_id+`,`+data[i].course_name+`"  class="btn btn-xs btn-success"> Remove </button> </td>
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
          function fetch_admin_data()
          {
               var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
               $("#result_table").empty();
               $.ajax({
                    url:"/queryall",
                    type:"POST",
                    data:{_token: CSRF_TOKEN},
                    success:function(data){
                      var start="";
                      start +=
                      `
                      <table class="table" width="70%">
                        <thead class="thead-inverse" align="center">
                          <tr>
                            <th>  id         </th>
                            <th>  Course_id   </th>
                            <th>  Course_name </th>
                            <th>  Remove course </th>
                          </tr>
                        </thead>
                          <tbody>
                      `;
                      var table_string = start + create_admin_table(data);
                      $("#result_table").append(table_string);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
               });
          }

          $(document).on('click', '#btn_unenroll', function(){
             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
             $(this).hide();
             var data = $(this).data("id3");
             var course_array = data.split(',');
             if(confirm("Are you sure you want to Unenroll this course?"))
             {
               $.ajax({
                    url:"/home",
                    type:"POST",
                    data:{_token: CSRF_TOKEN, course_id: course_array[1].toString(), course_name: course_array[2].toString() },
                    dataType:"json",
                    success:function(data)
                    {
                      console.log(data);
                      fetch_data()
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $("#status").html(data);
                    }
               })
            }
            });
            $(document).on('click', '#btn_remove', function(){
               var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
               $(this).hide();
               var data = $(this).data("id3");
               var course_array = data.split(',');
               if(confirm("Are you sure you want to Unenroll this course?"))
               {
                 $.ajax({
                      url:"/home",
                      type:"POST",
                      data:{_token: CSRF_TOKEN, course_id: course_array[1].toString(), course_name: course_array[2].toString() },
                      dataType:"json",
                      success:function(data)
                      {
                        console.log(data);
                        fetch_admin_data();
                      },
                      error: function (data) {
                          console.log('Error:', data);
                          $("#status").html(data);
                      }
                 })
              }
        });
      $(document).ready(function(){
        $('#search-box').keyup(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var key = $(this).val();
          $.ajax({
              type: 'POST',
              url: '/remove',
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
                        <th>  Remove course </th>
                      </tr>
                    </thead>
                      <tbody>
                  `;
              var table_string = start + create_admin_table(data);
              $("#result_table").empty();
              $("#status").empty();
              $("#result_table").append(table_string);

              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
    });
});

        function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
            //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
            var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

            var CSV = '';
            //Set Report title in first row or line

            //CSV += ReportTitle + '\r\n\n';

            //This condition will generate the Label/Header
            if (ShowLabel) {
                var row = "";

                //This loop will extract the label from 1st index of on array
                for (var index in arrData[0]) {

                    //Now convert each value to string and comma-seprated
                    row += index + ',';
                }

                row = row.slice(0, -1);

                //append Label row with line break
                CSV += row + '\r\n';
            }

            //1st loop is to extract each row
            for (var i = 0; i < arrData.length; i++) {
                var row = "";

                //2nd loop will extract each column and convert it in string comma-seprated
                for (var index in arrData[i]) {
                    row += '"' + arrData[i][index] + '",';
                }

                row.slice(0, row.length - 1);

                //add a line break after each row
                CSV += row + '\r\n';
            }

            if (CSV == '') {
                alert("Invalid data");
                return;
            }

            //Generate a file name
            var fileName = "";
            //this will remove the blank-spaces from the title and replace it with an underscore
            fileName += ReportTitle.replace(/ /g,"_");

            //Initialize file format you want csv or xls
            var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

            // Now the little tricky part.
            // you can use either>> window.open(uri);
            // but this will not work in some browsers
            // or you will not get the correct file extension

            //this trick will generate a temp <a /> tag
            var link = document.createElement("a");
            link.href = uri;

            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = fileName + ".csv";

            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        $(document).on('click', '#Export', function(){
           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
           if(confirm("Are you sure you want to Export to CSV ?"))
           {
            $.ajax({
                  url:"/query",
                  type:"POST",
                  data:{_token: CSRF_TOKEN},
                  dataType:"json",
                  success:function(data)
                  {
                    console.log(data);
                    JSONToCSVConvertor(data, "Enrollment_result", true);

                  },
                  error: function (data) {
                      console.log('Error:', data);
                  }
                });
          }
        });



      </script>
    </head>
    <body>
      @if (Session::has('message'))
      <div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          ..{{ Session::get('message') }}..
      </div>
      @endif
        <div class="flex-center position-ref full-height">
                <div class="top-left links">
                    <button id="Project" class="w3-bar-item w3-button" onclick=window.location.href="{{ url('/home') }}"><i class="fa fa-home"></i>Lecturer Enrollment</button>
                    <h2> Enrollment course result</h2>
                </div>
                <div class="top-right links">
                        @if(Sentinel::check())
                           <strong><b>Welcome back,</b> {{ Sentinel::getUser()->first_name}} !</strong> &nbsp;<button class="btn-link" onclick=window.location.href="{{ url('/logout') }}">Sign-out</button>
                        @else
                          <meta HTTP-EQUIV="Refresh" CONTENT="0; URL=http://localhost:8000/">
                        @endif
                        <br><br>
                        @if(Sentinel::check())
                          @if( Sentinel::getUser()->first_name == 'Admin')
                            <input type="text" class="form-control"  id="search-box" placeholder="Search by Course name or Couse ID" >
                            <div id="status"> </div>
                          @endif
                        @endif
                </div>
                <div id="mySidenav" class="sidenav">
                  @if(Sentinel::check())
                    @if( Sentinel::getUser()->first_name != 'Admin')
                      <a href="Allcourses" id="ADD"> Enroll new Course</a>
                    @endif
                  @endif
                    @if(Sentinel::check())
                      @if( Sentinel::getUser()->first_name == 'Admin')
                          <a href="ImportNewCourses" id="import"> Import New Course </a>
                          <a href="Lecturer" id="Lecturer"> See all lecturer enrollment </a>
                      @endif
                    @endif
                </div>


          </div>
          @if(Sentinel::check())
            @if( Sentinel::getUser()->first_name == 'Admin')
            <div id="result_table">
              <table class="table" width="70%">
                <thead class="thead-inverse" align="center">
                  <tr>
                    <th>  id</th>
                    <th>  Course_id   </th>
                    <th>  Course_name </th>
                    <th>  Remove course    </th>
                  </tr>
                </thead>
                  <tbody>
                {!!$table!!}
            </div>
            @else
            <div id="result_table">
              <table class="table" width="70%">
                <thead class="thead-inverse" align="center">
                  <tr>
                    <th>  #         </th>
                    <th>  Course_id   </th>
                    <th>  Course_name </th>
                    <th>  Unenroll      </th>
                  </tr>
                </thead>
                  <tbody>
                {!!$table!!}
            </div>
            @endif
          @endif
    </body>
</html>
