<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactQueriesTable extends Migration
{
    public function up()
    {
        Schema::create('contact_queries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['unread', 'read', 'solved'])
                ->default('unread');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_queries');
    }
}
