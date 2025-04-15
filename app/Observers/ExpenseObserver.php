<?php

namespace App\Observers;

use App\Models\Expense;

class ExpenseObserver
{
    public function updated(Expense $expense): void
    {
        //
    }

    /**
     * Handle the Expense "deleted" event.
     */
    public function deleted(Expense $expense): void
    {
        //
    }
}
