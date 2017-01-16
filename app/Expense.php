<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

/**
 * Expense
 *
 * @uses Model
 * @package
 * @version $id$
 * @copyright 2016
 * @author D8bit <deibit@protonmail.com>
 * @license MIT {@link https://opensource.org/licenses/MIT}
 */
class Expense extends Model
{
    /**
     * Sets relation between payments and users
     *
     * @access public
     * @return void
     */
    public function paidBy()
    {
        $mess = "";
        return $this->hasOne('App\User', 'id', 'paid_by');
    }


    /**
     * Calculate total expenses
     *
     * Sets who owns money to who, and the amount
     *
     * @static
     * @access public
     * @return array
     */
    public static function total()
    {
        $expenses = self::getExpensesByUser();

        $user_with_more_expenses = "";
        $user_with_less_expenses = "";
        $total_amount = "";
        foreach ($expenses as $user => $amount) {
            if ("" == $user_with_more_expenses) {
                $user_with_more_expenses = $user;
                $user_with_less_expenses = $user;
                $total_amount = $amount;
            } else {
                $total_amount -= $amount;
                if ($amount > $expenses[$user_with_more_expenses]) {
                    $user_with_more_expenses = $user;
                } else {
                    $user_with_less_expenses = $user;
                }
            }
        }
        unset($user, $amount);
        $debt = abs($total_amount/2);

        return [
            "user" => $user_with_less_expenses,
            "amount" => $debt
        ];
    }

    /**
     * Gets the amount of the expenses for each user
     *
     * @static
     * @access private
     * @return void
     */
    private static function getExpensesByUser()
    {
        $users = User::all();
        $expenses = [];
        foreach ($users as $user) {
            $expenses[$user->name] = 0;
            $user_expenses = self::where('paid_by', '=', $user->id)->get();
            foreach ($user_expenses as $expense) {
                if ($expense->shared == 1) {
                    $expenses[$user->name] += $expense->amount;
                } else {
                    $expenses[$user->name] += ($expense->amount * 2);
                }
            }
        }
        unset($user);
        return $expenses;
    }
}
