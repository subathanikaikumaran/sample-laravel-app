<?php

namespace App\Listeners;

use App\Events\ClassCanceled;
use App\Jobs\NotifyClassCanceledJob;
use App\Mail\ClassCanceledMail;
use App\Notifications\ClassCanceledNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class NotifyClassCanceled
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClassCanceled $event): void
    {
       // for mail
       // $members = $event->scheduledClass->members();

       // for notification
        $members = $event->scheduledClass->members()->get();

        $className = $event->scheduledClass->classType->name;
        $classDateTime = $event->scheduledClass->date_time;

        $details = compact('className','classDateTime');

         // for mail
        // $members->each(function($user) use ($details){
        //     Mail::to($user)->send(new ClassCanceledMail($details));
        // });

        // for notification       
       // Notification::send($members, new ClassCanceledNotification($details));
        
       // disabled for the job queue
       NotifyClassCanceledJob::dispatch($members,$details);
    }
}