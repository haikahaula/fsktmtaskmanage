<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCreatedByFromGroupsTable extends Migration
{
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['created_by']);
            // Then drop the column
            $table->dropColumn('created_by');
        });
    }

    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable();

            // Re-add the foreign key if needed
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }
}
