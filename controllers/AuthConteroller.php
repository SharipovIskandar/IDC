<?php

namespace Controller;

use App\Auth;
use App\User;

class AuthConteroller
{
    public function login()
    {
        if( $_POST['email']
            && $_POST['password']){

            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = new User();
            $answer = $user->checkUser($email, $password);
            $_SESSION['email'] = $email;
            if($answer === Auth::ADMIN)
            {
                header('Location: /dashboard');
            }elseif ($answer === Auth::USER){
                header('Location: /');
            }
            else{
                echo "Something went wrong";
            }
        }
    }
    public function signup()
    {
        if($_POST['userName']
            && $_POST['email']
            && $_POST['gender']
            && $_POST['position']
            && $_POST['phone']
            && $_POST['password']){

            $userName = $_POST['userName'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            $position = $_POST['position'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];

            $user = new User();
            $isUserEx = $user->createUser($userName, $position, $gender, $email, $password, $phone);
            if($isUserEx){
                header('Location: /login');
            }else{
                header('Location: /login');
            }

        }
    }
    public function forgotPassword(){
        loadView('auth/forgetPassword');
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
}