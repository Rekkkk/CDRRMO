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
                ->addColumn('status', function ($row) {
                    $color = match ($row->status) {
                        'Active' => 'green',
                        'Disabled' => 'red',
                        'Suspended' => 'orange'
                    };

                    return '<div class="status-container"><div class="bg-' . $color . '-600 status-content">' . $row->status . '</div></div>';
                })->addColumn('action', function ($user) {
                    if (auth()->user()->is_disable == 0) {
                        $actionBtns = '<div class="action-container"><select class="form-select">
                        <option value="" disabled selected hidden>Select Action</option>';

                        $actionBtns .= $user->is_suspend == 0 && $user->is_disable == 0
                            ? '<option value="disableAccount">Disable Account</option><option value="suspendAccount">Suspend Account</option>'
                            : ($user->is_suspend == 1 ? '<option value="openAccount">Open Account</option>' : '<option value="enableAccount">Enable Account</option>');

                        return $actionBtns .= '<option value="updateAccount">Update Account</option><option value="removeAccount">Remove Account</option></select></div>';
                    }

                    return '<span class="message-text">Currently Disabled.</span>';
                })
                ->rawColumns(['status', 'action'])
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

        if ($createAccountValidation->fails())
            return response(['status' => 'warning', 'message' => $createAccountValidation->errors()->first()]);

        $defaultPassword = Str::password(15);
        $this->user->create([
            'organization' => $request->organization,
            'position' => $request->position,
            'email' => trim($request->email),
            'password' =>  Hash::make($defaultPassword),
            'status' =>  "Active",
            'is_disable' =>  0,
            'is_suspend' =>  0
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

    public function updateAccount(Request $request, $userId)
    {
        $updateAccountValidation = Validator::make($request->all(), [
            'organization' => 'required',
            'position' => 'required',
            'email' => 'required|email|unique:user,email,' . $userId
        ]);

        if ($updateAccountValidation->fails())
            return response(['status' => 'warning', 'message' => $updateAccountValidation->errors()->first()]);

        $this->user->find($userId)->update([
            'organization' => $request->organization,
            'position' => $request->position,
            'email' => trim($request->email)
        ]);
        $this->logActivity->generateLog('Updating Account');
        return response()->json();
    }

    public function disableAccount($userId)
    {
        $this->user->find($userId)->update([
            'status' => 'Disabled',
            'is_disable' => 1
        ]);
        $this->logActivity->generateLog('Disabling Account');
        return response()->json();
    }

    public function enableAccount($userId)
    {
        $this->user->find($userId)->update([
            'status' => 'Active',
            'is_disable' => 0
        ]);
        $this->logActivity->generateLog('Enabling Account');
        return response()->json();
    }

    public function suspendAccount(Request $request, $userId)
    {
        $suspendAccountValidation = Validator::make($request->all(), [
            'suspend_time' => 'required'
        ]);

        if ($suspendAccountValidation->fails())
            return response(['status' => 'warning', 'error' => $suspendAccountValidation->errors()->first()]);

        $this->user->find($userId)->update([
            'status' => 'Suspended',
            'is_suspend' => 1,
            'suspend_time' => Carbon::parse($request->suspend_time)->format('Y-m-d H:i:s')
        ]);
        $this->logActivity->generateLog('Suspending Account');
        return response()->json();
    }

    public function openAccount($userId)
    {
        $this->user->find($userId)->update([
            'status' => 'Active',
            'is_disable' => 0,
            'is_suspend' => 0,
            'suspend_time' => null
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
        return Hash::check($request->current_password, auth()->user()->password) ? response()->json() : response(['status' => 'warning']);
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

                if ($changePasswordValidation->fails())
                    return response(['status' => 'warning', 'error' => $changePasswordValidation->errors()->toArray()]);

                $this->user->find($userId)->update([
                    'password' => Hash::make(trim($request->password))
                ]);
                $this->logActivity->generateLog('Changing Password');
                return response()->json();
            } else {
                return response(['status' => 'warning', 'message' => 'Password & Confirm pasword must be the same.']);
            }
        }

        return response(['status' => 'warning', 'message' => "Current password doesn't match."]);
    }

    public function removeAccount($userId)
    {
        $this->user->find($userId)->delete();
        $this->logActivity->generateLog('Removing Account');
        return response()->json();
    }
}
