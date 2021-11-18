<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_filters', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->string("name")->nullable();
            $table->longText("meta");
            $table->longText("meta_filter")->nullable();
            $table->enum("status", ["draft", "saved"]);
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
        Schema::dropIfExists('search_filters');
    }
}
