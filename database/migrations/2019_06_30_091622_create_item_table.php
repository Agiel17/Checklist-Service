<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->bigIncrements('item_id');
            $table->integer('checklist_id');
            $table->string('description');
            $table->boolean('is_completed')->default(false);
            $table->date('completed_at')->nullable();
            $table->dateTime('due')->nullable();
            $table->integer('urgency')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->string('asignee_id')->nullable();
            $table->integer('task_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
