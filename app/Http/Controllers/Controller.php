<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Index function
     *
     * @return void
     */
    public function index()
    {
        $users = User::all();
        $data['users'] = $users;
        return view('home', $data);
    }

    public function addExpense()
    {
        echo \Request::input('expense');
    }

}
