<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\{Users};
use Config;
use App;

use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\{DB, Auth, Session, Crypt};

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }


    public function testUserName()
    {
      echo "\r\n:: For login, user name should not be empty::\r\n";
      $email = 'admin@test.com';
      if(isset($email))
      {
          $this->assertDatabaseHas('users', [
          'email' => $email
      	 ]);
         $this->assertTrue(true);
       }
       else
       {
         $this->assertTrue(false);
       }
      return $email;

    }


    public function testPassword()
    {
      echo "\r\n:: For login, password should not be empty ::\r\n";
      $password	= 'secret';
      if(isset($password))
      {
        $this->assertTrue(true);
        return $password;
      }
      else
        $this->assertTrue(false);


    }

    /**
     * @depends testUserName
     * @depends testPassword
     */
    public function testLoginCred($email, $password)
    {
      echo "\r\n:: Fetch login credentials ::\r\n";
    	$credentials=[$email,$password];
  		$val = $this->assertNotEmpty($credentials);
  		return $credentials;
    }

    /**
     * @depends testLoginCred
     */
    public function testLogin(array $credentials)
    {
      echo "\r\n:: Login success with fetched credentials ::\r\n";
      Session::start();
      $response = $this->call('POST', '/login', [
        'email' => $credentials[0],
        'password' => $credentials[1],
        '_token' => csrf_token()
      ]);
      $this->assertEquals(302, $response->getStatusCode()); // 302 redircts if login succes
      $response = $this->get('/');
      $response->assertStatus(200);// this should return successfull response 200 hence after authentication user can view the page /

    }

    public function testLoginWithEmptyEmail()
    {
        echo "\r\n:: Login failure with empty email ::\r\n";
        Session::start();
        $response = $this->call('POST', '/login', [
            'email' => '',
            'password' => 'pass',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(302, $response->getStatusCode()); //4xx occurs if there is errors
        $response = $this->get('/home');
        $response->assertStatus(302); // this should perform redirect 302 code hence the credentials is not valid

    }

    public function testLoginWithEmptyPassword()
    {
        echo "\r\n:: Login failure with empty password ::\r\n";
        Session::start();
        $response = $this->call('POST', '/login', [
            'email' => 'email',
            'password' => '',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(302, $response->getStatusCode()); //4xx occurs if there is errors
        $response = $this->get('/home');
        $response->assertStatus(302); // this should perform redirect 302 code hence the credentials is not valid

    }

    public function testLoginWithInvalidEmail()
    {
        echo "\r\n:: Login failure with invalid username ::\r\n";
        Session::start();
        $response = $this->call('POST', '/login', [
            'email' => 'admin',
            'password' => '123456',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(302, $response->getStatusCode()); //4xx occurs if there is errors
        $response = $this->get('/home');
        $response->assertStatus(302); // this should perform redirect 302 code hence the credentials is not valid

    }

    public function testLoginWithInvalidPassword()
    {
        echo "\r\n:: Login failure with invalid password ::\r\n";
        Session::start();
        $response = $this->call('POST', '/login', [
            'email' => 'admin@remotea.com',
            'password' => '1111',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(302, $response->getStatusCode()); //4xx occurs if there is errors
        $response = $this->get('/home');
        $response->assertStatus(302); // this should perform redirect 302 code hence the credentials is not valid

    }

    public function testLoginWithWrongCredentials()
    {
        echo "\r\n:: Login failure with wrong credentials ::\r\n";
        Session::start();
        $response = $this->call('POST', '/login', [
            'email' => 'badUsername@gmail.com',
            'password' => 'basPass',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(302, $response->getStatusCode()); //4xx occurs if there is errors
        $response = $this->get('/home');
        $response->assertStatus(302); // this should perform redirect 302 code hence the credentials is not valid

    }

    public function testNewUserRegistration()
    {
      echo "\r\n::Register New User ::\r\n ";
      $count = \App\User::count();
      $userInfo = [
          'name' => 'testuser'.($count+1),
          'email' => 'test'.($count+1).'@test.com',
          'password' => bcrypt('secret'),
          'remember_token'=>str_random(10),
      ];

      $data =  factory(\App\User::class, 1)->create($userInfo);
      $this->assertDatabaseHas('users', $userInfo);
    }
}
