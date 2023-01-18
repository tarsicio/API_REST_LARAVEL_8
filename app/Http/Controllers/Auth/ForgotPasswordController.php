<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    /**
     * @OA\Post(
     * path="/api/v1/reset",
     * summary="Recovery Password",
     * description="recovery Password",
     * tags={"Recovery_Password"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Credenciales del usuario",
     *    @OA\JsonContent(
     *       required={"email"},
     *       @OA\Property(property="email", type="string", format="email", example="telecom.com.ve@gmail.com")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", 
     *                    type="string", 
     *                    example="Hemos enviado su enlace de restablecimiento de contraseña por correo electrónico!")
     *        )
     *     ),
     * @OA\Response(
     *    response=422,
     *    description="Los datos proporcionados no son válidos.",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", 
     *                    type="string", 
     *                    example="No podemos encontrar un usuario con esa dirección de correo electrónico..")
     *        )
     *     )
     * )
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return mixed
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => trans($response)
            ]);
        }
        return back()->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param Request $request
     * @param $response
     * @return mixed
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->expectsJson()) {
            return new JsonResponse([
                'message' =>  'Los datos proporcionados no son válidos.',
                'errors' => [
                    'email' => trans($response)
                ]
            ], 422);
        }
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('adminlte::auth.passwords.email');
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
