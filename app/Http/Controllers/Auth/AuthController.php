<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Hash;
use App\Core\App;
use App\Exceptions\AuthenticationException;
use App\Exceptions\ValidationException;
use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthMiddleware;
use App\Models\User;
use App\Services\Auth;
use App\Services\Validation;
use App\Services\Validator;

class AuthController extends Controller
{
    protected User $user;
    protected Auth $auth;
    protected App $app;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        $this->auth = new Auth();
        $this->app = new App();
        (new AuthMiddleware())->handle([
            'logout'
        ]);
    }

    public function register()
    {
        return view('register');
    }

    public function userRegistration()
    {
        $_POST['password'] = $this->app->get(Hash::class)->create($_POST['password']);
        $_POST['created_at'] = date('Y-m-d h:i:s');
        $_POST['updated_at'] = date('Y-m-d h:i:s');
        unset($_POST['remember']);
        $this->user->create($_POST);
        return redirect('auth/login');
    }

    public function login()
    {
        return view('login');
    }

    /**
     * @throws AuthenticationException
     */
    public function authenticate()
    {
        $data = [
          'email' => $_POST['email'],
          'password' => $_POST['password'],
          'image' => $_FILES['image']
        ];

        $this->myValidator($data, [
            'email' => ['required', 'email',
                'maxLength' =>
                [
                    'max' => 10,
                    'min' => 1
                ],
                'min' =>
                [
                  'test' => 5
                ],
            ],
            'image' => ['required', 'image' => [
                'mimes' => ['jpeg'],
                'size' => 2
            ]],
            'password' => ['required'],
        ]);

        if ($_POST['_token'] !== $_SESSION['_token']) {
        }

        $isAuth = $this->auth->attempt($_POST['email'], $_POST['password'], isset($_POST['remember']));
        if (!$isAuth) {
            throw new AuthenticationException('auth/login', [
               'email' => $_POST['email'],
           ], [
               ['invalid username or password']
           ]);
        }
        return redirect('');
    }

    public function logout()
    {
        $this->auth->logout();
        return redirect('auth/login');
    }
}
