<?php

namespace App\Observers;

use App\Models\Bill;

class BillObserver
{
    /**
     * Handle the Bill "created" event.
     */
    public function created(Bill $bill): void
    {
        //
    }

    /**
     * Handle the Bill "updated" event.
     */
    public function updated(Bill $bill): void
    {
        //
    }

    /**
     * Handle the Bill "deleted" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function deleted(Bill $bill): void
    {
        // Remover o relacionamento com as tarefas associadas
        $bill->tasks()->each(function ($task) {
            $task->update(['related_id' => null, 'related_type' => null]);
        });

        // Excluir a cobrança
        $bill->delete();
    }

    /**
     * Handle the Bill "restored" event.
     */
    public function restored(Bill $bill): void
    {
        //
    }

    /**
     * Handle the Bill "force deleted" event.
     */
    public function forceDeleted(Bill $bill): void
    {
        //
    }
}
