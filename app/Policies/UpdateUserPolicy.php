<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class UpdateUserPolicy
{
    use HandlesAuthorization;

    /**
     * Allow only the user whose ID is correct
     *
     * @param \App\Models\User $user
     *
     * @return bool true|false
     */
    public function update(User $user)
    {
        if ($user->id === auth()->id()) {
            return Response::allow();
        }

        return Response::deny('403 | Unauthorized');
    }
}
