<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public function userAccounts(Request $request)
    {
        $userAccounts = $this->user->all();

        if (auth()->user()->user_role == "CDRRMO") {
            $userAccounts = $userAccounts->whereNotIn('id', [auth()->user()->id]);
        } else {
            $userAccounts = $userAccounts->where('user_role', 'CSWD')->whereNotIn('id', [auth()->user()->id]);
        }

        if ($request->ajax()) {
            return DataTables::of($userAccounts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtns = '';

                    if ($row->status == "Active") {
                        $restrictBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Restrict" class="restrict btn-primary py-1.5 btn-sm mr-2 restrictUserAccount">Restrict</a>';
                        $actionBtns .= $restrictBtn;
                    } else {
                        $unRestrictBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Unrestrict" class="unRestrict btn-primary py-1.5 btn-sm mr-2 unRestrictUserAccount">Unrestrict</a>';
                        $actionBtns .= $unRestrictBtn;
                    }
                    
                    $removeBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Remove" class="py-1.5 btn-sm mr-2 removeUserAccount">Remove</a>';
                    $editBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="bg-yellow-600 hover:bg-yellow-700 py-1.5 btn-sm mr-2 text-white editUserAccount">Edit</a>' . $removeBtn;
                    $resetPasswordBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Reset" class="bg-sky-500 hover:bg-sky-600 py-1.5 btn-sm mr-2 text-white resetPassword">Reset Password</a>';
                    $actionBtns .= $editBtn;

                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('userpage.userAccount.userAccounts', compact('userAccounts'));
    }

    public function createUserAccount(Request $request)
    {
        $validatedAccount = Validator::make($request->all(), [
            'email' => 'email|unique:users,email',
        ]);

        if ($validatedAccount->passes()) {
            try {
                $defaultPassword = Str::password(15);
                User::insert([
                    'user_role' => $request->user_role,
                    'position' => $request->position,
                    'email' => trim($request->email),
                    'password' =>  Hash::make($defaultPassword),
                    'status' =>  "Active"
                ]);

                $this->logActivity->generateLog('Creating Account Details');

                return response()->json(['status' => 1, 'password' => $defaultPassword]);
            } catch (\Exception $e) {
                return response()->json(['status' => 0]);
            }
        }

        return response()->json(['status' => 0, 'error' => $validatedAccount->errors()->toArray()]);
    }

    public function updateUserAccount(Request $request, $userId)
    {
        $validatedAccount = Validator::make($request->all(), [
            'email' => 'unique:users,email,' . $userId,
        ]);

        if ($validatedAccount->passes()) {
            try {
                DB::table('users')->where('id', $userId)->update([
                    'user_role' => $request->user_role,
                    'position' => $request->position,
                    'email' => trim($request->email),
                ]);
                $this->logActivity->generateLog('Updating Account Details');

                return response()->json(['status' => 1]);
            } catch (\Exception $e) {
                return response()->json(['status' => 0]);
            }
        }

        return response()->json(['status' => 0, 'error' => $validatedAccount->errors()->toArray()]);
    }

    public function restrictUserAccount($userId)
    {
        try {
            DB::table('users')->where('id', $userId)->update([
                'status' => 'Restricted'
            ]);
            $this->logActivity->generateLog('Restrict User Account');

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }

    public function unRestrictUserAccount($userId)
    {
        try {
            DB::table('users')->where('id', $userId)->update([
                'status' => 'Active'
            ]);
            $this->logActivity->generateLog('Unrestrict User Account');
            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }

    public function resetUserPassword(Request $request, $userId)
    {
    }

    public function removeUserAccount($userId)
    {
    }
}
