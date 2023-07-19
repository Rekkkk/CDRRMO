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
        if ($request->ajax()) {
            $userAccounts = $this->user->all();
            $userId = auth()->user()->id;

            $userAccounts = auth()->user()->organization == "CSWD" ? $userAccounts->whereNotIn('id', [$userId]) :
                $userAccounts->where('organization', 'CDRRMO')->whereNotIn('id', [$userId]);

            return DataTables::of($userAccounts)
                ->addIndexColumn()
                ->addColumn('action', function ($user) {
                    $actionBtns = '<select class="custom-select custom-select bg-blue-500 text-white actionSelect">
                            <option value="" disabled selected hidden>Select Action</option>';

                    if ($user->isSuspend == 0) {
                        if ($user->isDisable == 0) {
                            $actionBtns .= '<option value="disableAccount">Disable Account</option>';
                        } else {
                            $actionBtns .= '<option value="enableAccount">Enable Account</option>';
                        }
                        $actionBtns .= '<option value="suspendAccount">Suspend Account</option>';
                    } else {
                        $actionBtns .= '<option value="openAccount">Open Account</option>';
                    }

                    return $actionBtns .= '<option value="editAccount">Edit Account</option>' . '<option value="removeAccount">Remove Account</option>' . '</select>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('userpage.userAccount.userAccounts');
    }

    public function createAccount(Request $request)
    {
        $createAccountValidation = Validator::make($request->all(), [
            'organization' => 'required',
            'email' => 'required|email|unique:user,email',
            'position' => 'required'
        ]);

        if ($createAccountValidation->passes()) {
            $defaultPassword = Str::password(15);
            $this->user->create([
                'organization' => $request->organization,
                'position' => $request->position,
                'email' => trim($request->email),
                'password' =>  Hash::make($defaultPassword),
                'status' =>  "Active",
                'isDisable' =>  0,
                'isSuspend' =>  0
            ]);
            $this->logActivity->generateLog('Creating Account');

            // Mail::to(trim($request->email))->send(new UserCredentialsMail([
            //     'email' => trim($request->email),
            //     'organization' => $request->organization,
            //     'position' => Str::upper($request->position),
            //     'password' => $defaultPassword
            // ]));

            return response()->json();
        }

        return response(['status' => "warning", 'message' => $createAccountValidation->error()->first()]);
    }

    public function updateAccount(Request $request, $userId)
    {
        $updateAccountValidation = Validator::make($request->all(), [
            'organization' => 'required',
            'position' => 'required',
            'email' => 'required|unique:user,email,' . $userId
        ]);

        if ($updateAccountValidation->passes()) {
            $this->user->find($userId)->update([
                'organization' => $request->organization,
                'position' => $request->position,
                'email' => trim($request->email)
            ]);
            $this->logActivity->generateLog('Updating Account');

            return response()->json();
        }

        return response(['status' => "warning", 'message' => $updateAccountValidation->error()->first()]);
    }

    public function disableAccount($userId)
    {
        $this->user->find($userId)->update([
            'status' => 'Disabled',
            'isDisable' => 1
        ]);
        $this->logActivity->generateLog('Disabling Account');

        return response()->json();
    }

    public function enableAccount($userId)
    {
        $this->user->find($userId)->update([
            'status' => 'Active',
            'isDisable' => 0
        ]);
        $this->logActivity->generateLog('Enabling Account');

        return response()->json();
    }

    public function suspendAccount(Request $request, $userId)
    {
        $suspendAccountValidation = Validator::make($request->all(), [
            'suspendTime' => 'required'
        ]);

        if ($suspendAccountValidation->passes()) {
            $this->user->find($userId)->update([
                'status' => 'Suspended',
                'isSuspend' => 1,
                'suspendTime' => Carbon::parse($request->suspend)->format('Y-m-d H:i:s')
            ]);
            $this->logActivity->generateLog('Suspending Account');

            return response()->json();
        }

        return response(['status' => "warning", 'error' => $suspendAccountValidation->error()->first()]);
    }

    public function openAccount($userId)
    {
        $this->user->find($userId)->update([
            'status' => 'Active',
            'isDisable' => 0,
            'isSuspend' => 0,
            'suspendTime' => null
        ]);
        $this->logActivity->generateLog('Opening Account');

        return response()->json();
    }

    public function changePassword()
    {
        return view('userpage.userAccount.changePassword');
    }

    public function checkPassword(Request $request)
    {
        if (Hash::check($request->current_password, auth()->user()->password))
            return response()->json();
        else
            return response(['status' => "warning"]);
    }

    public function resetPassword(Request $request, $userId)
    {
        if (Hash::check($request->current_password, auth()->user()->password)) {
            if ($request->password == $request->confirmPassword) {
                $changePasswordValidation = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'password' => 'required',
                    'confirmPassword' => 'required'
                ]);


                if ($changePasswordValidation->passes()) {
                    $this->user->find($userId)->update([
                        'password' => Hash::make($request->password)
                    ]);
                    $this->logActivity->generateLog('Changing Password');

                    return response()->json();
                }

                return response(['status' => "warning", 'error' => $changePasswordValidation->errors()->toArray()]);
            } else {
                return response(['status' => "warning", 'message' => "Password & Confirm pasword must be the same."]);
            }
        }

        return response(['status' => "warning", 'message' => "Current password doesn't match."]);
    }

    public function removeAccount($userId)
    {
        $this->user->find($userId)->delete();
        $this->logActivity->generateLog('Removing Account');

        return response()->json();
    }
}
