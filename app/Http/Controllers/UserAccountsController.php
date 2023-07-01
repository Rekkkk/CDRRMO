<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Yajra\DataTables\DataTables;
use App\Mail\UserCredentialsMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserAccountsController extends Controller
{
    private $user, $logActivity;

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
                    $actionBtns = '<select class="custom-select custom-select-sm font-bold actionSelect" data-id="' . $row->id . '">
                            <option value="">Select Action</option>';

                    if ($row->isSuspend == 0) {
                        if ($row->isRestrict == 0) {
                            $actionBtns .= '<option value="restrictAccount">Restrict</option>';
                        } else {
                            $actionBtns .= '<option value="unrestrictAccount">Unrestrict</option>';
                        }
                        $actionBtns .= '<option value="suspendAccount">Suspend</option>';
                    } else {
                        $actionBtns .= '<option value="openAccount">Open Account</option>';
                    }

                    $actionBtns .= '<option value="editAccount">Edit</option>';
                    $actionBtns .= '<option value="removeAccount">Remove</option>';
                    $actionBtns .= '</select>';

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
            'email' => 'email|unique:user,email',
        ]);

        if ($validatedAccount->passes()) {
            try {
                $defaultPassword = Str::password(15);
                $this->user->create([
                    'organization' => $request->organization,
                    'position' => $request->position,
                    'email' => trim($request->email),
                    'password' =>  Hash::make($defaultPassword),
                    'status' =>  "Active",
                    'isRestrict' =>  0,
                    'isSuspend' =>  0,
                ]);
                $this->logActivity->generateLog('Creating Account Details');

                // Mail::to(trim($request->email))->send(new UserCredentialsMail([
                //     'email' => trim($request->email),
                //     'organization' => $request->organization,
                //     'position' => Str::upper($request->position),
                //     'password' => $defaultPassword
                // ]));

                return response()->json(['status' => 1]);
            } catch (\Exception $e) {
                return response()->json(['status' => 0]);
            }
        }

        return response()->json(['status' => 0, 'error' => $validatedAccount->errors()->toArray()]);
    }

    public function updateUserAccount(Request $request, $userId)
    {
        $validatedAccount = Validator::make($request->all(), [
            'email' => 'unique:user,email,' . $userId,
        ]);

        if ($validatedAccount->passes()) {
            try {
                $this->user->find($userId)->update([
                    'organization' => $request->organization,
                    'position' => $request->position,
                    'email' => trim($request->email)
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
            $this->user->find($userId)->update([
                'status' => 'Restricted',
                'isRestrict' => 1
            ]);

            $this->logActivity->generateLog('Restricting User Account');

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }

    public function unRestrictUserAccount($userId)
    {
        try {
            $unRestrictedAccount = [
                'status' => 'Active',
                'isRestrict' => 0
            ];

            $this->user->find($userId)->update($unRestrictedAccount);
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
            try {
                $this->user->find($userId)->update([
                    'status' => 'Suspended',
                    'isSuspend' => 1,
                    'suspendTime' => Carbon::parse($request->suspend)->format('Y-m-d H:i:s')
                ]);
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
            $this->user->find($userId)->update([
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
            $this->user->find($userId)->delete();
            $this->logActivity->generateLog('Removing User Account');

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }
}
