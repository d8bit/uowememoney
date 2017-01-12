<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{

    /**
     * @test
     */
    public function viewLogin()
    {
        $this->visit('/login')
             ->see('Login');
    }

    /**
     * @test
     */
    public function checkLogin()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->see('Add expense');

    }

    /**
     * @test
     */
    public function checkRedirect()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/login')
            ->see('Add expense');

    }

    public function addExpense()
    {
        use DatabaseTransactions;
        $user = factory(App\User::class)->create();
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/addExpense')
            ->see('');
    }
}
