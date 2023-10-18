<?php

namespace App\Observers;

use App\Models\Hadis;

class HadisObserver
{
    /**
     * Handle the Hadis "created" event.
     */
    public function created(Hadis $hadis): void
    {

        $hadis->activity()->create([
            'action' => 'Hadis Created',
            'user_id' => auth()->id()
        ]);

    }

    /**
     * Handle the Hadis "updated" event.
     */
    public function updated(Hadis $hadis): void
    {
        $hadis->activity()->create([
            'action' => 'Hadis Updated',
            'data' => $hadis->getOriginal(),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Hadis "deleted" event.
     */
    public function deleted(Hadis $hadis): void
    {
        $hadis->activity()->create([
            'action' => 'Hadis deleted',
            'data' => $hadis->getOriginal(),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Hadis "restored" event.
     * public function restored(Hadis $hadis): void
     * {
     * //
     * }
     */
    /**
     * Handle the Hadis "force deleted" event.
     *
     * public function forceDeleted(Hadis $hadis): void
     * {
     * //
     * }
     */
}
