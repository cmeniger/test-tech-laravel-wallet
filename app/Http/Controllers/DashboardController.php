<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateWalletForUser;
use Illuminate\Http\Request;

class DashboardController
{
    public function __invoke(Request $request, CreateWalletForUser $createWalletForUser)
    {
        // Check if the user has a wallet, if not, create one
        $createWalletForUser($request->user());

        $transactions = $request->user()->wallet->transactions()->with('transfer')->orderByDesc('id')->get();
        $balance = $request->user()->wallet->balance;

        return view('dashboard', compact('transactions', 'balance'));
    }
}
