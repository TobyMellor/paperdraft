<?php

namespace App\Http\Controllers;

use App\User;
use App\Institution;
use App\PasswordReset;

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
    private $redirectTo     = '/dashboard';
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

        return view('auth.login')
            ->with('email', $request->input('email'));
    }

    /**
     * Display the register page.
     *
     * @return \Illuminate\Http\View
     */
    public function getRegister(Request $request)
    {
        $request->session()->put('changeSection', 'sign-up');

        return view('auth.login')
            ->with('email', $request->input('email'));
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
        $email    = $request->input('email');
        $password = $request->input('password');
        
        if (User::where('email', $email)->where('confirmed', 0)->count() > 0) {
            return redirect($this->redirectBackTo)
                ->withInput()
                ->with('response', [
                    'error'   => 1,
                    'message' => 'You need to confirm your email first. 
                        <strong>
                            <a href="' . url('email/confirmation/send/' . $email) . '" class="send-confirm">
                                Send another email confirmation?
                            </a>
                        </strong>'
                ]);
        } else if (
            Auth::attempt([
                'email'    => $email,
                'password' => $password
            ], $request->input('checkbox'))) {
                return redirect('dashboard');
        }

        return redirect($this->redirectBackTo)
            ->withInput()
            ->with('response', [
                'error'   => 1,
                'message' => 'The email and password you entered don\'t match.',
                'fields'  => [
                    'password' => 'The email and password you entered don\'t match.'
                ]
            ]);
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
            'institution_code'      => $request->input('institution_code')
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

            $user = new User;

            $user->email             = $email;
            $user->password          = $password;
            $user->confirmation_code = $confirmationCode;

            if ($data['institution_code'] !== null) {
                $institution = Institution::where('institution_code', 'LIKE', $data['institution_code'])->first();

                $user->institution_id = $institution->id;
            }

            $user->save();
            
            $this->sendConfirmationEmail($email);

            return redirect($this->redirectBackTo)
                ->withInput($request->except('password'))
                ->with('response', [
                    'error'   => 0,
                    'message' => 'Success! Before you can sign in, look for the confirmation email we\'ve sent to <strong>' . $data['email'] . '</strong>. Check your spam folder too!'
                ]);
        }

        return redirect('/register')
            ->withInput($request->except('password'))
            ->with('response', [
                'error'   => 1,
                'message' => 'There\'s a few problems with the data you supplied.',
                'fields'  => $validation->errors()
            ]);
    }

    public function sendConfirmationEmail($email)
    {
        $user = User::where('email', $email)->where('confirmed', 0);

        if ($user->count() > 0) {
            $token = User::where('email', $email)->where('confirmed', 0)->first()->confirmation_code;

            Mail::send('auth.emails.confirmation', [
                    'email' => $email,
                    'token' => $token
                ], function ($m) use ($email, $token) {
                    $m->from('admin@paperdraft.dev', 'PaperDraft');

                    $m->to($email, $email)->subject('Please confirm your email!');
            });

            return redirect($this->redirectBackTo)
                ->with('response', [
                    'error'   => 0,
                    'message' => 'We\'ve sent another, look for the confirmation email we\'ve sent to <strong>' . $email . '</strong>. Check your spam folder too!'
                ]);
        }

        $user = User::where('email', $email);

        if ($user->count() === 0) {
            return redirect('/register')
                ->with('response', [
                    'error'   => 1,
                    'message' => 'The email <strong>' . $email . '</strong> doesn\'t exist in our records. Try registering again.'
                ]);
        }

        return redirect($this->redirectBackTo)
                ->withInput()
            ->with('response', [
                'error'   => 0,
                'message' => 'You\'ve already confirmed your email. You can now sign in.'
            ]);
    }

    public function confirmEmail(Request $request)
    {
        $confirmationCode = $request->get('token');
        $email            = $request->get('email');

        $user = User::where('email', $email)
            ->where('confirmed', 0)
            ->where('confirmation_code', $confirmationCode)
            ->first();

        if ($user != null) {
            $user->confirmed = 1;
            $user->save();

            return redirect($this->redirectBackTo)
                ->withInput()
                ->with('response', [
                    'error'   => 0,
                    'message' => 'You\'ve successfully confirmed your email. You can now sign in.'
                ]);
        } else if (User::where('email', $email)->where('confirmed', 1)->count() > 0) {
            return redirect($this->redirectBackTo)
                ->withInput()
                ->with('response', [
                    'error'   => 0,
                    'message' => 'You\'ve already confirmed your email. You can now sign in.'
                ]);
        }

        return redirect($this->redirectBackTo)
            ->withInput()
            ->with('response', [
                'error'   => 1,
                'message' => 'The link was invalid. 
                    <strong>
                        <a href="' . url('email/confirmation/send/' . $email) . '" class="send-confirm">
                            Send another?
                        </a>
                    </strong>'
            ]);
    }

    /**
     * Deletes a user from the database.
     *
     * @return null
     */
    public function destroyUser($userId)
    {
        if (Auth::user()->priviledge === 1 && $userId !== Auth::id()) {
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
        $title     = $request->input('title');
        $firstName = $request->input('first_name');
        $lastName  = $request->input('last_name');

        $data = [
            'title'      => $title,
            'first_name' => $firstName,
            'last_name'  => $lastName
        ];
        
        $validation = $this->validateUpdatedUser($data);

        if (!$validation->fails()) {
            User::where('id', Auth::id())
                ->update([
                    'title'      => $title,
                    'first_name' => $firstName,
                    'last_name'  => $lastName
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
     * Display the password reset page.
     *
     * @return \Illuminate\Http\View
     */
    public function getForgottenPassword()
    {
        return view('auth.passwords.forgotten');
    }

    /**
     * Display the password reset page.
     *
     * @return \Illuminate\Http\View
     */
    public function getResetPassword(Request $request, $token)
    {
        $email = $request->input('email');

        $passwordResetField = PasswordReset::where('email', $email)
            ->where('token', $token);

        if ($passwordResetField->count() > 0) {
            return view('auth.passwords.reset')
                ->with('token', $token);
        }

        return redirect('login')
            ->with('response', [
                'error'   => 1,
                'message' => 'The password reset link was invalid. Please request another to continue.'
            ]);
    }

    public function sendPasswordResetLink(Request $request)
    {
        $email = $request->input('email');

        $data = [
            'email' => $email
        ];

        $validation = $this->validateResetLink($data);

        if (!$validation->fails()) {
            $token = str_random(50);

            $passwordResetField = PasswordReset::where('email', $email);

            if ($passwordResetField->count() === 0) {
                $passwordResetField = new PasswordReset;

                $passwordResetField->email = $email;
                $passwordResetField->token = $token;

                $passwordResetField->save();
            } else {
                $passwordResetField->update([
                    'token' => $token
                ]);
            }

            Mail::send('auth.emails.reset', [
                    'email' => $email,
                    'token' => $token
                ], function ($m) use ($email, $token) {
                    $m->from('admin@paperdraft.dev', 'PaperDraft');

                    $m->to($email, $email)->subject('Your reset link');
            });

            return redirect($this->redirectBackTo)
                ->with('response', [
                    'error'   => 0,
                    'message' => 'We\'ve sent a password reset request, look for the email we\'ve sent to <strong>' . $email . '</strong>. Check your spam folder too!'
                ]);
        }

        return redirect($this->redirectBackTo)
                ->withInput()
            ->with('response', [
                'error'   => 1,
                'message' => 'That email is invalid or doesn\'t exist in our database! Please register'
            ]);
    }

    public function resetPassword(Request $request)
    {
        $token                = $request->input('token');
        $email                = $request->input('email');
        $password             = $request->input('password');
        $passwordConfirmation = $request->input('password_confirmation');

        $data = [
            'password'              => $password,
            'password_confirmation' => $passwordConfirmation
        ];

        $passwordResetField = PasswordReset::where('email', $email)
            ->where('token', $token);

        if ($passwordResetField->count() > 0) {
            $validation = $this->validatePasswordReset($data);

            if (!$validation->fails()) {
                $passwordResetField->delete();

                $user = User::where('email', $email)
                    ->update([
                        'password' => bcrypt($password)
                    ]);
                return redirect($this->redirectBackTo)
                    ->withInput()
                    ->with('response', [
                        'error'   => 0,
                        'message' => 'The new password has been successfully set. You can now login.'
                    ]);
            }

            return redirect($this->redirectBackTo)
                ->with('response', [
                    'error'   => 1,
                    'message' => 'The passwords were invalid or they do not match.'
                ]);
        }

        return redirect($this->redirectBackTo)
            ->with('response', [
                'error'   => 1,
                'message' => 'The password reset link was invalid. Please request another to continue.'
            ]);
    }

    public function inviteUser(Request $request)
    {
        $email    = $request->input('email');
        $password = strtolower(str_random(6));

        $data = [
            'email'                 => $email,
            'password'              => $password,
            'password_confirmation' => $password
        ];

        $validation = $this->validator($data);

        if (!$validation->fails()) {
            if (Auth::user()->priviledge === 1) {
                if (Auth::user()->institution->users->count() <= 100) {
                    $schoolAdmin = Auth::user()->title . '. ' . Auth::user()->last_name;

                    $user = new User;

                    $user->email                  = $email;
                    $user->should_change_password = true;
                    $user->confirmed              = true;
                    $user->institution_id         = Auth::user()->institution_id;
                    $user->password               = bcrypt($password);

                    $user->save();

                    Mail::send('auth.emails.invitation', [
                            'email'       => $email,
                            'password'    => $password,
                            'schoolAdmin' => $schoolAdmin
                        ], function ($m) use ($email, $password, $schoolAdmin) {
                            $m->from('admin@paperdraft.dev', 'PaperDraft');

                            $m->to($email, $email)->subject('You\'ve been invited by an admin in your School to join PaperDraft.');
                    });

                    return response()->json([
                        'error'   => 0,
                        'message' => trans('api.user.success.store')
                    ]);
                }

                return response()->json([
                    'error'   => 1,
                    'message' => trans('api.user.failure.store.too-many-users')
                ]);
            }

            return response()->json([
                'error'   => 1,
                'message' => trans('api.user.failure.store.no-priviledge')
            ]);
        }

        return response()->json([
            'error'   => 1,
            'message' => trans('api.user.failure.store.invalid-email')
        ]);
    }

    public function forcePasswordReset(Request $request)
    {
        $response = $request->input('response');

        return view('auth.passwords.force_password_reset')
            ->with('response', $response);
    }

    public function changePassword(Request $request)
    {
        $password = $request->input('password');
        $passwordConfirmation = $request->input('password_confirmation');

        $data = [
            'password'              => $password,
            'password_confirmation' => $passwordConfirmation
        ];

        $validation = $this->validatePasswordReset($data);

        if (!$validation->fails()) {
            $user = User::where('id', Auth::id())
                ->update([
                    'should_change_password' => false,
                    'password'               => bcrypt($password)
                ]);

            Auth::attempt(['email' => Auth::user()->email, 'password' => $password]);

            return redirect('/dashboard');
        }

        return redirect('/force_password_reset')
            ->with('response', [
                'error'   => 1,
                'message' => 'There\'s a few problems with the data you supplied.',
                'fields'  => $validation->errors()
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
            'email'            => 'required|email|max:255|min:1|unique:users',
            'password'         => 'required|confirmed|min:6',
            'institution_code' => 'nullable|size:8|alpha_num|exists:institutions,institution_code'
        ]);
    }

    /**
     * Validates an array of information.
     *
     * @return Validator
     */
    protected function validateResetLink(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|min:1|exists:users'
        ]);
    }

    /**
     * Validates an array of information.
     *
     * @return Validator
     */
    protected function validatePasswordReset(array $data)
    {
        return Validator::make($data, [
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
        ]);
    }

    public function __destruct()
    {
        $request = $this->request;
        $request->flash();
    }
}
