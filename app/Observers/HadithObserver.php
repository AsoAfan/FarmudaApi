<?php

namespace App\Observers;

use App\Models\Hadith;

class HadithObserver
{
    /**
     * Handle the Hadis "created" event.
     */
    public function created(Hadith $hadith): void
    {

        $hadith->activity()->create([
            'action' => 'Hadis Created',
            'data' => json_encode($hadith),
            'user_id' => auth()->id()
        ]);

    }

    /**
     * Handle the Hadis "updated" event.
     */
    public function updated(Hadith $hadith): void
    {
        $hadith->activity()->create([
            'action' => 'Hadis Updated',
            'data' => json_encode($hadith->getOriginal()),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Hadis "deleted" event.
     */
    public function deleted(Hadith $hadith): void
    {
        $hadith->activity()->create([
            'action' => 'Hadis deleted',
            'data' => json_encode($hadith->getOriginal()),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Hadis "restored" event.
     * Public function restored(Hadis $hadith): void
     * {
     * //
     * }
     */
    /**
     * Handle the Hadis "force deleted" event.
     *
     * Public function forceDeleted(Hadis $hadith): void
     * {
     * //
     * }
     */
}
