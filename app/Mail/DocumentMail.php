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
        $this->fileName = $documentName . '_' . date('Y-m-d_H-i-s');
    }

    public function build()
    {
        // Determine MIME type based on file extension
        $extension = pathinfo($this->filePath, PATHINFO_EXTENSION);
        $mimeType = $extension === 'pdf'
            ? 'application/pdf'
            : 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';

        return $this->view('email.document')
            ->attach($this->filePath, [
                'as' => $this->fileName . '.' . $extension,
                'mime' => $mimeType,
            ])
            ->subject('Dokumen MoU');
    }
}
