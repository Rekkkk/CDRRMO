<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Yajra\DataTables\DataTables;
use App\Mail\UserCredentialsMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

        if (auth()->user()->organization == "CDRRMO")
            $userAccounts = $userAccounts->whereNotIn('id', [auth()->user()->id]);
        else
            $userAccounts = $userAccounts->where('organization', 'CSWD')->whereNotIn('id', [auth()->user()->id]);

        if ($request->ajax()) {
            return DataTables::of($userAccounts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtns = '';

                    if ($row->isSuspend == 0) {
                        $suspendBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Suspend" class="py-1.5 btn-sm mr-2 suspendUserAccount">Suspend</a>';

                        if ($row->isRestrict == 0) {
                            $restrictBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Restrict" class="restrict btn-primary py-1.5 btn-sm mr-2 restrictUserAccount">Restrict</a>';
                            $actionBtns .= $restrictBtn . $suspendBtn;
                        } else {
                            $unRestrictBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Unrestrict" class="unRestrict btn-primary py-1.5 btn-sm mr-2 unRestrictUserAccount">Unrestrict</a>';
                            $actionBtns .= $unRestrictBtn . $suspendBtn;
                        }
                    } else {
                        $openAccountBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="OpenAccount" class="py-1.5 btn-sm mr-2 openUserAccount">Open Account</a>';
                        $actionBtns .= $openAccountBtn;
                    }

                    $removeBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Remove" class="py-1.5 btn-sm mr-2 removeUserAccount">Remove</a>';
                    $editBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="btn-edit py-1.5 btn-sm mr-2 editUserAccount">Edit</a>';
                    $actionBtns .= $editBtn . $removeBtn;

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
                    'organization' => $request->organization,
                    'position' => $request->position,
                    'email' => trim($request->email),
                    'password' =>  Hash::make($defaultPassword),
                    'status' =>  "Active"
                ]);

                $this->logActivity->generateLog('Creating Account Details');

                $userEmail = [
                    'email' => trim($request->email),
                    'organization' => $request->organization,
                    'position' => Str::upper($request->position),
                    'password' => $defaultPassword
                ];

                Mail::to(trim($request->email))->send(new UserCredentialsMail($userEmail));

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
                    'organization' => $request->organization,
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
                'status' => 'Restricted',
                'isRestrict' => 1
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
                'status' => 'Active',
                'isRestrict' => 0
            ]);
            $this->logActivity->generateLog('Unrestrict User Account');
            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }

    public function suspendUserAccount(Request $request, $userId)
    {

        $validatedSuspensionTime = Validator::make($request->all(), [
            'suspend' => 'required',
        ]);

        if ($validatedSuspensionTime->passes()) {
            $userAccountDetails = [
                'status' => 'Suspended',
                'isSuspend' => 1,
                'suspendTime' => $request->suspend
            ];

            try {
                User::find($userId)->update($userAccountDetails);
                $this->logActivity->generateLog('Suspending User Account');

                return response()->json(['status' => 1]);
            } catch (\Exception $e) {
                return response()->json(['status' => 0]);
            }
        }

        return response()->json(['status' => 0, 'error' => $validatedSuspensionTime->errors()->toArray()]);
    }

    public function openUserAccount($userId)
    {
        try {
            DB::table('users')->where('id', $userId)->update([
                'status' => 'Active',
                'isRestrict' => 0,
                'isSuspend' => 0,
                'suspendTime' => null
            ]);

            $this->logActivity->generateLog('Opening User Account');
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
        try {
            DB::table('users')->where('id', $userId)->delete();
            $this->logActivity->generateLog('Removing User Account');
            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }
}
