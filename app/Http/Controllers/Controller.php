<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\User;
use App\Expense;

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
        $expenses = Expense::all();
        $data['users'] = $users;
        $data['expenses'] = $expenses;
        return view('home', $data);
    }

    public function addExpense()
    {
        $expense = new Expense();
        $expense->name = \Request::input('name');
        $expense->amount = \Request::input('amount');
        $date = \Request::input('date');
        $date = str_replace('/', '-', $date);
        $date = date('Y-m-d', strtotime($date));
        $expense->date = $date;
        $expense->paid_by = \Request::input('paid_by');
        $expense->created_by = \Auth::user()->id;
        $expense->modified_by = \Auth::user()->id;
        try {
            $expense->save();
            return \Response::json('');
        } catch (\Exception $e) {
            return \Response::json($e->getMessage());
        }
    }

}
