<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $category->activities()->create([
            'action' => 'Category created',
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $category->activities()->create([
            'action' => 'Category updated',
            'data' => $category->getOriginal(),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Handle the Category "deleted" event.
     * public function deleted(Category $category): void
     * {
     * $category->activities()->create([
     * 'action' => 'Category deleted',
     * 'data' => $category->getOriginal(),
     * 'user_id' => auth()->id()
     * ]);
     * }
     */

    /**
     * Handle the Category "force deleted" event.
     * public function forceDeleted(Category $category): void
     * {
     * //
     * }
     */
}
