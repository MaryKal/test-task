<?php

namespace App\Jobs;

use App\Events\SubmissionSaved;
use App\Http\Requests\StoreSubmissionRequest;
use App\Models\Submission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SaveSubmissionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $submission = Submission::create($this->data);

            SubmissionSaved::dispatch($submission);
        }catch (\Exception $error){
            Log::channel('queue_errors')->debug($error->getMessage());
        }

    }
}
