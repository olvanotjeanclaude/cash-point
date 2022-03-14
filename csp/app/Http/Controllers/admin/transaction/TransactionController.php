<?php

namespace App\Http\Controllers\admin\transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy("id", "desc")->get();

        return view("admin.transaction.index", compact("transactions"));
    }
}
