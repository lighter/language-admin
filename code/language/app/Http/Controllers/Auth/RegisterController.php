<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use App\Model\VerifyUser;
use App\Notifications\VerifyUserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

/**
 * Class RegisterController
 *
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '#/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $lang = $data['lang'] ?? 'en';

        VerifyUser::create([
            'user_id' => $user->id,
            'token'   => str_random(40),
        ]);

        $user->notify(new VerifyUserMail($user, $lang));

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed                    $user
     *
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $user->generateToken();

        return response()->json([
            'data' => $user->toArray(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyUser(Request $request)
    {
        $token = $request->get('token');
        $status = false;
        $verifyUser = VerifyUser::where('token', $token)->first();

        if (isset($verifyUser)) {
            $user = $verifyUser->user;

            if (!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
                $status = true;
            } else {
                $message = "Your e-mail is already verified. You can now login.";
                $status = true;
            }
        } else {
            $message = "Sorry your email cannot be identified.";
        }

        return response()->json(['status' => $status, 'message' => $message]);
    }
}
