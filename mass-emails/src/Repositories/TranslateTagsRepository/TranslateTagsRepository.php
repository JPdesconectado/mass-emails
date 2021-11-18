<?php

namespace Koisystems\MassEmails\Repositories\TranslateTagsRepository;


class TranslateTagsRepository
{

  public function translateTags($message, $tags){

    if(strpos($message, "{{host_name}}") !== false)
      $message  = str_replace("{{host_name}}",              $tags["host_name"],           $message);

    if(strpos($message, "{{host_last_name}}") !== false)
      $message    = str_replace("{{host_last_name}}",       $tags["host_last_name"],      $message);

    if(strpos($message, "{{host_comercial_name}}") !== false)
      $message    = str_replace("{{host_comercial_name}}",  $tags["host_comercial_name"], $message);

    if(strpos($message, "{{host_nif}}") !== false)
      $message  = str_replace("{{host_nif}}",               $tags["host_nif"],            $message);

    if(strpos($message, "{{accommodation_name}}") !== false)
      $message  = str_replace("{{accommodation_name}}",     $tags["accommodation_name"],  $message);

    if(strpos($message, "{{accommodation_rnal}}") !== false)
      $message  = str_replace("{{accommodation_rnal}}",     $tags["accommodation_rnal"],  $message);

    return $message;

  }

}
