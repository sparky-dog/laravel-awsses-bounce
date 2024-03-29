<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsBouceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_bouce_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('source_ip');
            $table->string('status')->nullable();
            $table->string('code')->nullable();
            $table->integer('send_count')->default(0);
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
        Schema::dropIfExists('aws_bouce_lists');
    }
}
