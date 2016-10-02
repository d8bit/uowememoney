<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Expense extends Model
{
    public function paid_by()
    {
        return $this->hasOne('App\User', 'id', 'paid_by');
    }

    public static function total()
    {
        $users = User::all();
        $expenses = [];
        foreach ($users as $user) {
            $expenses[$user->name] = self::where('paid_by', '=', $user->id)->sum('amount');
        }
        unset($user);

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
        // $keys = array_keys($expenses);
        // $index = array_search($user_with_more_expenses, $keys);
        $debt = abs($total_amount/2);

        return [
            "user" => $user_with_less_expenses,
            "amount" => $debt
        ];

    }

}
