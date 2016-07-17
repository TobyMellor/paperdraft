<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Validator;

use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Unauthenticates the user then redirects to login page.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getLogout()
    {
        Auth::logout();
        return redirect('/login')->with('successMessage', 'You have been logged out. See you soon!');
    }

    /**
     * Display the login page.
     *
     * @return \Illuminate\Http\View
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Gets all users.
     *
     * @param Int [$paginate]
     * @return \Illuminate\Http\Redirect
     */
    public function getUsers($paginate = null)
    {
        if($paginate == null) {
            $users = User::all();
        } else {
            $users = User::paginate($paginate);
        }
        return $users;
    }

    /**
     * Get a single user.
     *
     * @param Int $userId
     * @return App\User
     */
    public function getUser($userId)
    {
        $user = User::find($userId);
        return $user;
    }

    /**
     * Attemps authentication then redirects appropriately.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function authenticateUser()
    {
        $request = $this->request;
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('checkbox'))) {
            return redirect()->intended('/dashboard');
        } else {
            return redirect('/login')
                ->with('predefinedData', [
                    'email' => $request->input('email'),
                ])
                ->with('errorMessage', 'The email and password you entered don\'t match.');
        }
    }

    /**
     * Store the user in the database.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function storeUser()
    {
        $request = $this->request;

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
        ];

        $validation = $this->validator($data);

        $validation->after(function($validation) {
            if (!$this->request->input('checkbox')) {
                $validation->errors()->add('checkbox', 'You must agree to the terms and conditions.');
            }
        });

        if(!$validation->fails()) {
            User::create([
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);
            return redirect('/login')
                ->with('changeSection', 'sign-up')
                ->with('successMessage', 'You have successfully signed up. Sign in!');
        } else {
            return redirect('/login')
                ->with('changeSection', 'sign-up')
                ->with('predefinedData', [
                    'email' => $request->input('email'),
                    'checkbox' => $request->input('checkbox')
                ])
                ->with('errorMessage', 'There was some issues with the data you supplied.')
                ->withErrors($validation, 'register');
        }
    }

    /**
     * Deletes a user from the database.
     *
     * @return null
     */
    public function destroyUser($userId)
    {
        if(Auth::user()->priviledge == 1 && $userId != Auth::user()->id) {
            User::destroy($userId);
        }
    }

    /**
     * Validates an array of information.
     *
     * @return Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|min:1|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);
    }
}
