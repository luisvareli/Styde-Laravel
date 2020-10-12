<?php

namespace Tests\Feature;


use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_the_users_list()
    {
        factory(User::class)->create([
            'name' => 'Marco'
        ]);

        factory(User::class)->create([
            'name' => 'Isaac',
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de Usuarios')
            ->assertSee('Marco')
            ->assertSee('Isaac');
    }

    /** @test */
    function it_shows_a_default_message_if_the_users_list_is_empty()
    {

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('No hay usuarios registrados.');
    }

    /** @test */
    function it_displays_the_users_details()
    {
        $user = factory(User::class)->create([
            'name' => 'Luis Vargas'
        ]);

        $this->get('/usuarios/'. $user->id) //usuarios/5
            ->assertStatus(200)
            ->assertSee('Luis Vargas');
    }

    /**@test */
    function it_displays_a_404_error_if_user_is_not_found(){
        $this->get('/usuarios/999')
            ->assertStatus(404)
            ->assertSee('Pagina no encontrada');

    }

    /** @test */
    function it_loads_the_new_users_page()
    {
//        $this->withoutExceptionHandling(); crea una prueba de error


        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear nuevo usuario');
    }

    /** @test */
    function it_creates_a_new_user(){

        $this->withoutExceptionHandling();

        $this->post('/usuarios/',[
            'name'=>'Luis',
            'email'=>'luis@styde.net',
            'password'=>'123'
        ])->assertRedirect('usuarios');

        $this->assertCredentials([
            'name'=>'Luis',
            'email'=>'luis@styde.net',
            'password' => '123',
        ]);

    }

    /** @test */

    function the_name_is_required(){

        $this->from('usuarios/nuevo')
            ->post('/usuarios/',[
            'name'=>'',
            'email'=>'luis@styde.net',
            'password'=>'123'
        ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

        $this->assertEquals(0, User::count());

//        $this->assertDatabaseMissing('users',[
//            'email' => 'luis@styde.net',
//        ]);
    }

}
