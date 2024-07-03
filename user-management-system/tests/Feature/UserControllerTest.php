<?php

namespace Tests\Feature;

use App\Models\PhotoUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * A basic feature test create user.
     */
    public function test_create_user(): void
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $user = [
            'name' => 'prueba',
            'last_name' => 'dos',
            'email' => 'prueba02@gmail.com',
            'password' => 'Goal123*',
            'password_confirmation' => 'Goal123*',
            'phone' => '999999999',
            'birthday_date' => '24-02-1997',
            'role' => 'usuario',
            'status' => 'Activo',
            'photo_user' => $file
        ];
        $response = $this->postJson('/api/v1/users', $user);
        $response->assertOk();

        $response->assertJsonFragment([
            'id' => $response['id'],
            'name' => 'prueba',
            'last_name' => 'dos',
            'email' => 'prueba02@gmail.com',
            'phone' => '999999999',
            'birthday_date' => '1997-02-24T00:00:00.000000Z',
            'role' => 'usuario',
            'status' => 'Activo'
        ]);
    }

    /**
     * A basic feature test update user.
     */
    public function test_correct_update_user(): void
    {
        //Creamos a usuario y su foto de usuario
        $user = User::create(
            [
                'name' => 'prueba',
                'last_name' => 'dos',
                'email' => 'prueba01@gmail.com',
                'password' => '1234',
                'phone' => '999999999',
                'birthday_date' => '1997-02-24',
                'role' => 'usuario',
                'status' => 'Activo',
            ]
        );
        $photo_user = PhotoUser::create([
            'name' => 'yoongi11.jpg',
            'url' => env('APP_URL_COMPLETE') . '/resources/photo_user/yoongi11.jpg',
            'extension' => 'jpg',
            'original_name' => 'yoongi11.jpg',
            'user_id' => $user['id']
        ]);

        // Autenticamos a usuario creado

        $auth = [
            "email" => $user['email'],
            "password" => '1234'
        ];

        $responseLogin = $this->postJson('/api/v1/login', $auth);

        $responseLogin->assertOk();

        $authorization = $responseLogin['authorization'];

        //Creamos data que enviaremos para modificar a usuario
        $data = [
            'name' => 'prueba',
            'last_name' => 'uno',
            'email' => 'prueba02@gmail.com',
            'phone' => '999999999',
            'birthday_date' => '24-02-1997',
            'role' => 'usuario',
            'status' => 'Activo'
        ];
        $route = '/api/v1/users/update/' . $user['id'];

        //Realizamos la solicitud post con autenticación
        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $authorization['token']
        ])->postJson($route, $data);

        // Esperamos que respuesta sea un estado 200
        $response->assertOk();

        // Validamos un estracto de la salida de la respuesta
        $response->assertJsonFragment([
            'id' => $user['id'],
        ]);
    }

    /**
     * A basic feature test change password user.
     */
    public function test_correct_change_password_user(): void
    {
        //Creamos a usuario y su foto de usuario
        $user = User::create(
            [
                'name' => 'prueba',
                'last_name' => 'dos',
                'email' => 'prueba01@gmail.com',
                'password' => Hash::make('1234'),
                'phone' => '999999999',
                'birthday_date' => '1997-02-24',
                'role' => 'usuario',
                'status' => 'Activo',
            ]
        );
        $photo_user = PhotoUser::create([
            'name' => 'yoongi11.jpg',
            'url' => env('APP_URL_COMPLETE') . '/resources/photo_user/yoongi11.jpg',
            'extension' => 'jpg',
            'original_name' => 'yoongi11.jpg',
            'user_id' => $user['id']
        ]);

        // Autenticamos a usuario creado

        $auth = [
            "email" => $user['email'],
            "password" => '1234'
        ];

        $responseLogin = $this->postJson('/api/v1/login', $auth);

        $responseLogin->assertOk();

        $authorization = $responseLogin['authorization'];

        //Creamos data que enviaremos para modificar contraseña de usuario
        $data = [
            'actual_password' => '1234',
            'new_password' => 'Goals12*',
            'new_password_confirmation' => 'Goals12*'
        ];
        $route = '/api/v1/users/change-password/' . $user['id'];

        //Realizamos la solicitud post con autenticación
        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $authorization['token']
        ])->postJson($route, $data);

        // Esperamos que respuesta sea un estado 200
        $response->assertOk();

        // // Validamos un estracto de la salida de la respuesta
        $response->assertJsonFragment([
            'id' => $user['id'],
            'name' => 'prueba',
            'last_name' => 'dos',
            'email' => 'prueba01@gmail.com',
            'phone' => '999999999',
            'birthday_date' => '1997-02-24',
            'role' => 'usuario',
            'status' => 'Activo'
        ]);
    }

    /**
     * A basic feature test logout user.
     */
    public function test_correct_logout_user(): void
    {
        //Creamos a usuario y su foto de usuario
        $user = User::create(
            [
                'name' => 'prueba',
                'last_name' => 'dos',
                'email' => 'prueba01@gmail.com',
                'password' => Hash::make('1234'),
                'phone' => '999999999',
                'birthday_date' => '1997-02-24',
                'role' => 'usuario',
                'status' => 'Activo',
            ]
        );
        $photo_user = PhotoUser::create([
            'name' => 'yoongi11.jpg',
            'url' => env('APP_URL_COMPLETE') . '/resources/photo_user/yoongi11.jpg',
            'extension' => 'jpg',
            'original_name' => 'yoongi11.jpg',
            'user_id' => $user['id']
        ]);

        // Autenticamos a usuario creado

        $auth = [
            "email" => $user['email'],
            "password" => '1234'
        ];

        $responseLogin = $this->postJson('/api/v1/login', $auth);

        $responseLogin->assertOk();

        $authorization = $responseLogin['authorization'];

        //Creamos data que enviaremos para modificar contraseña de usuario

        $route = '/api/v1/logout';

        //Realizamos la solicitud post con autenticación
        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $authorization['token']
        ])->postJson($route);

        // Esperamos que respuesta sea un estado 200
        $response->assertOk();

        // // Validamos un estracto de la salida de la respuesta
        $response->assertJsonFragment([
            'message' => 'Sesión cerrada satisfactoriamente'
        ]);
    }

    /**
     * A basic feature test delete user.
     */
    public function test_correct_delete_user(): void
    {
        //Creamos a usuario y su foto de usuario
        $user = User::create(
            [
                'name' => 'prueba',
                'last_name' => 'dos',
                'email' => 'prueba01@gmail.com',
                'password' => Hash::make('1234'),
                'phone' => '999999999',
                'birthday_date' => '1997-02-24',
                'role' => 'usuario',
                'status' => 'Activo',
            ]
        );
        $photo_user = PhotoUser::create([
            'name' => 'yoongi11.jpg',
            'url' => env('APP_URL_COMPLETE') . '/resources/photo_user/yoongi11.jpg',
            'extension' => 'jpg',
            'original_name' => 'yoongi11.jpg',
            'user_id' => $user['id']
        ]);

        // Autenticamos a usuario creado

        $auth = [
            "email" => $user['email'],
            "password" => '1234'
        ];

        $responseLogin = $this->postJson('/api/v1/login', $auth);

        $responseLogin->assertOk();

        $authorization = $responseLogin['authorization'];

        //Creamos data que enviaremos para modificar contraseña de usuario

        $route = '/api/v1/users/' . $user['id'];

        //Realizamos la solicitud post con autenticación
        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $authorization['token']
        ])->deleteJson($route);

        // Esperamos que respuesta sea un estado 200
        $response->assertOk();
    }

    /**
     * A basic feature test login.
     */
    public function test_login(): void
    {
        $user = User::create(
            [
                'name' => 'prueba',
                'last_name' => 'dos',
                'email' => 'prueba01@gmail.com',
                'password' => '1234',
                'phone' => '999999999',
                'birthday_date' => '1997-02-24',
                'role' => 'usuario',
                'status' => 'Activo',
            ]
        );
        $photo_user = PhotoUser::create([
            'name' => 'yoongi11.jpg',
            'url' => env('APP_URL_COMPLETE') . '/resources/photo_user/yoongi11.jpg',
            'extension' => 'jpg',
            'original_name' => 'yoongi11.jpg',
            'user_id' => $user['id']
        ]);
        $auth = [
            "email" => $user['email'],
            "password" => '1234'
        ];

        $response = $this->postJson('/api/v1/login', $auth);

        $response->assertOk();
    }

    /**
     * A basic feature test list users.
     */
    public function test_list_users(): void
    {
        $user = User::create(
            [
                'name' => 'prueba',
                'last_name' => 'dos',
                'email' => 'prueba01@gmail.com',
                'password' => '1234',
                'phone' => '999999999',
                'birthday_date' => '1997-02-24',
                'role' => 'usuario',
                'status' => 'Activo',
            ]
        );
        $photo_user = PhotoUser::create([
            'name' => 'yoongi11.jpg',
            'url' => env('APP_URL_COMPLETE') . '/resources/photo_user/yoongi11.jpg',
            'extension' => 'jpg',
            'original_name' => 'yoongi11.jpg',
            'user_id' => $user['id']
        ]);
        $auth = [
            "email" => $user['email'],
            "password" => '1234'
        ];

        $response = $this->postJson('/api/v1/login', $auth);

        $response->assertOk();

        $authorization = $response['authorization'];
        $response2 = $this->withHeaders([
            'Authorization' => "Bearer " . $authorization['token']
        ])->getJson('/api/v1/users');

        $response2->assertOk();
    }

    /**
     * A basic feature test find users.
     */
    public function test_find_user(): void
    {
        $user = User::create(
            [
                'name' => 'prueba',
                'last_name' => 'dos',
                'email' => 'prueba01@gmail.com',
                'password' => '1234',
                'phone' => '999999999',
                'birthday_date' => '1997-02-24',
                'role' => 'usuario',
                'status' => 'Activo',
            ]
        );
        $photo_user = PhotoUser::create([
            'name' => 'yoongi11.jpg',
            'url' => env('APP_URL_COMPLETE') . '/resources/photo_user/yoongi11.jpg',
            'extension' => 'jpg',
            'original_name' => 'yoongi11.jpg',
            'user_id' => $user['id']
        ]);
        $auth = [
            "email" => $user['email'],
            "password" => '1234'
        ];

        $response = $this->postJson('/api/v1/login', $auth);

        $response->assertOk();

        $authorization = $response['authorization'];
        $response2 = $this->withHeaders([
            'Authorization' => "Bearer " . $authorization['token']
        ])->getJson('/api/v1/users/' . $user['id']);

        $response2->assertOk();


        $response2->assertJsonFragment([
            'id' => $user['id'],
            'name' => 'prueba',
            'last_name' => 'dos',
            'email' => 'prueba01@gmail.com',
            'phone' => '999999999',
            'birthday_date' => $user['birthday_date'],
            'role' => 'usuario',
            'status' => 'Activo'
        ])->assertJsonFragment(
                [
                    'id' => $photo_user['id'],
                    'name' => 'yoongi11.jpg',
                    'url' => 'http://localhost:8000/resources/photo_user/yoongi11.jpg',
                    'extension' => 'jpg',
                    'original_name' => 'yoongi11.jpg',
                    'user_id' => $user['id']
                ]
            );
    }
    /**
     * A basic feature test list roles.
     */
    public function test_list_roles(): void
    {
        $response = $this->getJson('/api/v1/users/find/list-roles');

        $response->assertOk();
    }

    /**
     * A basic feature test list roles.
     */
    public function test_list_status(): void
    {
        $response = $this->getJson('/api/v1/users/find/list-status');

        $response->assertOk();

    }

    /**
     * A basic feature test not found route.
     */
    public function test_not_found_route(): void
    {
        $response = $this->getJson('/cualquier-ruta');

        $response->assertStatus(404)->assertJson([
            'message' => 'La ruta que intentas acceder no existe.'
        ]);
    }
}
