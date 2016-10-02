@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add expense</div>

                <div class="panel-body">
                    <form id="add_expense_form" action="http://localhost/uownmemoneyhoney/laravel/public/addExpense" method="post" onsubmit="return addExpense();">
                        <label for="name">Expense</label>
                        <input type="text" id="name" name="name" value="expense 1"><br />
                        <label for="amount">Amount</label>
                        <input type="text" id="amount" name="amount" value="12.5"><br />
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date"><br />
                        <label for="paid_by">Paid by</label>
                        <select id="paid_by" name="paid_by">
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select><br />
                        {{ csrf_field() }}
                        <input type="hidden" id="user_id" name="user_id" value="{{\Auth::user()->id}}">
                        <input type="submit" value="Add">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Expenses</div>

                <div id="expenses" class="panel-body">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
