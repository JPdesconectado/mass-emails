<?php


namespace Koisystems\MassEmails\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;
use Koisystems\MassEmails\Models\EmailTransaction;
use Koisystems\MassEmails\Models\EmailTransactionItem;

class MassEmailController extends Controller
{

    public function __construct()
    {
        //
    }

    public function index(Request $request){

        $showEmptyState = false;

        $email_transaction = EmailTransaction::all();

        if($email_transaction->isEmpty()){
            $showEmptyState = true;

        }else{

          foreach($email_transaction as &$item){
            $item->admin_name = User::findOrFail($item->user_id)->name;
          }
        }

        return view('mass-emails::main.index', compact('showEmptyState', "email_transaction"));
    }

    public function create(Request $request){

        return view('mass-emails::main.createOrEdit');
    }

    public function show($id){

      $email_transaction = EmailTransaction::findOrFail($id);

      $email_transaction_items = EmailTransactionItem::where("transaction_id", "=", $email_transaction->id)->get();

      foreach($email_transaction_items as &$item){
        $status = __("mass-emails::transaction.draft_option");
        switch($item->status){

          case "draft":
            $status = __("mass-emails::transaction.draft_option");
            break;

          case "pending":
            $status = __("mass-emails::transaction.pending_option");
            break;

          case "processing":
            $status = __("mass-emails::transaction.processing_option");
            break;

          case "complete":
            $status = __("mass-emails::transaction.complete_option");
            break;
        }

        if($item->sent_to_host_id != null)
            $item->sent = Owner::findOrFail($item->sent_to_host_id)->comercial_name;

        if($item->sent_to_accommodation_id != null)
            $item->sent = Accommodation::findOrFail($item->sent_to_accommodation_id)->title;
      }
      return view('mass-emails::main.show', compact("email_transaction_items"));

    }
}
