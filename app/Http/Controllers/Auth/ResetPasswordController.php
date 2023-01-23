<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    /**
     * @OA\Post(
     * path="/api/v1/password/reset",
     * summary="reset Password",
     * description="Reset Password",
     * tags={"Recovery_Password"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Credenciales del usuario",
     *    @OA\JsonContent(
     *       required={"email","password","password_confirmation","token"},
     *       @OA\Property(property="email", type="string", format="email", example="telecom.com.ve@gmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="123456789"),
     *       @OA\Property(property="password_confirmation", type="string", format="password", example="123456789"), 
     *       @OA\Property(property="token", type="string", format="string", example="3e21652c276e6fc2a7008505cfd1dc988622e92c39b2a90d04f8cb713657c5c3")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message",type="string",example="Clave Modificada exitosamente")
     *        )
     *     ),
     * @OA\Response(
     *    response=422,
     *    description="Los datos proporcionados no son válidos.",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", 
     *                    type="string", 
     *                    example="Error al intentar modificar la nueva Clave")
     *        )
     *     )
     * )
     */     
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => trans($response)
            ]);
        }
        return redirect($this->redirectPath())->with('status', trans($response));        
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return mixed
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        if ($request->expectsJson()) {
            return new JsonResponse(['email' => trans($response) ], 422);
        }
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('adminlte::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
