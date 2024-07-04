<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Repositories\PersonalAccessTokens\PersonalAccessTokensRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Helpers\HttpResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use DomainException;
use PDOException;
use Exception;

class AuthService
{
    private $jwtSecret;
    private $userRepository;
    private $personalAccessTokensRepository;

    /**
     * Constructor de AuthService
     *
     * @param UserRepositoryInterface $userRepository
     * @param PersonalAccessTokensRepositoryInterface $personalAccessTokensRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, PersonalAccessTokensRepositoryInterface $personalAccessTokensRepository)
    {
        $this->userRepository = $userRepository;
        $this->personalAccessTokensRepository = $personalAccessTokensRepository;
        $this->jwtSecret = env('JWT_SECRET');
    }

    /**
     * Método para iniciar sesión
     *
     * @param LoginRequest $request
     */
    public function logIn(LoginRequest $request)
    {
        try {

            //Obtener las credenciales del request
            $credentials = $request->only(['email', 'password']);

            // Buscar al usuario por el email
            $user = $this->userRepository->findByEmail($credentials['email']);
            if (!$user) {
                throw new Exception('Usuario no encontrado', 400);
            }

            // Verifica el estado del usuario
            if ($user['status'] == 'Inactivo') {
                throw new Exception('No autorizado', 401);
            }

            // Compara la contraseña ingresada con la almacenada
            $comparate_password = Hash::check($credentials['password'], $user['password']);
            if (!$comparate_password) {
                throw new Exception('Credenciales incorrectas, no autorizado', 401);
            }

            $token = bin2hex(random_bytes(32));

            // Genera el token de acceso para el usuario
            $accessTokenId = $user->tokens()->create([
                'name' => 'api-token',
                'token' => Hash('sha256', $token),
                'abilities' => ['*'],
                'expires_at' => Carbon::now()->addMinutes(60)->timestamp
            ]);

            // Prepara el payload para el JWT
            $payload = [
                'iss' => 'laravel-jwt',
                'sub' => $user->id,
                'iat' => time(),
                'exp' => time() + 60 * 60,
                'jti' => $accessTokenId,
            ];

            // Genera el token JWT
            $token = JWT::encode($payload, $this->jwtSecret, 'HS256');

            // Prepara la respuesta
            $response = [
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer'
                ]
            ];

            return HttpResponse::response($response, 200);
        } catch (PDOException $error) {
            return HttpResponse::response(['error' => 'Error interno', 'code' => 500], 500);
        } catch (Exception $error) {
            return HttpResponse::response(['error' => $error->getMessage(), 'code' => $error->getCode()], $error->getCode());
        }
    }

    /**
     * Método para cerrar sesión
     *
     * @param Request $request
     */
    public function logOut(Request $request)
    {
        try {

            // Obtener el token actual
            $current_token = $request->bearerToken();
            if (!$current_token) {
                throw new Exception('No existe el token', 400);
            }

            // Decodifica el token JWT
            $key = new Key($this->jwtSecret, 'HS256');
            $decoded_token = JWT::decode($current_token, $key);
            $user_id = $decoded_token->sub;
            $jti = $decoded_token->jti;

            // Busca el token de acceso personal en el repositorio
            $personalAccessToken = $this->personalAccessTokensRepository->findByUserToken($jti->id, $user_id, $jti->tokenable_type);
            if (!$personalAccessToken) {
                throw new Exception('Token no encontrado', 404);
            }
            // Actualizar la fecha de expiración del token a un tiempo pasado para invalidarlo
            $token_expires['expires_at'] = Carbon::now()->subMinutes(1)->toDateTimeString();
            $personal_access_token = $this->personalAccessTokensRepository->update($token_expires, $jti->id);
            if (!$personal_access_token) {
                throw new Exception('Error al actualizar tiempo de expiración de token', 500);
            }

            // Prepara el mensaje de respuesta
            $message = [
                'message' => 'Sesión cerrada satisfactoriamente',
            ];
            return HttpResponse::response($message, 200);
        } catch (ExpiredException $e) {
            return HttpResponse::response(['error' => 'Token expirado', 'code' => 401], 401);
        } catch (SignatureInvalidException $e) {
            return HttpResponse::response(['error' => 'Firma del token inválida', 'code' => 401], 401);
        } catch (DomainException $e) {
            return HttpResponse::response(['error' => 'Token malformado', 'code' => 400], 400);
        } catch (PDOException $error) {
            return HttpResponse::response(['error' => 'Error interno', 'code' => 500], 500);
        } catch (Exception $error) {
            return HttpResponse::response(['error' => $error->getMessage(), 'code' => $error->getCode()], $error->getCode());
        }
    }
}