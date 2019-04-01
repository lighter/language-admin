<?php


namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class OAuthController
 *
 * @package App\Http\Controllers\Auth
 */
class OAuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param $provider
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return
            response()->json([
                'url' => Socialite::driver($provider)->redirect()->getTargetUrl(),
            ]);
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param $provider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

//        VerifyUser::create([
//            'user_id' => $authUser->id,
//            'token'   => str_random(40),
//        ]);

//        $authUser->notify(new VerifyUserMail($authUser, $lang ?? 'en'));

//        return response()->json([
//            'data' => $authUser->toArray(),
//        ]);

        return Redirect::to("/oauth/{$provider}/{$authUser->remember_token}");
    }

    /**
     * @param $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authLogin($token)
    {
        $user = User::where('remember_token', $token)->first();

        Auth::login($user, true);

        if ($user) {
            $user->generateToken();

            return response()->json([
                'status' => true,
                'data'   => $user,
            ]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $githubUser
     *
     * @return User
     */
    private function findOrCreateUser($githubUser)
    {
        if ($authUser = User::where('github_id', $githubUser->id)->first()) {
            return $authUser;
        }

        $user = User::create([
            'name'      => $githubUser->name,
            'email'     => $githubUser->email,
            'github_id' => $githubUser->id,
            'verified'  => true,
        ]);

        return $user;
    }
}
