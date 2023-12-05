<?php

namespace App\Observers;

use App\Models\Hadith;

class HadithObserver
{
    /**
     * Handle the Hadis "created" event.
     */
    public function created(Hadith $hadis): void
    {

        $hadis->activity()->create([
            'action' => 'Hadis Created',
            'user_id' => auth()->id()
        ]);

    }

    /**
     * Handle the Hadis "updated" event.
     */
    public function updated(Hadith $hadis): void
    {
        $hadis->activity()->create([
            'action' => 'Hadis Updated',
            'data' => json_encode($hadis->getOriginal()),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Hadis "deleted" event.
     */
    public function deleted(Hadith $hadis): void
    {
        $hadis->activity()->create([
            'action' => 'Hadis deleted',
            'data' => json_encode($hadis->getOriginal()),
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
