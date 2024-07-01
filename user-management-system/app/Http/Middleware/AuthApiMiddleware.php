<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PersonalAccessTokens\PersonalAccessTokensRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use DomainException;
use PDOException;
use Exception;

class AuthApiMiddleware
{
    private $userRepository;
    private $personalAccessTokensRepository;
    private $jwtSecret;
    public function __construct(UserRepositoryInterface $userRepository, PersonalAccessTokensRepositoryInterface $personalAccessTokensRepository)
    {
        $this->userRepository = $userRepository;
        $this->personalAccessTokensRepository = $personalAccessTokensRepository;
        $this->jwtSecret = env('JWT_SECRET');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $current_token = $request->bearerToken();
            if (!$current_token) {
                throw new Exception('No existe el token', 400);
            }
            $key = new Key($this->jwtSecret, 'HS256');
            $decoded_token = JWT::decode($current_token, $key);
            $userId = $decoded_token->sub;
            $jti = $decoded_token->jti;
            $personalAccessToken = $this->personalAccessTokensRepository->findByUserToken($jti->id, $userId, $jti->tokenable_type);
            if (!$personalAccessToken) {
                throw new Exception('Token no encontrado', 404);
            }
            // Verificar si el token ha expirado en la base de datos
            if (Carbon::parse($personalAccessToken->expires_at)->isPast()) {
                throw new Exception('Token expirado', 401);
            }
            return $next($request);
        } catch (ExpiredException $e) {
            return response()->json(['error' => 'Token expirado', 'code' => 401], 401);
        } catch (SignatureInvalidException $e) {
            return response()->json(['error' => 'Firma del token inválida', 'code' => 401], 401);
        } catch (DomainException $e) {
            return response()->json(['error' => 'Token malformado', 'code' => 400], 400);
        } catch (PDOException $error) {
            return response()->json(['error' => 'Error interno', 'code' => 500], 500);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage(), 'code' => $error->getCode()], $error->getCode());
        }
    }
}
