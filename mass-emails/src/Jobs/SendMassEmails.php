<?php


namespace Koisystems\MassEmails\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Koisystems\MassEmails\Mail\MassEmail;

class SendMassEmails implements ShouldQueue
{

  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $to;
  public $subject;
  public $message;
  public $host_name;
  public $property_name;
  public $nif;
  public $rnal;

  public function __construct($to, $subject, $message, $host_name = null, $property_name = null, $nif = null, $rnal = null)
  {
    $this->to             = $to;
    $this->subject        = $subject;
    $this->message        = $message;
    $this->host_name      = $host_name;
    $this->property_name  = $property_name;
    $this->nif            = $nif;
    $this->rnal           = $rnal;
  }

  public function handle()
  {

    Mail::to($this->to)->queue(new MassEmail($this->subject, $this->message, $this->host_name, $this->property_name, $this->nif, $this->rnal));

  }


}
