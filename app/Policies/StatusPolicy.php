<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Status;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // public function destroy(User $user, Status $status)
    // {
    //     return $user->id === $status->user_id;
    // }

    //our status destroy policy, the status could be deleted only when current user is status's owner
    public function destroy(User $currentUser, Status $status)
    {
        return $currentUser->id === $status->user_id;
    }

}
