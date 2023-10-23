<?php

namespace App\Observers;

use App\Models\Chapter;

class ChapterObserver
{
    /**
     * Handle the Chapter "created" event.
     */
    public function created(Chapter $chapter): void
    {
        $chapter->activities()->create([
            'action' => 'Chapter created',
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Chapter "updated" event.
     */
    public function updated(Chapter $chapter): void
    {
        $chapter->activities()->create([
            'action' => 'Chapter updated',
            'data' => json_encode($chapter->getOriginal()),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Chapter "deleted" event.
     */
    public function deleted(Chapter $chapter): void
    {
        $chapter->activities()->create([
            'action' => 'Chapter updated',
            'data' => $chapter->getOriginal(),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Chapter "restored" event.
     *
     * public function restored(Chapter $chapter): void
     * {
     * //
     * }
     */

    /**
     * Handle the Chapter "force deleted" event.
     *
     * public function forceDeleted(Chapter $chapter): void
     * {
     * //
     * }
     */
}
