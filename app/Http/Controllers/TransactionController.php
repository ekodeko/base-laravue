<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['account', 'category', 'contact'])
            ->latest('date')
            ->paginate(10);
            
        return Inertia::render('master/transactions/Index', [
            'transactions' => [
                'data' => $transactions->items(),
                'meta' => [
                    'total' => $transactions->total(),
                    'per_page' => $transactions->perPage(),
                    'current_page' => $transactions->currentPage(),
                    'last_page' => $transactions->lastPage(),
                    'path' => $transactions->path(),
                ],
                'links' => [
                    'prev' => $transactions->previousPageUrl(),
                    'next' => $transactions->nextPageUrl(),
                ]
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('master/transactions/Form', [
            'accounts' => Account::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'contacts' => Contact::orderBy('name')->get(),
            'types' => ['income', 'expense']
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'contact_id' => 'required|exists:contacts,id'
        ]);

        Transaction::create($validated);

        return redirect('/master/transactions')
            ->with('message', 'Transaction created successfully');
    }

    public function edit(Transaction $transaction)
    {
        return Inertia::render('master/transactions/Form', [
            'transaction' => $transaction,
            'accounts' => Account::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'contacts' => Contact::orderBy('name')->get(),
            'types' => ['income', 'expense']
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'contact_id' => 'required|exists:contacts,id'
        ]);

        $transaction->update($validated);

        return redirect('/master/transactions')
            ->with('message', 'Transaction updated successfully');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect('/master/transactions')
            ->with('message', 'Transaction deleted successfully');
    }
}
