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

        $this->get("/usuarios/{$user->id}") //usuarios/5
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
            ->assertSee('Crear usuario');
    }


    /** @test */
    function it_creates_a_new_user(){


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

    }

    /** @test */

    function the_email_is_required(){


        $this->from('usuarios/nuevo')
            ->post('/usuarios/',[
                'name'=>'Luis',
                'email'=>'',
                'password'=>'123'
            ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(0, User::count());

    }

    /** @test */

    function the_email_must_be_valid(){


        $this->from('usuarios/nuevo')
            ->post('/usuarios/',[
                'name'=>'Luis',
                'email'=>'correo-no-valido',
                'password'=>'123'
            ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(0, User::count());

    }

    /** @test */

    function the_email_must_be_unique(){

        factory(User::class)->create([
            'email'=>'luis@styde.net'
        ]);


        $this->from('usuarios/nuevo')
            ->post('/usuarios/',[
                'name'=>'Luis',
                'email'=>'correo-no-valido',
                'password'=>'123'
            ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(1, User::count());

    }

    /** @test */

    function the_password_is_required(){


        $this->from('usuarios/nuevo')
            ->post('/usuarios/',[
                'name'=>'Luis',
                'email'=>'luis@styde.net',
                'password'=>''
            ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['password']);

        $this->assertEquals(0, User::count());

    }

    /** @test */

    function the_password_long_required(){


        $this->from('usuarios/nuevo')
            ->post('/usuarios/',[
                'name'=>'Luis',
                'email'=>'luis@styde.net',
                'password'=>'',min([6])
            ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['password']);

        $this->assertEquals(0, User::count());

    }

    /** @test */
    function it_loads_the_edit_user_page()

    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $this->get("/usuarios/{$user->id}/editar")
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee('Editar usuario')
            ->assertViewHas('user', function ($viewUser) use ($user){
                return $viewUser->id === $user->id;
        });
    }

    /** @test */
    function it_updates_a_user(){

        $user = factory(User::class)->create();

        $this->withoutExceptionHandling();

        $this->put("/usuarios/{$user->id}",[
            'name'=>'Luis',
            'email'=>'luis@styde.net',
            'password'=>'123'
        ])->assertRedirect("/usuarios/{$user->id}");

        $this->assertCredentials([
            'name'=>'Luis',
            'email'=>'luis@styde.net',
            'password' => '123',
        ]);
    }

        /** @test */
        function the_name_is_required_when_updating_the_user()
        {
            $user=factory(User::class)->create();

            $this->from("usuarios/{$user->id}/editar")
                ->put("usuarios/{$user->id}",[
                'name'=>'',
                'email'=>'luis@styde.net',
                'password'=>'123'
                ])
                ->assertRedirect("usuarios/{$user->id}/editar")
                ->assertSessionHasErrors(['name']);

            $this->assertDatabaseMissing('users',['email' => 'luis@styde.net']);


        }

    /** @test */

    function the_email_must_be_valid_when_updating_the_user(){

        $user=factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}",[
                'name'=>'Luis Vargas',
                'email'=>'corre-no-valido',
                'password'=>'123'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users',['name' => 'Luis Vargas']);

    }

    /** @test */

    function the_email_must_be_unique_when_updating_the_user(){

        self::markTestIncomplete();
        return;

        $user = factory(User::class)->create([
            'email'=>'luis@styde.net'
        ]);


        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name'=>'Luis',
                'email'=>'luis@styde.net',
                'password'=>'123'
            ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(1, User::count());

    }

    /** @test */

    function the_password_is_optional_when_updating_the_user(){

        $oldPassword = 'CLAVE_ANTERIOR';

        $user = factory(User::class)->create([
            'password'=>bcrypt($oldPassword)
        ]);


        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' =>'Luis',
                'email' =>'luis@styde.net',
                'password' => ''
            ])
            ->assertRedirect("usuarios/{$user->id}");

        $this->assertCredentials([
            'name'=>'Luis',
            'email'=>'luis@styde.net',
            'password'=>$oldPassword
        ]);

    }

}
