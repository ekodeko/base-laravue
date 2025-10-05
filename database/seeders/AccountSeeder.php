<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            ['code' => '1000', 'name' => 'Cash', 'type' => 'asset', 'parent_id' => null],
            ['code' => '1010', 'name' => 'Bank Account', 'type' => 'asset', 'parent_id' => null],
            ['code' => '1020', 'name' => 'Petty Cash', 'type' => 'asset', 'parent_id' => null],
            ['code' => '2000', 'name' => 'Accounts Payable', 'type' => 'liability', 'parent_id' => null],
            ['code' => '2010', 'name' => 'Bank Loan', 'type' => 'liability', 'parent_id' => null],
            ['code' => '2020', 'name' => 'Taxes Payable', 'type' => 'liability', 'parent_id' => null],
            ['code' => '3000', 'name' => 'Owner’s Equity', 'type' => 'equity', 'parent_id' => null],
            ['code' => '3010', 'name' => 'Retained Earnings', 'type' => 'equity', 'parent_id' => null],
            ['code' => '4000', 'name' => 'Sales Revenue', 'type' => 'income', 'parent_id' => null],
            ['code' => '4010', 'name' => 'Service Revenue', 'type' => 'income', 'parent_id' => null],
            ['code' => '4020', 'name' => 'Other Income', 'type' => 'income', 'parent_id' => null],
            ['code' => '5000', 'name' => 'Cost of Goods Sold', 'type' => 'expense', 'parent_id' => null],
            ['code' => '5010', 'name' => 'Raw Materials', 'type' => 'expense', 'parent_id' => null],
            ['code' => '5020', 'name' => 'Labor Costs', 'type' => 'expense', 'parent_id' => null],
            ['code' => '6000', 'name' => 'Operating Expenses', 'type' => 'expense', 'parent_id' => null],
        ];

        $createdAccounts = [];

        foreach ($accounts as $account) {
            $uuid = (string) Str::uuid();

            $createdAccounts[$account['code']] = Account::create([
                'id' => $uuid,
                'code' => $account['code'],
                'name' => $account['name'],
                'type' => $account['type'],
                'parent_id' => $account['parent_id'],
            ]);
        }

        // Update parent_id agar pointing ke UUID sesuai parent
        Account::where('code', '1010')->update(['parent_id' => $createdAccounts['1000']->id]); // Bank Account -> Cash
        Account::where('code', '1020')->update(['parent_id' => $createdAccounts['1000']->id]); // Petty Cash -> Cash
        Account::where('code', '2010')->update(['parent_id' => $createdAccounts['2000']->id]); // Bank Loan -> Accounts Payable
        Account::where('code', '2020')->update(['parent_id' => $createdAccounts['2000']->id]); // Taxes Payable -> Accounts Payable
        Account::where('code', '3010')->update(['parent_id' => $createdAccounts['3000']->id]); // Retained Earnings -> Owner’s Equity
        Account::where('code', '4010')->update(['parent_id' => $createdAccounts['4000']->id]); // Service Revenue -> Sales Revenue
        Account::where('code', '4020')->update(['parent_id' => $createdAccounts['4000']->id]); // Other Income -> Sales Revenue
        Account::where('code', '5010')->update(['parent_id' => $createdAccounts['5000']->id]); // Raw Materials -> COGS
        Account::where('code', '5020')->update(['parent_id' => $createdAccounts['5000']->id]); // Labor Costs -> COGS
    }
}
