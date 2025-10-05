<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::with('parent')->paginate(10)->withQueryString();
        $accounts = AccountResource::collection($accounts);
        return Inertia::render('master/Accounts/Index', [
            'accounts' => $accounts,
        ]);
    }

    public function create()
    {
        $accounts = Account::all();
        return Inertia::render('master/Accounts/Form', [
            'accounts' => $accounts,
            'parents' => Account::all(['id','name']),
            'types' => ['asset', 'liability', 'equity', 'income', 'expense'],
        ]);
    }

    public function store(StoreAccountRequest $request)
    {
        Account::create($request->validated());
        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }

    public function edit(Account $account)
    {
        $accounts = Account::all();
        return Inertia::render('master/Accounts/Form', [
            'account' => $account,
            'accounts' => $accounts,
            'parents' => Account::all(['id','name']),
            'types' => ['asset', 'liability', 'equity', 'income', 'expense'],
        ]);
    }

    public function update(UpdateAccountRequest $request, Account $account)
    {
        $account->update($request->validated());
        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
