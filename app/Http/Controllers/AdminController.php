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
    public function render_Lecturer(){
      $course_list = DB::table('courses_enroll')->get();

      $table ="";
      for($i = 0; $i< sizeof($course_list);$i++){
          $user_detail = DB::table('users')->where('short_name', '=',$course_list[$i]->short_name)->get();
          $table .= '
          <tr>
            <td style="width:10%" id="name">'.$user_detail[0]->first_name." ".$user_detail[0]->last_name.'</td>
            <td style="width:10%" id="short_name">'.$course_list[$i]->short_name.'</td>
            <td style="width:10%" id="course_id">'.$course_list[$i]->course_id.'</td>
            <td style="width:10%" id="course_name">'.$course_list[$i]->course_name.'</td>
          </tr>';
      }
      $table .=
                '
                </tbody>
              </table>
                ';
      return View::make('lecturer')->with('table', $table);
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
        DB::table('courses')->truncate();
        DB::table('courses')->insert($Final);
      } catch(\Exception $e){
        return redirect('ImportNewCourses');
      }
      return redirect('home');
    }

}
