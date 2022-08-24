<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendLogToAdminEmail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userWhoMadeChanges, $action;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $userWhoMadeChanges, string $action)
    {
        $this->userWhoMadeChanges = $userWhoMadeChanges;
        $this->action = $action;
    }
}
