<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserAccountsController extends Controller
{
    private $logActivity, $user;

    public function __construct()
    {
        $this->user = new User;
        $this->logActivity = new ActivityUserLog;
    }
    public function userProfile()
    {
        return view('userpage.userAccount.userProfile');
    }

    public function updateUserAccount(Request $request, $userId)
    {
        $validatedAccount = Validator::make($request->all(), [
            'user_role' => 'required',
            'position' => 'required',
            'email' => 'required'
        ]);

        if ($validatedAccount->passes()) {
            try {
                DB::table('users')->where('id', $userId)->update([
                    'user_role' => Str::upper(trim($request->user_role)),
                    'position' => Str::ucfirst(trim($request->position)),
                    'email' => trim($request->email)
                ]);

                $this->logActivity->generateLog('Updating Account Details');

                return response()->json(['condition' => 1]);
            } catch (\Exception $e) {
                return response()->json(['condition' => 0]);
            }
        }

        return response()->json(['condition' => 0, 'error' => $validatedAccount->errors()->toArray()]);
    }

    public function userAccounts()
    {
        $userAccounts = $this->user->all()->whereNotIn('id', auth()->user()->id);

        return view('userpage.userAccount.userAccounts', compact('userAccounts'));
    }

    public function cswdAccounts()
    {
        return view('userpage.userAccount.userAccounts');
    }
}
