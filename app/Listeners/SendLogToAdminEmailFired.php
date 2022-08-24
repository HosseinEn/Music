<?php

namespace App\Listeners;

use App\Events\SendLogToAdminEmail;
use App\Mail\LogToAdminMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendLogToAdminEmailFired
{
    private $modelName, $event, $user;
    /**
     * Handle the event.
     *
     * @param  \App\Events\SendLogToAdminEmail  $event
     * @return void
     */
    public function handle(SendLogToAdminEmail $event)
    {
        $users = User::where('id', "!=", $event->userWhoMadeChanges->id)
            ->isAdmin()
            ->get();
        foreach($users as $user) {
            $this->notifyAdminFor = $user->notifyAdmin;
            $model_operation = explode(".", $event->action);
            $this->modelName = $model_operation[0];
            $operation = $model_operation[1];
            if($this->adminApprovedToReceiveNotification()) {
                $logToAdminMailable = new LogToAdminMail($event->userWhoMadeChanges, $this->modelName, $operation);
                Mail::to($user)->queue($logToAdminMailable);
            }
        }
    }

    private function adminApprovedToReceiveNotification() {
        switch($this->modelName) {
            case "album":
                return (boolean) $this->notifyAdminFor->crud_on_albums;
                break;
            case "song":
                return (boolean) $this->notifyAdminFor->crud_on_songs;
                break;
            case "artist":
                return (boolean) $this->notifyAdminFor->crud_on_artists;
                break;
            case "user":
                return (boolean) $this->notifyAdminFor->crud_on_users;
                break;
            case "tag":
                return (boolean) $this->notifyAdminFor->crud_on_tags;
                break;
        }
    }
}
