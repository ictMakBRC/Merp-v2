<?php

use App\Jobs\ProcessDispatchMails;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

function showWhenLinkActive($link)
{
    return Route::currentRouteName() == $link;
}

/**
 * Return all the active links
 *
 * @param  string  $class
 */
function isLinkActive(array $links, $class = 'active')
{
    foreach ($links as $link) {
        if (showWhenLinkActive($link)) {
            return $class;
        }
    }

    return '';
}

/**
 * Method to globalize the authentication of a user
 *
 * @param $permission - examples of permissions are f_tat, c_bsc etc
 */
function isUserAuthorized($permission)
{

    // get the user
    $user = auth()->user();

    // isAuthorized true or false
    $isAuthorized = false;

    if ($user->hasPermission($permission)) {
        $isAuthorized = true;
    }

    return $isAuthorized;
}

/**
 * If employee1 goes on leave and employee1 indicates that employee2 is their OIC(Officer in Charge - or deputy)/Supervisor
 * Then this function should return employee1 thereby indicating that  employee2 is the OIC of employee1
 *
 * @param $employee - current employee
 */
function getUsersDelegatee($employee)
{
    if ($employee->isOnLeave()) {
        return $employee;
    }

    return $employee;
}

/**
 * Send the email to the recipient or their delegated staff if they are on leave
 */
function globalSendEmail($recipient, $subject, $mailable)
{
    try {
        //check if the recipient is the employee
        if (! property_exists($recipient, 'user_type')) {
            $recipient = User::where('email', $recipient->email)->first();
        }

        //check if the user is on leave
        $recipient = getUsersDelegatee($recipient);

        //check if the recipient is on leave
        ProcessDispatchMails::dispatch($mailable, $recipient)->onQueue('emails');

    } catch (\Throwable $th) {//throw $th;
        Log::error("Global Send Mail overall failed: $subject\nrecipient not found!".$th->getMessage(), [$th]);
    }
}
