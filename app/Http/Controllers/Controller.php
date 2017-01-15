<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\User;
use App\Expense;

use Illuminate\Support\Facades\Log;

/**
 * Main controller
 *
 * @uses BaseController
 * @package
 * @version $id$
 * @copyright 2016
 * @author D8bit Ketepires <deibit@protonmail.com>
 * @license MIT {@link https://opensource.org/licenses/MIT}
 */
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

    /**
     * Adds a new expense for the given user
     *
     * @access public
     * @return json
     */
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
        $expense->shared = 0;
        if (\Request::has('shared')) {
            $expense->shared = 1;
        }
        $expense->created_by = \Auth::user()->id;
        $expense->modified_by = \Auth::user()->id;
        try {
            $expense->save();
            return \Response::json('');
        } catch (\Exception $e) {
            return \Response::json($e->getMessage());
        }
    }

    /**
     * Not used at the moment
     *
     * @param mixed $expense_id
     * @access public
     * @return json
     */
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

    /**
     * List the expenses from a user
     *
     * @param int $user_id
     * @access public
     * @return json
     */
    public function expenses($user_id = null)
    {
        // TODO: remove use_id = null
        $user_id = null;
        if (is_null($user_id)) {
            $expenses = Expense::with('paidBy')
                ->orderBy('date', 'desc')
                ->get();
        } else {
            $expenses = Expense::where('paid_by', '=', $user_id)
                ->with('paid_by')
                ->orderBy('date', 'desc')
                ->get();
        }
        return \Response::json($expenses);
    }

    /**
     * Delete an expense
     *
     * @param int $expense_id
     * @access public
     * @return json
     */
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

    /**
     * Delete all expenses
     *
     * @access public
     * @return json
     */
    public function deleteAllExpenses()
    {
        Expense::truncate();
        return \Response::json('');
    }

    /**
     * Get the total amount
     *
     * @access public
     * @return void
     */
    public function total()
    {
        $result = Expense::total();
        return \Response::json($result);
    }

    /**
     * Adds a message to Larvel's log
     *
     * @access public
     * @return void
     */
    public function addLog()
    {
        $message = \Request::input('message');
        Log::error($message);
    }
}
