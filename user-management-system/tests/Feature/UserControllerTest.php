<?php

namespace Tests\Feature;

use App\Models\PhotoUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
     * A basic feature test example.
     */
    public function test_crear_(): void
    {
        // Artisan::call('migrate:fresh --seed');
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
            'name' => 'yoongi1.jpg',
            'url' => env('APP_URL_COMPLETE') . '/resources/photo_user/yoongi1.jpg',
            'extension' => 'jpg',
            'original_name' => 'yoongi1.jpg',
            'user_id' => 2
        ]);
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test list roles.
     */
    public function test_listar_roles(): void
    {
        $response = $this->get('/api/v1/users/find/list-roles');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test list roles.
     */
    public function test_listar_status(): void
    {
        $response = $this->get('/api/v1/users/find/list-status');

        $response->assertStatus(200);
    }
}
