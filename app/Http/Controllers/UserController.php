<?php

namespace App\Http\Controllers;

use App\User;

use Auth;
use Validator;
use Mail;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\ThrottlesLogins;

class UserController extends Controller
{
    use ThrottlesLogins;

    private $request;

    /**
     * Where to redirect users after/after login / registration.
     *
     * @var string
     */
    private $redirectTo = '/dashboard';
    private $redirectBackTo = '/login';

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

        return redirect($this->redirectBackTo)
            ->with('successMessage', 'You have been logged out. See you soon!');
    }

    /**
     * Display the login page.
     *
     * @return \Illuminate\Http\View
     */
    public function getLogin(Request $request)
    {
        $request->session()->put('changeSection', 'sign-in');

        return view('auth.login');
    }

    /**
     * Display the register page.
     *
     * @return \Illuminate\Http\View
     */
    public function getRegister(Request $request)
    {
        $request->session()->put('changeSection', 'sign-up');

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
        if ($paginate == null) {
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
    public function authenticateUser(Request $request)
    {
        if (Auth::attempt([
            'email'    => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('checkbox'))) {
            return redirect()->intended($this->redirectTo);
        } else {
            return redirect($this->redirectBackTo)
                ->with('errorMessage', 'The email and password you entered don\'t match.');
        }
    }

    /**
     * Store the user in the database.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function storeUser(Request $request)
    {
        $data = [
            'email'                 => $request->input('email'),
            'password'              => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
        ];

        $validation = $this->validator($data);

        $validation->after(function($validation) {
            if (!$this->request->input('checkbox')) {
                $validation->errors()->add('checkbox', 'You must agree to the terms and conditions.');
            }
        });

        if (!$validation->fails()) {
            $email = $data['email'];
            $password = bcrypt($data['password']);
            $confirmationCode = str_random(30);

            User::create([
                'email'             => $email,
                'password'          => $password,
                'confirmation_code' => $confirmationCode
            ]);
            
            $this->sendConfirmationEmail($email);

            return redirect($this->redirectBackTo)
                ->with('successMessage', 'Success! Before you can sign in, look for the confirmation email we\'ve sent to <strong>' . $data['email'] . '</strong>. Check your spam folder too!')
                ->withInput();

            return redirect($this->redirectBackTo)
                ->with('successMessage', 'You have successfully signed up. Sign in!');
        }

        return redirect('/register')
            ->with('errorMessage', 'There was some issues with the data you supplied.')
            ->withInput($request->except('password'))
            ->withErrors($validation, 'register');
    }

    public function sendConfirmationEmail($email)
    {
        $user = User::where('email', $email)->where('confirmed', 0);

        if ($user->count() > 0) {
            $token = User::where('email', $email)->where('confirmed', 0)->first()->confirmation_code;

            Mail::send('auth.emails.confirmation', ['email' => $email, 'token' => $token], function ($m) use ($email, $token) {
                $m->from('admin@seatingplanner.dev', 'SeatingPlanner');

                $m->to($email, $email)->subject('Please confirm your email!');
            });

            return redirect($this->redirectBackTo)
                ->with('successMessage', 'We\'ve sent another, look for the confirmation email we\'ve sent to <strong>' . $email . '</strong>. Check your spam folder too!');
        } else {
            return redirect($this->redirectBackTo)
                ->with('errorMessage', 'You\'ve already confirmed your email. You can now sign in.');
        }
    }

    public function confirmEmail(Request $request)
    {
        $confirmationCode = $request->get('token');
        $email = $request->get('email');

        $user = User::where('email', $email)
            ->where('confirmed', 0)
            ->where('confirmation_code', $confirmationCode)
            ->first();

        if ($user != null) {
            $user->confirmed = 1;
            $user->save();

            return redirect($this->redirectBackTo)
                ->with('successMessage', 'You\'ve successfully confirmed your email. You can now sign in.');
        } else if (User::where('email', $email)->where('confirmed', 1)->count() > 0) {
            return redirect($this->redirectBackTo)
                ->with('successMessage', 'You\'ve already confirmed your email. You can now sign in.');
        }

        return redirect($this->redirectBackTo)
            ->with('errorMessage', 'The link was invalid. <strong><a href="' . url('email/confirmation/send/' . $email) . '"  style="text-decoration: underline; color: inherit !important;">Send another?</a></strong>');
    }

    /**
     * Deletes a user from the database.
     *
     * @return null
     */
    public function destroyUser($userId)
    {
        if (Auth::user()->priviledge == 1 && $userId != Auth::user()->id) {
            User::destroy($userId);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $title           = $request->input('title');
        $firstName       = $request->input('first_name');
        $lastName        = $request->input('last_name');
        $institutionName = $request->input('institution_name');

        $data = [
            'title'             => $title,
            'first_name'        => $firstName,
            'last_name'         => $lastName,
            'institution_name'  => $institutionName
        ];

        $validation = $this->validateUpdatedUser($data);

        if (!$validation->fails()) {
            User::where('id', Auth::user()->id)
                ->update([
                    'title'             => $title,
                    'first_name'        => $firstName,
                    'last_name'         => $lastName,
                    'institution_name'  => $institutionName
                ]);

            return response()->json([
                'error'   => 0,
                'message' => trans('api.user.success.update')
            ]);
        }

        $errorMessages = $validation->errors()->all();
        $responseMessage = '';

        foreach ($errorMessages as $errorMessage) {
            $responseMessage .= $errorMessage;
        }
        
        return response()->json([
            'error'   => 1,
            'message' => $responseMessage
        ]);
    }

    /**
     * Validates an array of information.
     *
     * @return Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'    => 'required|email|max:255|min:1|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);
    }

    /**
     * Validates an array of information.
     *
     * @return Validator
     */
    protected function validateUpdatedUser(array $data)
    {
        return Validator::make($data, [
            'title'            => 'required|string|in:Mr,Mrs,Miss,Ms,Dr',
            'first_name'       => 'required|between:1,20|regex:/^[a-zA-Z0-9\s-]+$/',
            'last_name'        => 'required|between:1,20|regex:/^[a-zA-Z0-9\s-]+$/',
            'institution_name' => 'nullable|between:1,20|regex:/^[a-zA-Z0-9\s-]+$/'
        ]);
    }

    public function __destruct()
    {
        $request = $this->request;
        $request->flash();
    }
}
