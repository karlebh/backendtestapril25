@component('mail::message')
    # Dear {{ $admin->name }},

    Here is a list of expenses for the past week:

    @forelse ($expenses as $expense)
        - **User**: {{ $expense->user->name }}
        - **Company**: {{ $expense->company->name }}
        - **Title**: {{ $expense->title }}
        - **Amount**: {{ number_format($expense->amount, 2) }}
        - **Category**: {{ $expense->category }}
        - **Date**: {{ $expense->created_at->format('F j, Y') }}
    @empty
        No expenses recorded this week.
    @endforelse

    @component('mail::button', ['url' => route('expenses.index')])
        View All Expenses
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
