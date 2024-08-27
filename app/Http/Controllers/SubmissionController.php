<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionRequest;
use App\Jobs\SaveSubmissionJob;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function __invoke(StoreSubmissionRequest $request)
    {
        SaveSubmissionJob::dispatch($request->validated());

        return response()->json(['message' => 'Request is successful', 'status' => 200]);
    }
}
