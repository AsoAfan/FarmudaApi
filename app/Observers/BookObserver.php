<?php

namespace App\Observers;

use App\Models\Book;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        //
        $book->activities()->create([
            'action' => 'Book created',
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updated(Book $book): void
    {
        $book->activities()->create([
            'action' => 'Book updated',
            'data' => $book->getOriginal(),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        $book->activities()->create([
            'action' => 'Book deleted',
            'data' => $book->getOriginal(),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Book "restored" event.
     *
     * public function restored(Book $book): void
     * {
     * //
     * }
     */

    /**
     * Handle the Book "force deleted" event.
     *
     * public function forceDeleted(Book $book): void
     * {
     * //
     * }
     */
}
