<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LogToAdminMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $userWhoMadeChanges, $modelName, $operation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $userWhoMadeChanges, string $modelName, $operation)
    {
        $this->userWhoMadeChanges = $userWhoMadeChanges;
        $this->modelName = $modelName;
        $this->operation = $operation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject('تغییرات در وبسایت موسیقی')
        ->markdown('emails.logToAdmin', [
            "user"=>$this->userWhoMadeChanges,
            "modelName"=>$this->modelName,
            "operation"=>$this->operation
        ]);
    }
}
