<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToSuccessfulEmailsTable extends Migration
{
    public function up()
    {
        Schema::table('successful_emails', function (Blueprint $table) {
            $table->softDeletes(); // This will add a nullable 'deleted_at' column
        });
    }

    public function down()
    {
        Schema::table('successful_emails', function (Blueprint $table) {
            $table->dropSoftDeletes(); // This will remove the 'deleted_at' column
        });
    }
}
