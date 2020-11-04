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
use Illuminate\Auth\Events\Verified;
use App\tipo_usuario;
//use Illuminate\Support\Facades\Auth;
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
            if($user->aprobado == false) {
                return response()->json(['advertencia' => 'Usuario Administrador aun no aprobado']); 
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
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 

        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input);
        $user->aprobado = true;
        
        $tipoUsuario = tipo_usuario::find($request->id_tipo_usuario);

        if( strtolower($tipoUsuario->nombre == 'administrador') || strtolower($tipoUsuario->nombre) == 'admin') {
            $user->aprobado = false;
        }
        
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

    public function verifyUser(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->markEmailAsVerified()) {
            // event(new Verified($user));
            return response( "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Verificación de Correo</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel='stylesheet' type='text/css'>
    <link href='https://cdn.jsdelivr.net/npm/quasar@1.14.3/dist/quasar.min.css' rel='stylesheet' type='text/css'>
    <style>
        body{
            display: flex;
            min-width: 100vw;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div id='main'>
        <q-card dark class='bg-green-8 q-pa-xs q-ma-md'>
            <q-card-section class='row justify-center'>
                <svg width='124' height='116' viewBox='0 0 124 116' fill='none' xmlns='http://www.w3.org/2000/svg'>
                    <rect x='7' y='3' width='110' height='110' rx='20' fill='#0F4225'/>
                    <path d='M23.6973 70.9519C32.915 77.8573 44.6402 68.2024 56.5482 69.7313C56.5482 69.7313 53.375 84.2572 53.375 92.8407C53.375 101.424 26.7197 101.424 26.7197 92.8407C26.7197 84.2572 23.6973 70.9519 23.6973 70.9519Z' fill='#FBDEDE'/>
                    <path d='M32.177 50.1942C49.273 55.116 49.9916 50.2099 60.5198 61.1702C59.1074 72.8173 54.7359 73.5572 46.7738 79.9063C30.4986 75.1442 29.985 79.3317 18.8492 68.0214C20.4012 57.5544 23.7235 57.3295 32.177 50.1942Z' fill='#EE9E8C'/>
                    <ellipse rx='4.26675' ry='4.42984' transform='matrix(-0.195793 -0.980645 -0.983876 0.17885 94.4488 58.5607)' fill='#27AE60'/>
                    <ellipse rx='5.68899' ry='5.90645' transform='matrix(-0.195793 -0.980645 -0.983876 0.17885 88.5576 51.6825)' fill='#27AE60'/>
                    <ellipse rx='4.97787' ry='5.16815' transform='matrix(-0.195793 -0.980645 -0.983876 0.17885 96.6874 50.9275)' fill='#27AE60'/>
                    <rect width='3.64529' height='6.48543' rx='1.82264' transform='matrix(-0.796321 -0.604874 -0.635923 0.771752 91.2878 57.3194)' fill='#27AE60'/>
                    <path d='M54.2301 85.8814C51.0514 93.9064 49.462 97.9189 51.7585 99.6905C54.0551 101.462 57.7962 99.1071 65.2783 94.3968C77.0727 86.9719 90.6508 77.6619 93.0424 72.7866C97.4094 63.8846 78.686 49.4033 70.3809 55.2593C65.8298 58.4684 59.2492 73.2102 54.2301 85.8814Z' fill='#FAAA60'/>
                    <path d='M8.07545 7.52095C9.20788 3.09551 13.1953 0 17.7633 0H106.541C111.199 0 115.241 3.21633 116.286 7.75572L120.68 26.8347C122.123 33.0997 117.364 39.0789 110.935 39.0789H12.8811C6.35255 39.0789 1.57483 32.9247 3.19329 26.5999L8.07545 7.52095Z' fill='#92DCB2'/>
                    <ellipse cx='15.5' cy='30.1974' rx='12.5' ry='14.8026' fill='#92DCB2'/>
                    <ellipse cx='108.5' cy='30.1974' rx='12.5' ry='14.8026' fill='#92DCB2'/>
                    <ellipse cx='34.5' cy='30.1974' rx='12.5' ry='14.8026' fill='#92DCB2'/>
                    <ellipse cx='89.5' cy='30.1974' rx='12.5' ry='14.8026' fill='#92DCB2'/>
                    <ellipse cx='52.5' cy='30.1974' rx='12.5' ry='14.8026' fill='#92DCB2'/>
                    <ellipse cx='70.5' cy='30.1974' rx='12.5' ry='14.8026' fill='#92DCB2'/>
                    <path d='M110.419 72.2677L93.6187 65.3192C93.107 65.1085 92.5584 65 92.0044 65C91.4503 65 90.9017 65.1085 90.39 65.3192L73.59 72.2677C72.0237 72.9105 71 74.4305 71 76.1155C71 93.3565 81.0187 105.273 90.3812 109.147C91.4137 109.573 92.5775 109.573 93.61 109.147C101.109 106.046 113 95.3369 113 76.1155C113 74.4305 111.976 72.9105 110.419 72.2677ZM92.0088 103.762L92 70.6696L107.391 77.0362C107.102 90.1863 100.207 99.7144 92.0088 103.762V103.762Z' fill='#CCE6D7'/>
                    <path d='M73.5813 72.0502L90.3813 65.3096C90.893 65.1052 91.4416 65 91.9956 65C92.5497 65 93.0983 65.1052 93.61 65.3096L110.41 72.0502C111.976 72.6737 113 74.1482 113 75.7827C113 92.5077 102.981 104.068 93.6188 107.825C92.5863 108.238 91.4225 108.238 90.39 107.825C82.8913 104.818 71 94.4287 71 75.7827C71 74.1482 72.0238 72.6737 73.5813 72.0502ZM91.9912 102.602L92 70.4999L76.6088 76.6759C76.8975 89.4323 83.7925 98.6752 91.9912 102.602V102.602Z' fill='#CCE6D7'/>
                    <path d='M103.282 77.1752C100.286 74.6214 95.8287 75.0807 93.078 77.919L92.0006 79.0291L90.9233 77.919C88.1781 75.0807 83.7156 74.6214 80.7188 77.1752C77.2845 80.1064 77.1041 85.3673 80.1774 88.5445L90.7593 99.4709C91.4428 100.176 92.553 100.176 93.2366 99.4709L103.818 88.5445C106.897 85.3673 106.717 80.1064 103.282 77.1752Z' fill='#F57272'/>
                    </svg>
                    
            </q-card-section>
            <q-card-section>
                <div class='text-h5 text-center'>Se ha verificado su Correo Exitosamente</div>
            </q-card-section>
        </q-card>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/vue@^2.0.0/dist/vue.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/quasar@1.14.3/dist/quasar.umd.min.js'></script>
    
    <script>
      new Vue({
        el: '#main',
        data: function () {
          return {}
        },
        methods: {},
        // ...etc
      })
    </script>
</body>
</html>");
        }

        return response(['message' => 'Se verifico correctamente']);
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
