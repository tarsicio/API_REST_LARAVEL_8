<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyCsrfToken_CSRF
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Obtenga el token de la solicitud
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
        //getTokenFromRequest
        // Verifique que el token coincida con el almacenado en la sesión
        if ($token && $token === $request->session()->token()) {
            // Si coincide, continúe con la solicitud
            return $next($request);
        }

        // De lo contrario, devuelva una respuesta de error
        $data = [                        
            'status'       => 400,
            'input' => $request->input('_token'),
            'csrf'   => $request->header('X-CSRF-TOKEN')
        ];
        return response()->json($data,400);
        //return response('Error de token CSRF', 400);
    }
}
