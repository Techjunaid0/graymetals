<?php

/**
 * @Author: Muhammad Umar Hayat
 * @Date:   2019-01-09 15:12:06
 * @Last Modified by:   Muhammad Umar Hayat
 * @Last Modified time: 2019-01-09 16:16:35
 */
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Instruction;
use App\Email;

class InstructionCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The instrcution instance.
     *
     * @var Instruction
     */
    private $instruction;

    /**
     * The email instance.
     *
     * @var Email
     */
    private $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Instruction $instruction, Email $email)
    {
        $this->instruction  = $instruction;
        $this->email        = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        return $this->from('case_' . $this->instruction->id . '@gray-metals.creative-dots.com', "GrayMetals")
        return $this->from('azeem.devsleague@gmail.com', "GrayMetals")
            ->cc('docs@graymetalsltd.co.uk')
                        ->subject($this->email->subject)
                            ->view('email_templates.instruction.created', ['instruction' => $this->instruction])
                                ->text('email_templates.instruction.created_plain', ['instruction' => $this->instruction]);
    }
}
