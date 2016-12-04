@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add expense</div>

                <div class="panel-body">
                    <form id="add_expense_form" action="http://localhost/uownmemoneyhoney/laravel/public/addExpense" method="post" onsubmit="return addExpense();">
                        <div class="input">
                            <label for="name">Description</label>
                            <input type="text" id="name" name="name" value=""><br />
                        </div>
                        <div class="input">
                            <label for="amount">Amount</label>
                            <input type="text" class="number"  id="amount" name="amount" value=""><br />
                        </div>
                        <div class="input">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date"><br />
                        </div>
                        <div class="input">
                            <label for="paid_by">Paid by</label>
                            <select id="paid_by" name="paid_by">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select><br />
                        </div>
                        <div class="input">
                            <label for="shared">Shared</label>
                            <input type="checkbox" id="shared" name="shared" checked><br />
                        </div>
                        {{ csrf_field() }}
                        <input type="hidden" id="user_id" name="user_id" value="{{\Auth::user()->id}}">
                        <input type="submit" value="Add new expense">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Expenses <span id="details">(view details)</span></div>
                <div id="expenses" class="panel-body hidden"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Total</div>
                <div id="total" class="panel-body"></div>
            </div>
        </div>
    </div>
</div>
@endsection
