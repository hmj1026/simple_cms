<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Log;

class LogRequestAction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($userId = $event->user_id) {
            Log::insert([
                'user_id'       => (int) $userId,
                'action'        => (string) $event->action ?? '',
                'loggable_type' => (string) $event->loggable_type ?? '',
                'loggable_id'   => (int) $event->loggable_id ?? 0,
                'ip'            => request()->ip(),
                'user_agent'    => request()->header('User-Agent'),
                'header'        => json_encode(request()->header(), JSON_UNESCAPED_UNICODE),
            ]);
        }
    }
}
