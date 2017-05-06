<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Sentinel;
use Response;
use App\User;
use View;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Excel;

class AdminController extends Controller
{
    public function render_import(){
      return view('import');
    }
    public function insert_into_database(Request $request){
      $file = Input::file('fileToUpload');
      $file_name = $file->getClientOriginalName();
      $file->move('files',$file_name);
      $courseArray  = array();
      $newCourseArray  = array();
      $courseArray = Excel::load('files/'.$file_name,function ($reader){
          $reader->all();
      })->get();
      foreach ($courseArray as $key => $value) {
          $newCourseArray[$key]['course_id'] = $value['course_code'];
          $newCourseArray[$key]['course_name'] = $value['course_name'];
      }
      function unique_multidim_array($array, $key) {
          $temp_array = array();
          $i = 0;
          $key_array = array();

          foreach($array as $val) {
              if (!in_array($val[$key], $key_array)) {
                  $key_array[$i] = $val[$key];
                  $temp_array[$i] = $val;
              }
              $i++;
          }
          return $temp_array;
      }

      $Final = unique_multidim_array($newCourseArray,'course_id');
      try{
        DB::table('courses')->delete();
        DB::table('courses')->insert($Final);
      } catch(\Exception $e){
          return dd($e);
      }
      return redirect('home');
    }

}
