<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist', function (Blueprint $table) {
            $table->bigIncrements('checklist_id');
            $table->integer('template_id')->nullable();
            $table->string('object_domain')->nullable();
            $table->string('object_id')->nullable();
            $table->string('description');
            $table->boolean('is_completed')->default(false);
            $table->date('completed_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->dateTime('due')->nullable();
            $table->integer('urgency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklist');
    }
}
