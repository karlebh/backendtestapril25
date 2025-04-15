<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\ListExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ExpenseController extends Controller
{
    use ResponseTrait;

    public function index(ListExpenseRequest $request): JsonResponse
    {
        try {
            $requestData = $request->validated();

            $expenses = Expense::query()
                ->with('user')
                ->where('company_id', $requestData['company_id'])
                ->when($request->title, fn(Builder $query) => $query->where('title', 'like', "%{$$requestData['title']}%"))
                ->when($request->category, fn(Builder $query) => $query->where('category', 'like',  "%{$requestData['category']}%"))
                ->pagainate(20);

            return $this->successResponse('Company expenses retrieved successfully', ['expenses' => $expenses]);
        } catch (Throwable $throwable) {
            return $this->serverErrorResponse(throwable: $throwable, message: 'Server error');
        }
    }

    public function store(CreateExpenseRequest $request): JsonResponse
    {
        try {
            $requestData = $request->validated();

            $expense = Expense::create($requestData);

            if (! $expense) {
                return $this->badRequestResponse('Could not create expense');
            }

            return $this->successResponse('Expense created successfully', ['expense' => $expense]);
        } catch (\Throwable $throwable) {
            return $this->serverErrorResponse(throwable: $throwable, message: 'Server error');
        }
    }

    public function update(int $id, UpdateExpenseRequest $request): JsonResponse
    {
        try {
            $expense = Expense::find($id);

            if (! $expense) {
                return $this->badRequestResponse('Could not retrieve expense');
            }

            $expense->update();

            return $this->successResponse('Expense updated successfully', ['expense' => $expense]);
        } catch (\Throwable $throwable) {
            return $this->serverErrorResponse(throwable: $throwable, message: 'Server error');
        }
    }
    public function destroy() {}
}
