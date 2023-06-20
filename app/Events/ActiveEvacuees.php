<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActiveEvacuees implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $activeEvacuees;

    public function __construct($activeEvacuees)
    {
        $this->activeEvacuees = $activeEvacuees;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('active-evacuees'),
        ];
    }
}
