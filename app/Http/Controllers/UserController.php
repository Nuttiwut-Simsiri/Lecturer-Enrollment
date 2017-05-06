<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Sentinel;
use Response;
use App\User;

class UserController extends Controller
{
    public function index(){
      return view('welcome');
    }
    public function render_register(){
        return view('registration');
    }
    public function create_login(Request $req){
      $this->validate($req,User::$login_rules);
      $login = Sentinel::authenticate($req->all());
      if(Sentinel::check()){
        return redirect('/home');
      }else{

        return redirect('/');
      }
    }
    public function create_register(Request $req){
      $this->validate($req,User::$register_rule);
      $user =  Sentinel::registerAndActivate($req->all());
      if($req->first_name == 'Admin' || $req->first_name == 'Administrator'){
        $role = Sentinel::findRoleBySlug('admin');
        $role->users()->attach($user);
      }
      Session::flash('message', "Registration sucessfully");
      return redirect('/');
    }
    public function logout(){
      Sentinel::logout();
      return redirect('/');
    }
}
