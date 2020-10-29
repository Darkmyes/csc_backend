<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User;
use App\VerifyUser; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
/* use Laravel\Passport\Client as OClient;
use GuzzleHttp\Client;
 */

class UserController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user();
            if($user->email_verified_at == null) {
                return response()->json(['advertencia' => 'Valide Correo Electrónico primero']); 
            }
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'id_tipo_usuario' => 'required:exists:tipo_usuarios,id',
            'nombres' => 'required',
            'apellidos' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 

        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input);
        
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 

       /*  $verifyToken = sha1(time());
        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => $verifyToken
        ]);

        $this->enviarCorreoValidacion($user, $verifyToken); */
        
        $user->sendEmailVerificationNotification();
        
        return response()->json(['success'=>$success], $this->successStatus); 
    }

    public function edit(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = Auth::user();

        $user->nombres = $request->nombres;
        $user->apellidos = $request->nombres;

        $user->save();

        return response()->json(['success'=>'ok'], $this->successStatus); 
    }

    public function cambiarPass(Request $request) { 
        $validator = Validator::make($request->all(), [
            'password' => 'required', 
            'n_password' => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $user = $request->user();
        
        $usePass = $user->password;
        if(!Hash::check($request->password, $usePass)){ 
            return response()->json(['error'=>'Contraseña Incorrecta'], 401);            
        }
        $user->password = bcrypt($request->n_password);
        $user->save();
        $user->token()->revoke();
        return response()->json(["message" => "Contraseña cambiada correctamente, Inicie sesión de Nuevamente"], 200);
        //return response()->json(["message" => $usePass], 200);
    }

    private function enviarCorreoValidacion($user, $token) {
        $url_api = url()->to('/api/validar_email');
        $url_verificacion = $url_api."/".$token;

        $message = "<body>    
                <div style='border-radius:2rem; margin:.5rem;'>
                    <h1 style ='margin: 0; text-align: center; border-radius: 2rem 2rem 0 0; padding: 1rem; background-color: #26A69A; color:white'>Verificación de Correo - Mercurio</h1>
                    <div style='border-radius: 0 0 2rem 2rem; padding: 0 1rem .5rem 1rem; border: 1px solid #26A69A;'>
                        <p style='padding-top: 0; text-align: justify;'>Felicitaciones por parte del equipo de Mercurio por haberte unido a nuestra comunidad!</p>
                        <p style='text-align: justify;'>Estimad@ ".$user->nombres.", para completar su registro debes registrar el siguiente código:</p>
            
                        <h1 style ='text-align: center; color: #26A69A;'>".$url_verificacion."</h1>
            
                        <p>
                            O mediante el siguiente link 
                            <a href='".$url_verificacion."' style ='text-decoration:none; color: #26A69A;'>
                                <b> Verificar Correo </b>
                            </a>
                        </p>
                    </div>
                </div>
            </body>";

        $to_email = $user->email;
        $subject = 'Registro Mercurio';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=UTF-8';
        $headers[] = 'From: Mercurio <service@chfc.com>';

        mail($to_email, $subject, $message, implode("\r\n", $headers));
    }

    public function verifyUser($token)
    {
        $status = '';
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified_at) {
                $verifyUser->user->verified_at = date("Y-m-d h:i:s a", time());
                $verifyUser->user->save();
                $status = "Su Correo ha sido verificado";
            } else {
                $status = "Su Correo ya estaba verificado";
            }
        } else {
            return response()->json(['error'=>'Token Inválido'], 403);
        }
        return response()->json(['error'=>$status], $this->successStatus);
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 

    public function refreshToken(Request $request) { 
        $refresh_token = $request->header('Refreshtoken');
        $oClient = OClient::where('password_client', 1)->first();
        $http = new Client;

        try {
            $response = $http->request('POST', route('passport.token'), [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refresh_token,
                    'client_id' => $oClient->id,
                    'client_secret' => $oClient->secret,
                    'scope' => '*',
                ],
            ]);
            return json_decode((string) $response->getBody(), true);
        } catch (Exception $e) {
            return response()->json("unauthorized", 401); 
        }
    }
    
    public function details() 
    { 
        $user = Auth::user();
        $nombre_tipo = DB::table('tipo_usuarios')
            ->where('id', '=' ,$user->id_tipo_usuario)
            ->select('nombre')
            ->first();
        $user->tipo = $nombre_tipo->nombre;
	$response = response()->json(['success' => $user], $this-> successStatus);
   return $response;
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function unauthorized() { 
        return response()->json("unauthorized", 401); 
    }
}

?>
