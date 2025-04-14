<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'title' => ['string'],
            'category' => ['string'],
        ]);

        $expenses = Expense::query()
            ->where('company_id', $request->user()->company_id)
            ->when($request->title, fn(Builder $query) => $query->where('title', 'like', "%{$$request->title}%"))
            ->when($request->category, fn(Builder $query) => $query->where('category', 'like',  "%{$request->category}%"))
            ->pagainate(20);

        return response()->json(['message' => '', 'expenses' => $expenses], 200);
    }

    public function store() {}
    public function update() {}
    public function destroy() {}
}
