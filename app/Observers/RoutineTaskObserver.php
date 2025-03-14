<?php

namespace App\Observers;

use App\Models\Routine;
use App\Models\Task;

class RoutineTaskObserver
{
    /**
     * Handle the Routine "created" event.
     */
    public function created(Routine $routine): void
    {
        //
    }

    /**
     * Handle the Routine "updated" event.
     *
     * @param  \App\Models\Routine  $routine
     * @return void
     */


    /**
     * Handle the Routine "deleted" event.
     */
    public function deleted(Routine $routine): void
    {
        //
    }

    /**
     * Handle the Routine "restored" event.
     */
    public function restored(Routine $routine): void
    {
        //
    }

    /**
     * Handle the Routine "force deleted" event.
     */
    public function forceDeleted(Routine $routine): void
    {
        //
    }

    /**
     * Handle the Routine "attached" event.
     *
     * @param  \App\Models\Routine  $routine
     * @param  array  $taskIds
     * @return void
     */
    public function attached(Routine $routine, array $taskIds)
    {
        if ($routine->responsible_id) {
            Task::whereIn('id', $taskIds)->update(['responsible_id' => $routine->responsible_id]);
        }
    }
}
