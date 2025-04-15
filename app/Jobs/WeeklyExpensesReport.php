<?php

namespace App\Jobs;

use App\Constants\UserRole;
use App\Mail\ExpensesReport;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class WeeklyExpensesReport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::where('role', UserRole::ADMIN)->get();

        Mail::to($admins)->send(new ExpensesReport());
        //send all expense reports to admin
    }
}
