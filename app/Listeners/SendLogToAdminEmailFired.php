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
                if($this->notifyAdminFor->crud_on_albums) {
                    return true;    
                }
                break;
            case "song":
                if($this->notifyAdminFor->crud_on_songs) {
                    return true;
                }
                break;
            case "artist":
                if($this->notifyAdminFor->crud_on_artists) {
                    return true;
                }
                break;
            case "user":
                if($this->notifyAdminFor->crud_on_users) {
                    return true;
                }
                break;
            case "tag":
                if($this->notifyAdminFor->crud_on_tags) {
                    return true;
                }
                break;
        }
        return false;
    }
}
