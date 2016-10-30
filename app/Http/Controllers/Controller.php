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

  public function users()
  {
    $users = User::all();
    $response = [
      "error" => 0,
      "message" => $users
    ];
    return \Response::json($response);
  }

  public function addExpense()
  {
    $expense = new Expense();
    $expense->name = \Request::input('expenseName');
    $expense->amount = \Request::input('amount');
    $date = \Request::input('date');
    $date = str_replace('/', '-', $date);
    $date = date('Y-m-d', strtotime($date));
    $expense->date = $date;
    $expense->paid_by = \Request::input('paidBy');
    $expense->shared = \Request::input('shared');
    $expense->created_by = \Request::input('userId');
    $expense->modified_by = \Request::input('userId');
    try {
      $expense->save();
      $user = User::find($expense->paid_by);
      $expense->paidBy = $user;
      return \Response::json(["error" => 0, "content" => $expense]);
    } catch (\Exception $e) {
      return \Response::json(["error" => 1, "content" => $e->getMessage()]);
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
    // TODO: remove use_id = null
    $user_id = null;
    if (is_null($user_id)) {
      $expenses = Expense::with('paid_by')->get();
    } else {
      $expenses = Expense::where('paid_by', '=', $user_id)->with('paid_by')->get();
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

  public function login()
  {
    $user = \Request::get('user');
    $password = \Request::get('password');
    if (\Auth::attempt(['email' => $user, 'password' => $password], true)) {
      return \Response::json(
        [
          "error" => 0,
          "message" => [
            "user" => \Auth::user(),
            "token" => \Auth::user()->remember_token
          ]
        ]
      );
    }
    return \Response::json(["error" => 1, "message" => "Wrong user or password"]);
  }

  public function total()
  {
    $result = Expense::total();
    return \Response::json($result);
  }

}
