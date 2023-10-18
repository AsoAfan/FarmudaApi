<?php

namespace App\Observers;

use App\Models\Teller;

class TellerObserver
{
    /**
     * Handle the Teller "created" event.
     */
    public function created(Teller $teller): void
    {
        $teller->activities()->create([
            'action' => 'Teller created',
            'user_id' => auth()->id()
        ]);

    }

    /**
     * Handle the Teller "updated" event.
     */
    public function updated(Teller $teller): void
    {
        $teller->activities()->create([
            'action' => 'Teller updated',
            'data' => $teller->getOriginal(),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Teller "deleted" event.
     */
    public function deleted(Teller $teller): void
    {
        $teller->activities()->create([
            'action' => 'Teller deleted',
            'data' => $teller->getOriginal(),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Teller "restored" event.
     *
     * public function restored(Teller $teller): void
     * {
     * //
     * }
     */

    /**
     * Handle the Teller "force deleted" event.
     *
     * public function forceDeleted(Teller $teller): void
     * {
     * //
     * }
     */
}
