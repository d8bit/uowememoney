<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{

    use DatabaseTransactions;

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

    public function listExpense()
    {
        $user_id = 1;
        $user = App\User::find($user_id);
        $this->actingAs($user)
            ->get('expenses/'.$user_id)
            ->see($user->email);
    }

    /**
     * @test
     */
    public function addExpense()
    {
        $user = App\User::find(1);
        $data = [
            'name' => 'Sally',
            'amount' => '20',
            'date' => '2017-01-01 00:00',
            'paid_by' => '1'
        ];

        $this->actingAs($user)
            ->post('addExpense', $data)
            ->see('');

    }
}
