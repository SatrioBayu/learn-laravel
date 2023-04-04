<?php

namespace Tests\Feature;

use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;

class ServiceContainerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function testDependencyInjection()
    {
        # code...
        $foo = $this->app->make(User::class);
        $foo1 = $this->app->make(User::class);

        // self::assertEquals('')
        self::assertNotSame($foo, $foo1);
    }

    public function testBind()
    {
        $this->app->bind(Person::class, function ($app) {
            return new Person("Satrio", "Bayu");
        });

        $person = $this->app->make(Person::class);
        $person1 = $this->app->make(Person::class);

        self::assertEquals('Satrio', $person->firstName);
        self::assertEquals('Satrio', $person1->firstName);
        // self::assertNotNull($person);
        self::assertNotSame($person, $person1);
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function ($app) {
            return new Person("Satrio", "Bayu");
        });

        $person = $this->app->make(Person::class);
        $person1 = $this->app->make(Person::class);

        self::assertEquals('Satrio', $person->firstName);
        self::assertEquals('Satrio', $person1->firstName);
        self::assertSame($person, $person1);
    }

    public function testInstance()
    {
        $person = new Person("Satrio", "Bayu");
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals('Satrio', $person1->firstName);
        self::assertEquals('Satrio', $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testHelloService()
    {
        $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        $helloServiceIndonesia = $this->app->make(HelloService::class);

        self::assertEquals("Halo Bayu", $helloServiceIndonesia->hello("Bayu"));
    }
}
