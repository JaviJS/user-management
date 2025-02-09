<?php

namespace App\Services;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Repositories\PersonalAccessTokens\PersonalAccessTokensRepositoryInterface;
use App\Repositories\PhotoUser\PhotoUserRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Helpers\HttpResponse;
use Carbon\Carbon;
use Exception;
use App\Traits\FileTrait;
use PDOException;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use FileTrait;
    private $userRepository;
    private $photoUserRepository;
    private $personalAccessTokensRepository;

    /**
     * Constructor de AuthService
     *
     * @param UserRepositoryInterface $userRepository
     * @param PhotoUserRepositoryInterface $photoUserRepository
     * @param PersonalAccessTokensRepositoryInterface $personalAccessTokensRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, PhotoUserRepositoryInterface $photoUserRepository, PersonalAccessTokensRepositoryInterface $personalAccessTokensRepository)
    {
        $this->userRepository = $userRepository;
        $this->photoUserRepository = $photoUserRepository;
        $this->personalAccessTokensRepository = $personalAccessTokensRepository;
    }

    /**
     * Obtener todos los usuarios
     */
    public function all()
    {
        try {
            $users = $this->userRepository->all();
            return HttpResponse::response($users, 200);
        } catch (PDOException $error) {
            return HttpResponse::response(['error' => 'Error interno', 'code' => 500], 500);
        } catch (Exception $error) {
            return HttpResponse::response(['error' => $error->getMessage(), 'code' => $error->getCode()], $error->getCode());
        }
    }

    /**
     * Crear un nuevo usuario
     *
     * @param CreateUserRequest $request
     */
    public function create(CreateUserRequest $request)
    {
        try {
            $user = $request->except(['photo_user', 'password_confirmation']);
            $user['birthday_date'] = Carbon::parse($user['birthday_date']);
            $user = $this->userRepository->create($user);
            if (!$user) {
                throw new Exception('Error al crear el usuario', 500);
            }

            // Verificar que exista una foto de usuario en el request y asi guardarla
            if ($request->has('photo_user') && $request->file('photo_user')) {
                $file = $this->file_upload('resources/photo_user/', $request->file('photo_user'));

                $file_name = explode("/", $file->url);

                $photo_user['name'] = $file_name[count($file_name) - 1];

                $photo_user['url'] = env('APP_URL_COMPLETE') . '/' . $file->url;
                $extension = explode(".", $file->url);
                $photo_user['extension'] = $extension[count($extension) - 1];
                $photo_user['original_name'] = $file->url_name;
                $photo_user['user_id'] = $user['id'];
                $photo_user = $this->photoUserRepository->create($photo_user);

                if (!$photo_user) {
                    throw new Exception('Error al crear el foto del usuario', 500);
                }
            }
            return HttpResponse::response($user, 200);
        } catch (PDOException $error) {
            return HttpResponse::response(['error' => 'Error interno', 'code' => 500], 500);
        } catch (Exception $error) {
            return HttpResponse::response(['error' => $error->getMessage(), 'code' => $error->getCode()], $error->getCode());
        }
    }

    /**
     * Actualizar un usuario existente
     *
     * @param UpdateUserRequest $request
     * @param int $id_user
     */
    public function update(UpdateUserRequest $request, $id_user)
    {
        try {
            $user_find = $this->userRepository->find($id_user);
            if (!$user_find) {
                throw new Exception('Usuario no encontrado', 404);
            }
            $user = $request->except(['photo_user']);
            $user['birthday_date'] = Carbon::parse($user['birthday_date']);
            $user = $this->userRepository->update($user, $id_user);
            if (!$user) {
                throw new Exception('Error al actualizar el usuario', 500);
            }
            if ($request->has('photo_user') && $request->file('photo_user')) {
                /**Si existe photo_user en request, eliminaremos la photo_user del servidor, agregaremos una nueva photo_user y modificaremos con los datos nuevos el photo_user*/
                $photo_user_id = $user_find['photo_user']->id;
                $photo_user = $this->photoUserRepository->find($photo_user_id);
                if (!$photo_user) {
                    throw new Exception("Foto de usuario no encontrado", 404);
                }
                $this->file_delete('resources/photo_user/', $photo_user['name']);

                $new_file = $this->file_upload('resources/photo_user/', $request->file('photo_user'));

                $file_name = explode("/", $new_file->url);

                $new_photo_user['name'] = $file_name[count($file_name) - 1];

                $new_photo_user['url'] = env('APP_URL_COMPLETE') . '/' . $new_file->url;
                $extension = explode(".", $new_file->url);
                $new_photo_user['extension'] = $extension[count($extension) - 1];
                $new_photo_user['original_name'] = $new_file->url_name;
                $new_photo_user = $this->photoUserRepository->update($new_photo_user, $photo_user_id);

                if (!$new_photo_user) {
                    throw new Exception('Error al crear foto del usuario', 500);
                }
            }
            return HttpResponse::response($user, 200);
        } catch (PDOException $error) {
            return HttpResponse::response(['error' => 'Error interno', 'code' => 500], 500);
        } catch (Exception $error) {
            return HttpResponse::response(['error' => $error->getMessage(), 'code' => $error->getCode()], $error->getCode());
        }
    }

    /**
     * Eliminar un usuario
     *
     * @param int $id_user
     */
    public function delete($id_user)
    {
        try {

            $user = $this->userRepository->find($id_user);
            if (!$user) {
                throw new Exception('Usuario no encontrado', 404);
            }

            // Eliminar foto del usuario del servidor
            $photo_user = $user['photo_user'];
            $this->file_delete('resources/photo_user/', $photo_user['name']);

            // Eliminar usuario de la bd
            $user = $this->userRepository->delete($id_user);
            if (!$user) {
                throw new Exception('Error al eliminar el usuario', 500);
            }

            // Eliminar los tokens de acceso del usuario
            $tokens = $this->personalAccessTokensRepository->findTokensUser($id_user);
            if (count($tokens) > 0) {
                $tokens_delete = $this->personalAccessTokensRepository->deleteByUser($id_user);
                if (!$tokens_delete) {
                    throw new Exception('Error al eliminar tokens', 500);
                }
            }
            $users = $this->userRepository->all();
            return HttpResponse::response($users, 200);
        } catch (PDOException $error) {
            return HttpResponse::response(['error' => 'Error interno', 'code' => 500], 500);
        } catch (Exception $error) {
            return HttpResponse::response(['error' => $error->getMessage(), 'code' => $error->getCode()], $error->getCode());
        }
    }

    /**
     * Encontrar un usuario por su ID
     *
     * @param int $id_user
     */
    public function find($id_user)
    {
        try {
            $user = $this->userRepository->find($id_user);
            if (!$user) {
                throw new Exception('Usuario no encontrado', 404);
            }
            return HttpResponse::response($user, 200);
        } catch (PDOException $error) {
            return HttpResponse::response(['error' => 'Error interno', 'code' => 500], 500);
        } catch (Exception $error) {
            return HttpResponse::response(['error' => $error->getMessage(), 'code' => $error->getCode()], $error->getCode());
        }
    }

    /**
     * Listar estados de los usuarios
     */
    public function listStatus()
    {
        try {
            $status = $this->userRepository->listStatus();
            return HttpResponse::response($status, 200);
        } catch (Exception $error) {
            return HttpResponse::response(['error' => $error->getMessage(), 'code' => $error->getCode()], $error->getCode());
        }
    }

    /**
     * Listar roles de los usuarios
     */
    public function listRoles()
    {
        try {
            $roles = $this->userRepository->listRoles();
            return HttpResponse::response($roles, 200);
        } catch (Exception $error) {
            return HttpResponse::response(['error' => $error->getMessage(), 'code' => $error->getCode()], $error->getCode());
        }
    }

    /**
     * Cambiar contraseña de un usuario
     * @param UpdateUserRequest $request
     * @param int $id_user
     */
    public function changePassword(UpdatePasswordRequest $request, $id_user)
    {
        try {
            // Buscamos usuario
            $user = $this->userRepository->find($id_user);
            if (!$user) {
                throw new Exception('Usuario no encontrado', 404);
            }

            // Validamos contraseña que viene en request con la almacenada en la base de datos
            $validatePassword = Hash::check($request->actual_password, $user->password);
            if (!$validatePassword) {
                throw new Exception('Contraseña no corresponde, no autorizado', 401);
            }

            // Encriptamos nueva contraseña
            $user_change['password'] = Hash::make($request->new_password);

            // Modificamos contraseña de usuario
            $user = $this->userRepository->update($user_change, $id_user);
            if (!$user) {
                throw new Exception('Error al actualizar contraseña', 500);
            }

            return HttpResponse::response($user, 200);
        } catch (PDOException $error) {
            return HttpResponse::response(['error' => 'Error interno', 'code' => 500], 500);
        } catch (Exception $error) {
            return HttpResponse::response(['error' => $error->getMessage(), 'code' => $error->getCode()], $error->getCode());
        }
    }
}