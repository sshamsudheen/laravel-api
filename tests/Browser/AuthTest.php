<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class AuthTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testHomeExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }


    public function testVisitLogin()
    {
      $this->browse(function (Browser $browser) {
        $browser->visit('/login')
        ->assertSee('Login') ;
      });
    }

    public function testLoginWithWrongCredentials()
    {
      $this->browse(function (Browser $browser) {
        $browser->visit('/login')
        ->type('email', 'wrongemail@test.fi')
        ->type('password', 'wrongPassword')
        ->press('Login')
        ->assertPathIs('/login')
        ->assertSee('These credentials do not match our records') ;
      });
    }



    public function testLoginWithCorrectCredentials()
    {
      // create fake user
      $email    = 'testfakeuser@test.com';

      $user     = $this->createFakeUser($email);
      // end of creating fake user
      $this->browse(function (Browser $browser ) {
        $browser->visit('/login')
        ->type('email', 'testfakeuser@test.com')
        ->type('password', 'secret')
        ->press('Login')
        ->assertPathIs('/home') ;
      });

      \App\User::where('id', $user)->delete(); // delete the faker users created
    }


    public function createFakeUser($email)
    {
      // create test user
      $userdata = array (
          'name' => 'testfake',
          'email' => $email,
          'password' => bcrypt('secret'));
      $users = factory(\App\User::class)->create($userdata)->id;
      // end of creating test user
      return $users;
    }


    public function testRegisterUser()
    {
      $this->browse(function (Browser $browser) {
        $browser->driver->manage()->deleteAllCookies(); // delete previous login
        $browser->visit('/register')
        ->assertSee('Register')
        ->type('name', 'RegisterUser')
        ->type('email',str_random(45).'@email.com')
        ->type('password','secret')
        ->type('password_confirmation','secret')
        ->press('Register')
        ->pause(500)
        ->assertPathIs('/home')
        ->assertSee('Dashboard');
      });
    }

    public function testRegisterExistingUser()
    {
      $this->browse(function (Browser $browser) {
        $browser->driver->manage()->deleteAllCookies(); // delete previous login
        $browser->visit('/register')
        ->assertSee('Register')
        ->type('name', 'RegisterUser')
        ->type('email','admin@test.com')
        ->type('password','secret')
        ->type('password_confirmation','secret')
        ->press('Register')
        ->assertSee('The email has already been taken.')
        ->pause(500);
      });
    }


    public function testRegisterPassAndConfirmPassWrong()
    {
      $this->browse(function (Browser $browser) {
        $browser->driver->manage()->deleteAllCookies(); // delete previous login
        $browser->visit('/register')
        ->assertSee('Register')
        ->type('name', 'RegisterUser')
        ->type('email','testemaddail@email.com')
        ->type('password','secret')
        ->type('password_confirmation','123456')
        ->press('Register')
        ->pause(500)
        ->assertSee('The password confirmation does not match.')
        ->pause(500);
      });
    }
}
