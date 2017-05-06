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
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class HomeController extends Controller
{
  public function render_course(){
    return view('course');
  }
  public function render_home(){
    if(Sentinel::getUser()->id == 15){
      $course_list = DB::table('courses')->get();
      $table ="";
      for($i = 0; $i< sizeof($course_list);$i++){
          $table .= '
          <tr>
            <td style="width:10%" id="id">'.(string)($i+1).'</td>
            <td style="width:10%" id="course_id">'.$course_list[$i]->course_id.'</td>
            <td style="width:10%" id="course_name">'.$course_list[$i]->course_name.'</td>
            <td style="width:10%"><button id="btn_remove" data-id3="'.($i+1).','.$course_list[$i]->course_id.','.$course_list[$i]->course_name.'" class="btn btn-xs btn-success"> Remove </button> </td>
          </tr>';
      }
      $table .=
                '
                </tbody>
              </table>
                ';
      return View::make('home')->with('table', $table);
    }else{
      $course_list = DB::table('courses_enroll')->where('short_name', '=',Sentinel::getUser()->short_name)->get();
      $table ="";
      for($i = 0; $i< sizeof($course_list);$i++){
          $table .= '
          <tr>
            <td style="width:10%" id="id">'.(string)($i+1).'</td>
            <td style="width:10%" id="course_id">'.$course_list[$i]->course_id.'</td>
            <td style="width:10%" id="course_name">'.$course_list[$i]->course_name.'</td>
            <td style="width:10%"><button id="btn_unenroll" data-id3="'.($i+1).','.$course_list[$i]->course_id.','.$course_list[$i]->course_name.'" class="btn btn-xs btn-success"> Unenroll  </button> </td>
          </tr>';
      }
      $table .=
                '
                </tbody>
              </table>
                ';
      return View::make('home')->with('table', $table);
    }


  }
  public function query_course(Request $req){
    $key = $req->Key_search;
    if(ctype_alpha($key)){
      $course_list = DB::table('courses')->where('course_name', 'LIKE',"%$key%")->get();
    }elseif(is_numeric($key)) {
      $course_list = DB::table('courses')->where('course_id', 'LIKE',"%$key%")->get();
    }elseif (strlen($key)==0 or $key="" ) {
      $course_list= DB::table('courses')->get();
    }
    return response()->json($course_list);
  }

  public function enroll(Request $req){
    $DataInsert = array();
    $DataInsert['short_name'] = Sentinel::getUser()->short_name;
    $DataInsert['course_id'] = $req->course_id;
    $DataInsert['course_name'] = $req->course_name;
    try{
      DB::table('courses_enroll')->insert($DataInsert);
    } catch(\Exception $e){
        return response()->json( "This course : "." ".$req->course_name.'was duplicated in database');
    }
    return response()->json('Enroll '.$req->course_name.' success !!');
  }

  public function unenroll(Request $req){
    if(Sentinel::getUser()->id == 15){
      try{
        DB::table('courses')->where([
                      ['course_name', '=',  $req->course_name],
                      ['course_id', '=', $req->course_id]
                  ])->delete();
      } catch(\Exception $e){
          return response()->json($e->errorInfo);
      }
      return response()->json('Unenroll '.$req->course_name.' success !!');
    }else{
      try{
        DB::table('courses_enroll')->where([
                      ['short_name', '=', Sentinel::getUser()->short_name],
                      ['course_id', '=', $req->course_id]
                  ])->delete();
      } catch(\Exception $e){
          return response()->json($e->errorInfo);
      }
      return response()->json('Unenroll '.$req->course_name.' success !!');
    }
  }
  public function query(Request $req){
    $course_list= DB::table('courses_enroll')->where('short_name', '=',Sentinel::getUser()->short_name)->get();
    return response()->json($course_list,200);
  }
  public function queryall(Request $req){
    $course_list= DB::table('courses')->get();
    return response()->json($course_list,200);
  }
}
