<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTransactionsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_transactions_items', function (Blueprint $table) {
            $table->id();
            $table->integer("transaction_id");
            $table->integer("sent_to_host_id")->nullable();
            $table->integer("sent_to_accommodation_id")->nullable();
            $table->string("destination_email");
            $table->string("subject");
            $table->text("message");
            $table->enum("status", ["draft", "pending", "processing", "complete"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_transactions_items');
    }
}
