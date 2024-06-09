<?php

namespace System\Auth;

use App\User;
use System\Cookie\Cookie;
use System\Session\Session;

class Auth
{
    protected $redirectTo = "login";

    private function userMethod()
    {
        if (!Session::get("user") && !Cookie::get("user")) {
            return redirect($this->redirectTo);
        }

        $user = Session::get("user") ? Session::get("user") : Cookie::get("user");
        $find_user = User::find($user);

        if (empty($find_user)) {
            Session::get("user") ? Session::remove("user") : Cookie::remove("user");
            return redirect($this->redirectTo);
        }

        return $user;
    }
    private function isItMethod($input, $rule)
    {
        if (!Session::get("user") && !Cookie::get("user")) {
            return redirect($this->redirectTo);
        }

        $user = Session::get("user") ? Session::get("user") : Cookie::get("user");
        $find_user = User::find($user);

        if (empty($find_user)) {
            Session::get("user") ? Session::remove("user") : Cookie::remove("user");
            return redirect($this->redirectTo);
        }

        if ($find_user->$input != $rule) {
            return redirect($this->redirectTo);
        }

        return true;
    }
    private function checkMethod()
    {
        if (!Session::get("user") && !Cookie::get("user")) {
            return redirect($this->redirectTo);
        }

        $user = Session::get("user") ? Session::get("user") : Cookie::get("user");
        $find_user = User::find($user);

        if (empty($find_user)) {
            Session::get("user") ? Session::remove("user") : Cookie::remove("user");
            return redirect($this->redirectTo);
        }

        return true;
    }
    private function checkLoginMethod()
    {
        if (!Session::get("user") && !Cookie::get("user")) {
            return redirect($this->redirectTo);
        }

        $user = Session::get("user") ? Session::get("user") : Cookie::get("user");
        $find_user = User::find($user);

        if (empty($find_user)) {
            return false;
        }

        return true;
    }

    private function loginByEmailMethod($email, $password)
    {
        $findUser = User::where("email", $email)->get();
        if (empty($findUser)) {
            error("login", "we cant not find this email");
            return false;
        } else {
            if (!password_verify($password, $findUser[0]->password)) {
                error("login", "password is not true or equil");
                return false;
            } else {
                Session::set("user", $findUser[0]->id);
                return true;
            }
        }
    }

    private function loginByIdMethod($id)
    {
        $findUser = User::find($id);
        if (empty($findUser)) {
            error("login", "we cant not find this email");
            return false;
        } else {
            Session::set("user", $findUser->id);
            return true;
        }
    }
    
    private function logOutMethod()
    {
        Session::get("user") ? Session::remove("user") : Cookie::remove("user");
    }

    public function __call($method, $arguments)
    {
        return $this->callMethod($method, $arguments);
    }

    public static function __callStatic($method, $arguments)
    {
        $instance = new Auth();
        return $instance->callMethod($method, $arguments);
    }
    private function callMethod($method, $arguments)
    {
        $sufixx = "Method";
        $method .= $sufixx;
        return call_user_func_array(array($this, $method), $arguments);
    }
}
