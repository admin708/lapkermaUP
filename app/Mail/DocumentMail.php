<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filePath, $fileName;

    public function __construct($filePath, $documentName)
    {
        $this->filePath = $filePath;
        $this->fileName = $documentName;
    }

    public function build()
    {
        return $this->view('email.document') // Create a view for your email body
            ->attach($this->filePath, [
                'as' => $this->fileName . ".docx", // Rename file in email
                'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])
            ->subject('Dokumen MoU');
    }
}
