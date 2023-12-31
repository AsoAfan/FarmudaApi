<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Book;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Hadith;
use App\Models\Teller;
use App\Observers\AnswerObserver;
use App\Observers\BookObserver;
use App\Observers\CategoryObserver;
use App\Observers\ChapterObserver;
use App\Observers\HadithObserver;
use App\Observers\TellerObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        Hadith::class => HadithObserver::class,
        Teller::class => TellerObserver::class,
        Category::class => CategoryObserver::class,
        Book::class => BookObserver::class,
        Chapter::class => ChapterObserver::class,
        Answer::class => AnswerObserver::class

    ];


    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
//        Hadis::observe(HadisObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
