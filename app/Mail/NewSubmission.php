<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
//use Statamic\Facades\Entry;
use Statamic\Entries\Entry;

class NewSubmission extends Mailable
{
    use Queueable, SerializesModels;
    //public $entry;
    public $title;
    public $introLines;
    public $outroLines;
    public $cta_url;
    public $cta_label;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Entry $entry_en)
    {
        $this->title = 'Classifieds: New submission';

        $this->introLines = [
            "Hello,",
            "A new classified has just been submitted: " . $entry_en->title,
            "Please review it and publish/delete it in both languages.",
        ];

        $this->cta_label = 'Review classified';
        $this->cta_url = $entry_en->editUrl();

        $this->outroLines = [
            "Have a good day!"
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('emails.default')
            ->subject('APC classifieds: New submission');
    }
}
