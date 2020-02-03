<?php
namespace App\Http\Controllers;

use App\Events\LogoutUser;
use App\Http\Requests\ForgotPasswordPostRequest;
use App\Http\Requests\ResetPasswordPostRequest;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterPostRequest;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    private $user_repository;
    private $broker;

    /**
     * AuthController constructor.
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
        $this->broker = Password::broker();
    }

    /**
     * @param RegisterPostRequest $request
     * @return JsonResponse
     */
    public function register(RegisterPostRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password', 'name');
        $user = $this->user_repository->create($credentials);

        return response()->createdJson($user instanceof User);
    }

    /**
     * @param LoginPostRequest $request
     * @return JsonResponse
     */
    public function login(LoginPostRequest $request): JsonResponse
    {
        $guard = auth()->guard();
        $credentials = $request->only('email', 'password');

        if ($guard->attempt($credentials)) {
            $token = $guard->user()->api_token ?? $this->user_repository->refreshApiToken($guard->user());
            return response()->json(['success' => true, 'token' => $token]);
        }

        return response()->json(['success' => false, 'message' => 'Authentication failed!']);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        event(new LogoutUser(auth()->user()));

        return response()->json([ 'success' => true, 'message' => 'User has been logged out!']);
    }

    /**
     * @param ForgotPasswordPostRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordPostRequest $request): JsonResponse
    {
        $credentials = $request->only('email');
        $response = $this->broker->sendResetLink($credentials);

        return response()->successJson($response === Password::RESET_LINK_SENT, trans($response));
    }

    /**
     * @param ResetPasswordPostRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordPostRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        $response = $this->broker->reset(
            $credentials,
            function ($user, $password) {
                $this->user_repository->setUserPassword($user, $password);
            }
        );

        return response()->successJson($response === Password::PASSWORD_RESET, trans($response));
    }

    /**
     * @param string $token
     * @param string $email
     * @return JsonResponse
     * For preview only
     */
    public function resetPasswordShow(string $token, string $email): JsonResponse
    {
        return response()->json(['message' => 'For preview only', 'token' => $token, 'email' => $email]);
    }
}
