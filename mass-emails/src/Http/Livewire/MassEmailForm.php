<?php


namespace Koisystems\MassEmails\Http\Livewire;

use App\Models\Accommodation;
use App\Models\AccommodationSite;
use App\Models\Owner;
use App\Models\Site;
use App\Models\Template;
use App\Repositories\TemplateRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Koisystems\MassEmails\Mail\MassEmail;
use Koisystems\MassEmails\Repositories\TranslateTagsRepository\TranslateTagsRepository;
use Livewire\Component;
use Illuminate\Support\Str;
use Koisystems\MassEmails\Jobs\SendMassEmails;
use Koisystems\MassEmails\Models\EmailTransaction;
use Koisystems\MassEmails\Models\EmailTransactionItem;
use Koisystems\MassEmails\Models\SearchFilter;
use Koisystems\MassEmails\Repositories\EmailTransactionItemRepository\EmailTransactionItemRepository;
use Koisystems\MassEmails\Repositories\EmailTransactionRepository\EmailTransactionRepository;
use Koisystems\MassEmails\Repositories\GenerateFiltersRepository\GenerateFiltersRepository;
use Koisystems\MassEmails\Repositories\SearchFilterRepository\SearchFilterRepository;
use Koisystems\MassEmails\Services\EmailTransactionItemService\EmailTransactionItemService;
use Koisystems\MassEmails\Services\EmailTransactionService\EmailTransactionService;
use Koisystems\MassEmails\Services\SearchFilterService\SearchFilterService;

class MassEmailForm extends Component
{
  public $pageForm = 0;

  public $send_type;
  public $allFilters = [];

  public $use_filter = false;
  public $save_filter = false;
  public $filter_name;
  public $picked_filter;
  public $results;
  public $result_filtered;
  public $json_filter;

  public $total_properties;
  public $total_owners;
  public $selected_options = [];
  public $checked = 0;

  public $tags = [];
  public $use_template = false;
  public $selected_template;
  public $subject;
  public $message;
  public $test_email = false;
  public $email;
  public $save_template = false;
  public $template_name;

  public $recipients;
  public $scheduled  = [];

  public $transaction_code;
  public $total;

  private $submitActions = [
    0 => 'submitType',
    1 => 'submitFilter',
    2 => 'submitAddedFilters',
    3 => 'submitWrite',
    4 => 'submitRecipients',
    5 => 'submitSummary'
  ];

  public function mount()
  {

    $this->tags = [
      "{{host_name}}",
      "{{host_last_name}}",
      "{{host_comercial_name}}",
      "{{host_nif}}",
      "{{accommodation_name}}",
      "{{accommodation_rnal}}"
    ];

    $filters = new GenerateFiltersRepository();
    $this->allFilters[] = [
      "number_of_filters" => 0,
      "filters"           => $filters->GenerateAllFilters()
    ];
  }

  public function submit()
  {

    $action = $this->submitActions[$this->pageForm];
    $this->$action();
  }

  public function submitType()
  {
    $this->validate([
      "send_type" =>  "required"
    ]);

    $this->pageForm++;
  }

  public function submitFilter()
  {

    $this->temporaryFilter($this->json_filter);
    $this->results = $this->insertFilter($this->json_filter);

    $this->total_owners = count($this->results->toQuery()->select("owner_id")->groupBy('owner_id')->get());
    $this->total_properties = count($this->results);

    foreach ($this->results as $result) {
      $this->selected_options[] = true;
    }

    $this->checked = count($this->selected_options);
    $this->pageForm++;
  }

  public function submitAddedFilters()
  {

    foreach ($this->selected_options as  $idx => $selected) {

      if (!$selected)
        unset($this->results[$idx]);
    }
    $service = $this->getService();

    $filters = $service->get();

    foreach ($filters as $filter) {

      if ($filter['status'] == "draft") {
        $service->delete($filter["id"]);
      }
    }

    $this->pageForm++;
  }
  public function submitWrite()
  {
    /*
      $this->validate([
        "subject"   =>  "required|string",
        "message"   =>  "required|string"
      ]);
      */
    $this->pageForm++;
  }

  public function submitRecipients()
  {

    $this->validate([
      "recipients" =>  "required"
    ]);

    $this->scheduled = Carbon::now()->toDateTimeString();
    $this->transaction_code = (string) Str::uuid();
    $this->total = count($this->results);

    $email_transaction_service = new EmailTransactionService(new EmailTransactionRepository(new EmailTransaction()));
    $newEmailTransaction = [
      "token"   =>  $this->transaction_code,
      "user_id" =>  Auth::user()->id,
      "status"  =>  "draft"
    ];

    $email_transaction_service->insert($newEmailTransaction);
    $email_transaction = $email_transaction_service->getByToken($this->transaction_code);
    $email_transaction_item_service = new EmailTransactionItemService(new EmailTransactionItemRepository(new EmailTransactionItem()));
    $translate = new TranslateTagsRepository();
    foreach($this->results as $property){

      $tags = [
        "host_name"           =>  $property->owners->comercial_first_name,
        "host_last_name"      =>  $property->owners->comercial_last_name,
        "host_comercial_name" =>  $property->owners->comercial_name,
        "host_nif"            =>  $property->owners->nif,
        "accommodation_name"  =>  $property->title,
        "accommodation_rnal"  =>  $property->rnal_license
      ];

      $message = $translate->translateTags($this->message, $tags);

      $new_email_transaction_item = [
        "transaction_id"            =>  $email_transaction[0]["id"],
        "sent_to_host_id"           =>  ($this->send_type == "owners") ? $property->owners->id : null,
        "sent_to_accommodation_id"  =>  ($this->send_type == "properties") ? $property->id : null,
        "destination_email"         =>  ($this->recipients == "contact") ? $property->owners->comercial_email : $property->owners->reservation_email,
        "subject"                   =>  $this->subject,
        "message"                   =>  $message,
        "status"                    =>  "draft"
      ];

      $email_transaction_item_service->insert($new_email_transaction_item);
    }

    $this->pageForm++;
  }

  public function submitSummary()
  {

    $email_transaction_service = new EmailTransactionService(new EmailTransactionRepository(new EmailTransaction()));
    $email_transaction = $email_transaction_service->getByToken($this->transaction_code);
    $email_transaction_item_service = new EmailTransactionItemService(new EmailTransactionItemRepository(new EmailTransactionItem()));
    $email_transaction_item = $email_transaction_item_service->getByTransactionId($email_transaction[0]["id"]);

    foreach($email_transaction_item as $item){
      SendMassEmails::dispatch($item["destination_email"], $this->subject, $item["message"]);
      $item["status"] = "complete";
      $email_transaction_item_service->update($item["id"], $item);
    }

    $email_transaction[0]["status"] = "complete";
    $email_transaction_service->update($email_transaction[0]["id"], $email_transaction[0]);

    session()->flash('message', __('mass-emails::menu.created_successful'));
    return redirect("mass-emails");
  }

  public function cancelEmails(){
    $email_transaction_service = new EmailTransactionService(new EmailTransactionRepository(new EmailTransaction()));
    $email_transaction = $email_transaction_service->getByToken($this->transaction_code);
    $email_transaction_item_service = new EmailTransactionItemService(new EmailTransactionItemRepository(new EmailTransactionItem()));
    $email_transaction_item = $email_transaction_item_service->getByTransactionId($email_transaction[0]["id"]);

    foreach($email_transaction_item as $item){
      $email_transaction_item_service->delete($item["id"]);
    }

    $email_transaction_service->delete($email_transaction[0]["id"]);
  }

  public function changeTemplate()
  {
    if ($this->selected_template == "") {
      $this->reset('message');
      return;
    }
    $template = Template::findOrFail($this->selected_template);
    $this->message = $template->content;
  }

  public function sendTestEmail()
  {

    $this->validate([
      "subject"   =>  "required|string",
      "message"   =>  "required|string",
      "email"     =>  "required|email",
    ]);

    $translate = new TranslateTagsRepository();

    $tags = [
      "host_name"           =>  "John",
      "host_last_name"      =>  "Doe",
      "host_comercial_name" =>  "Comercial Name",
      "host_nif"            =>  "123456789",
      "accommodation_name"  =>  "Property 01",
      "accommodation_rnal"  =>  "12345"
    ];

    $message = $translate->translateTags($this->message, $tags);

    Mail::to($this->email)->send(new MassEmail($this->subject, $message, "Teste", "Property Fake"));
    session()->flash('email', __('mass-emails::menu.test_email_send_successful'));
    $this->emit('alert_remove');
  }

  public function storeTemplate()
  {

    $this->validate([
      "message"   =>  "required|string",
      "template_name" =>  "required|string",
    ]);

    $repository = new TemplateRepository;

    $data = [
      'title' => $this->template_name,
      'content' => $this->message,
      'is_active' => 1,
    ];

    $repository->create($data);
    session()->flash('template', __('mass-emails::menu.template_saved_successful'));
    $this->emit('alert_remove');
  }

  public function insertFilter($json_filters)
  {

    $search_filter = $this->getService();
    $saved_filters = $search_filter->get();
    $json_filters = isset($saved_filters[0]["meta"]) ? json_decode($saved_filters[0]["meta"], true) : $json_filters;
    $or_filter = Accommodation::select("*");
    $sites = [];
    $amenities = [];
    foreach ($json_filters as $selected_filter) {

      foreach($selected_filter as $filter){
        switch ($filter["table_name"]) {


          case "accommodations":
            $or_filter = $or_filter->orWhere($filter["values"]);
            break;

          case "amenities":
            foreach($filter["values"][2] as $amenity){
              $amenities[] = ["id", "=", $amenity];
            }

            /*
            $or_filter = $or_filter->where(function($q) use ($filter){
                $q->whereHas($filter["table_name"], function (Builder $query) use ($filter) {
                  foreach($filter["values"][2] as $amenity){
                    $query->where("id", '=', $amenity);
                  }

            });

            $or_filter = $or_filter->WhereHas($filter["table_name"], function (Builder $query) use ($filter) {
              foreach($filter["values"][2] as $amenity){
                $query->where("id", '=', $amenity);
              }
            });

            */
            $or_filter->orWhereHas("amenities", function (Builder $query) use ($amenities) {
                    $query->where($amenities);
                  });
            break;

          case "accommodation_sites":
            $column = explode("_", $filter["values"][0]);
            $sites[$column[1]] = $filter["values"][2];
            break;

          case "accommodation_calendar_feeds":
            $filter["values"][2] == 1 ? $or_filter = $or_filter->has("accommodationCalendarFeed") :  $or_filter = $or_filter->doesntHave("accommodationCalendarFeed");
            break;
        }
      }



      foreach ($sites as $id => $status) {
        foreach ($or_filter->get()  as $idx => $has_site) {

          $exist = AccommodationSite::where("site_id", $id)->where("accommodation_id", $has_site->id)->get();
          if ($exist->isEmpty()) {

          }
        }
      }
    }

    $result = $or_filter->get();

    if($this->send_type == "owners"){
      $result = $result->unique("owner_id");
    }

    $this->result_filtered = count($result);
    return $result;
  }

  public function createJsonFilter($choice_filters, $index_all_filters)
  {
    $json_filters = [];

    $numeric  = ["number_bedrooms", "rnal_number_guests", "min_nights_booking", "nr_images"];
    $signals  = [1   =>  ">", 2   =>  "=", 3   =>  "<"];
    foreach ($choice_filters as $filter) {

      if ($filter['name'] == "selected_amenities") {

        $json_filters[$index_all_filters][] = [
          "table_name"  =>  "amenities",
          "values"      =>  [ "id", $filter['signal'], $filter['value'] ]
        ];

        continue;
      }

      if (strpos($filter['name'], "site_") !== false) {
        if(empty($json_filters)){
          $json_filters[$index_all_filters][] = [

            "table_name"  =>  "accommodation_sites",

            "values"      =>  [ $filter['name'], $filter['signal'], $filter['value'] ]
          ];
        }else{
            $values = [ $filter['name'], $filter['signal'], $filter['value'] ];
            foreach($json_filters[$index_all_filters] as $idx => $json){
              if($json["table_name"] == "accommodation_sites"){
                array_push($json_filters[$index_all_filters][$idx]["values"], $values);
                break;
              }
            }
        }
        continue;
      }

      if ($filter['name'] == "ical") {
        $json_filters[$index_all_filters][] = [
          "table_name"  =>  "accommodation_calendar_feeds",

          "values"      =>  [ $filter['name'], $filter['signal'], $filter['value'] ]
        ];

        continue;
      }

      if (in_array($filter['name'], $numeric)) {
        if(empty($json_filters)){
          $json_filters[$index_all_filters][] = [

            "table_name"  =>  "accommodations",
            "values"      =>  [ [ $filter['name'], $signals[$filter['signal']], $filter['value']] ]
          ];
        }else{

          $values  =  [ $filter['name'], $signals[$filter['signal']], $filter['value']];
          foreach($json_filters[$index_all_filters] as $idx => $json){
            if($json["table_name"] == "accommodations"){
              array_push($json_filters[$index_all_filters][$idx]["values"], $values);
              break;
            }
          }
        }
        continue;
      }

      if(empty($json_filters)){
        $json_filters[$index_all_filters][] = [

          "table_name"  =>  "accommodations",
          "values"      =>  [ [$filter['name'], $filter['signal'], $filter['value']] ]
        ];

      }else{
        $values = [$filter['name'], $filter['signal'], $filter['value']];

        foreach($json_filters[$index_all_filters] as $idx => $json){
          if($json["table_name"] == "accommodations"){
            array_push($json_filters[$index_all_filters][$idx]["values"], $values);
            break;
          }
        }
      }

    }

    $this->result = $this->insertFilter($json_filters);

    return $json_filters;
  }

  public function storeFilter($index)
  {
    $this->createTemporaryFilter($index);
    $search_filter = $this->getService();
    $saved_filters = $search_filter->get();

    $data = [
      "user_id"     =>  Auth::user()->id,
      "name"        =>  $this->filter_name,
      "meta"        =>  $saved_filters[0]["meta"],
      "meta_filter" =>  json_encode($this->allFilters),
      "status"      =>  "saved"
    ];

    $search_filter = $this->getService();
    $search_filter->delete($saved_filters[0]["id"]);
    $search_filter->insert($data);

    session()->flash('filter', __('mass-emails::menu.filter_saved_successful'));
    $this->emit('alert_remove');
  }

  public function temporaryFilter($json_filters)
  {

    $search_filter = $this->getService();

    $saved_filters = $search_filter->get();

    $data = [
      "user_id" =>  Auth::user()->id,
      "meta"    =>  (empty($saved_filters)) ? json_encode($json_filters) : array_merge(json_decode($saved_filters[0]["meta"], true), $json_filters),
      "status"  =>  "draft"
    ];

    if(!empty($saved_filters)){
      $search_filter->update($saved_filters[0]["id"], $data);
      return;
    }
    $search_filter->insert($data);
  }

  public function changeFilter()
  {
    if($this->picked_filter == "")
      return;

    $search_filter = $this->getService();
    $filter = $search_filter->get($this->picked_filter);

    if(empty($filter))
      return;

    $meta_filter = json_decode($filter[0]["meta_filter"], true);

    $this->allFilters = $meta_filter;

  }

  public function updateResults($index)
  {
    $choice_filters = [];
    $selected_filters = 0;
      foreach ($this->allFilters[$index]["filters"] as $filter) {
        foreach ($filter["fields"] as $fields) {

          if ($fields["isVisible"] == "true") {
            $selected_filters++;

            $choice_filters[] = [
              "name"            =>  $fields["name"],
              "value"           =>  $fields["value"],
              "signal"          =>  $fields["signal"]
            ];
          }
        }


      $this->allFilters[$index]['number_of_filters'] = $selected_filters;
    }

    $this->json_filter = $this->createJsonFilter($choice_filters, $index);

  }

  public function createTemporaryFilter($index){
    $choice_filters = [];
    $selected_filters = 0;
      foreach ($this->allFilters[$index]["filters"] as $filter) {
        foreach ($filter["fields"] as $fields) {

          if ($fields["isVisible"] == "true") {
            $selected_filters++;

            $choice_filters[] = [
              "name"            =>  $fields["name"],
              "value"           =>  $fields["value"],
              "signal"          =>  $fields["signal"]
            ];
          }
        }


      $this->allFilters[$index]['number_of_filters'] = $selected_filters;
    }

    $this->json_filter = $this->createJsonFilter($choice_filters, $index);
    $this->temporaryFilter($this->json_filter);

  }

  public function addNewFilter($index)
  {

    $this->createTemporaryFilter($index);
    $filters = new GenerateFiltersRepository();
    $this->allFilters[] = [
      "number_of_filters" => 0,
      "filters"           => $filters->GenerateAllFilters()
    ];
  }

  public function getService(){
    return new SearchFilterService(new SearchFilterRepository(new SearchFilter()));
  }

  public function redoCheckedOptions(){

    $this->checked = 0;
    foreach($this->selected_options as $option){

      if($option == true)
        $this->checked++;
    }
  }

  public function render()
  {
    $templates = Template::where('is_active', '=', 1)->get();
    $filters   = SearchFilter::where("status", "=", "saved")->get();
    return view('mass-emails::livewire.mass-email-form', ['templates' => $templates, "filters" => $filters]);
  }
}
