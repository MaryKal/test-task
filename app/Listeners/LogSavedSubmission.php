<?php

namespace App\Listeners;

use App\Events\SubmissionSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogSavedSubmission
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
    public function handle(SubmissionSaved $event): void
    {
        $submission = $event->submission;

        $message = sprintf('The submission with id %d was successfully saved. Author: %s (%s)',
            $submission->id,
            $submission->name,
            $submission->email);

        Log::channel('submission')->info($message);
    }
}
