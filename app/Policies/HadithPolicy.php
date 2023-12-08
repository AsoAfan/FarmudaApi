<?php

namespace App\Policies;

use App\Models\Hadith;
use App\Models\User;

class HadithPolicy
{
    /**
     * Determine whether thge user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Hadith $hadith): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {

        return $user->role == 'admin' || $user->role == 'editor';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Hadith $hadith): bool
    {
        return $user->role == 'admin' || $user->role == 'editor';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hadith $hadith): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Hadith $hadith): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Hadith $hadith): bool
    {
        //
    }
}
