<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Email;

class SimpleEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The email instance.
     *
     * @var Email
     */
    private $email;

    /**
     * Simple array.
     *
     * @var Headers
     */
    private $headers;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Email $email, $headers = [])
    {
        $this->email = $email;
        $this->headers = $headers;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        $chain = $this->from('case_' . $this->email->instruction_id . '@gray-metals.creative-dots.com', "GrayMetals")
        $chain = $this->from('azeem.devsleague@gmail.com', "GrayMetals")
            ->cc('docs@graymetalsltd.co.uk')
            ->subject($this->email->subject)
            ->html($this->email->body)
            ->text('email_templates.email_plain', ['body' => strip_tags($this->email->body)]);
        if ($this->email->has_attachments) {
            foreach ($this->email->emailAttachments as $attachment) {
                $chain->attach(storage_path('app/public/attachments/' . $attachment->path), [
                    'as' => $attachment->orig_filename,
                ]);
            }
        }
        if (is_array($this->headers) && count($this->headers) > 0) {
            $chain->withSwiftMessage(function ($message) {
                $message = $message->getHeaders();
                foreach ($this->headers as $key => $value) {
                    $message->addTextHeader($key, $value);
                }
            });
        }

        return $chain;
    }
}
