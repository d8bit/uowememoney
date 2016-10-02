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
        $data['users'] = $users;
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

    public function editExpense($expense_id)
    {
        try {
            $expense = Expense::findOrFail($expense_id);
        } catch (\Exception $e) {
            return \Response::json($e->getMessage());
        }
        $expense->name = \Request::input('name');
        $expense->amount = \Request::input('amount');
        $date = \Request::input('date');
        $date = str_replace('/', '-', $date);
        $date = date('Y-m-d', strtotime($date));
        $expense->date = $date;
        $expense->paid_by = \Request::input('paid_by');
        $expense->modified_by = \Auth::user()->id;
        try {
            $expense->save();
            return \Response::json('');
        } catch (\Exception $e) {
            return \Response::json($e->getMessage());
        }
    }

    public function expenses($user_id = null)
    {
        if (is_null($user_id)) {
            $expenses = Expense::all();
        } else {
            $expenses = Expense::where('paid_by', '=', $user_id)->get();
        }
        return \Response::json($expenses);
    }

    public function deleteExpense($expense_id)
    {
        try {
            $expense = Expense::findOrFail($expense_id);
            $expense->delete();
            return \Response::json('');
        } catch (\Exception $e) {
            return \Response::json($e->getMessage());
        }
    }

}
