<?php
/** 
 * Venezuela, Enero 2023
 * Realizado por 
 * @author Tarsicio Carrizales <telecom.com.ve@gmail.com>
 * @copyright 2023 Tarsicio Carrizales
 * @version 1.0.0
 * @since 2023-01-01
 * @license MIT
*/
namespace App\Http\Controllers\Auth;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\WelcomeUser;
use App\Notifications\RegisterConfirm;
use App\Notifications\NotificarEventos;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API_REST_LARAVEL_9",
 *      description="Registro y Control de Usuario",
 *      x={
 *          "logo": {
 *              "url": "https://avatars.githubusercontent.com/u/22429379?v=4"
 *          }
 *      },
 *      @OA\Contact(
 *          email="telecom.com.ve@gmail.com"
 *      ),
 *      @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
class RegisterController extends Controller{
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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest');
    }

/**
 * @OA\Post(
 * path="/api/v1/register",
 * summary="registrar un nuevo usuario",
 * description="Registrar con email y password",
 * tags={"Register_user"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Credenciales del usuario",
 *    @OA\JsonContent(
 *       required={"name","username" ,"email","password"},
 *       @OA\Property(property="name", type="string", format="text", example="Tarsicio Carrizales"),
 *       @OA\Property(property="username", type="string", format="text", example="tarsicio"),
 *       @OA\Property(property="email", type="string", format="email", example="telecom.com.ve@gmail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="123456789"),
 *       @OA\Property(property="terms", type="boolean", example="true"),
 *    ),
 * ),
 * @OA\Response(
 *    response=201,
 *    description="Success"
 *     ),
 * @OA\Response(
 *    response=404,
 *    description="Hubo un error",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Consulte a su Administrador")
 *        )
 *     )
 * )
 */
    protected function create(RegisterUser $request){
        $fields = [
            'name'              => $request['name'],
            'username'          => $request['username'],
            'email'             => $request['email'],
            'password'          => bcrypt($request['password']),
            'confirmation_code' => \Str::random(25),
            'init_day'          => \Carbon\Carbon::now(),
            'end_day'           => \Carbon\Carbon::now()->addMonth(6),
            'colores'           => array(
                                        'encabezado'=>'#5333ed',
                                        'menu'=>'#0B0E66',
                                        'group_button'=>'#5333ed',
                                        'back_button'=>'#5333ed',
                                        'process_button'=>'#5333ed',
                                        'create_button'=>'#5333ed',
                                        'update_button'=>'#5333ed',
                                        'edit_button'=>'#2962ff',
                                        'view_button'=>'#5333ed'
                                    ),
        ];
        if (config('auth.providers.users.field', 'email') === 'username' && isset($request['username'])) {
            $fields['username'] = $request['username'];
        }
        try{
        // Antes de Guardar preguntamos si existe enla tabla Usuario los datos entrantes.      
        $user = User::create($fields);
        $user->notify(new WelcomeUser);
        $user->notify(new RegisterConfirm);
        $notificacion = [
                'title' => trans('message.msg_notification.title'),
                'body' => trans('message.msg_notification.body')
            ]; 
        $user->notify(new NotificarEventos($notificacion));
        }catch(Exception $e){
            $dato = [
                'code'    => 404,
                'status'  => 'error',
                'dato'    => $e->getMessage(),
                'message' => 'Hubo un error de conexión, contacte al Administrador'
            ];
            return response()->json($dato,404);
        }catch(Throwable $e){
            $dato = [
                'code'    => 404,
                'status'  => 'error',
                'dato'    => $e->getMessage(),
                'message' => 'Hubo un error de conexión, contacte al Administrador'
            ];
            return response()->json($dato,404);
        }
        unset($fields['password']);
        unset($fields['confirmation_code']);
        $dato = [
            'code'    => 201,
            'status'  => 'ok',
            'dato'    => $fields,
            'message' => 'Usuario creado, verifique su correo para culminar el registro'
        ];
        return response()->json($dato,201);        
    }

/**
 * @OA\Post(
 * path="/api/v1/confirm/OlXThKTk22RP4tPD4Y19RuEUq",
 * summary="Confirmar el registro",
 * description="Confirma el registro a través del correo enviado",
 * tags={"Confirm_Register_user"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Credenciales del usuario",
 * ),
 * @OA\Response(
 *    response=201,
 *    description="Success"
 *     ),
 * @OA\Response(
 *    response=404,
 *    description="Hubo un error",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Consulte a su Administrador")
 *        )
 *     )
 * )
 */    
    public function confirm($confirmation_code){
        try{  
            $user = User::where('confirmation_code', $confirmation_code)->firstOrFail();
            $user->confirmation_code = null;
            $user->confirmed_at = now();
            $user->activo = 'ALLOW';
            $colores = $user->colores;                        
            $user->save();            
        }catch(\Throwable $e){
            $error = [
                'code'    => 404,
                'status'  => 'error',
                'dato'    => array(),
                'message' => "El código suministrado es invalido o el mismo ya venció"
            ];
            return response()->json($error,404);            
        }
        //devuelve una respuesta JSON con el token generado y el tipo de token
        //se crea token de acceso personal para el usuario
        $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
            'code'         => 201,
            'status'       => 'ok',
            'dato'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'message'      => 'Usuario confirmado correctamente'
        ];
        return response()->json($data,201);                       
    }
}