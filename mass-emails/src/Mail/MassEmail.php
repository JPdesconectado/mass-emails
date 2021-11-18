<?php


namespace Koisystems\MassEmails\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MassEmail extends Mailable
{
  use Queueable, SerializesModels;

  public $subject;
  public $message;

  public $name;
  public $property_name;
  public $nif_anfitriao;
  public $nr_rnal;

/**
     * Create a new message instance.
     * @return void
     */
    public function __construct($subject, $message, $name = null, $nif_anfitriao = null, $property_name = null, $nr_rnal = null)
    {
      $this->subject = $subject;
      $this->message = $message;
      $this->name = $name;
      $this->property_name = $property_name;

      $this->nif_anfitriao = $nif_anfitriao;
      $this->nr_rnal = $nr_rnal;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
      return $this->markdown('mass-emails::emails.send')->subject($this->subject);
    }

}
