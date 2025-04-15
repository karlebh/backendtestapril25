<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseObserver
{
    public function updated(Expense $expense): void
    {
        $user = Auth::user();

        AuditLog::create([
            'user_id' => $user->id,
            'company_id' => $user->user->company_id,
            'action' => 'update',
            'changes' => [
                'before' => $expense->getOriginal(),
                'after' => $expense->getDirty(),
            ],
        ]);
    }

    public function deleted(Expense $expense): void
    {
        $user = Auth::user();

        AuditLog::create([
            'user_id' => $user->id,
            'company_id' => $user->user->company_id,
            'action' => 'delete',
            'changes' => [
                'before' => $expense->toArray(),
                'after' => null,
            ],
        ]);
    }
}
