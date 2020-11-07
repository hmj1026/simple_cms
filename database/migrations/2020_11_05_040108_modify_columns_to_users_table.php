<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsToUsersTable extends Migration
{
    protected $columns_added = ['type', 'status', 'updated_by', 'created_by'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasColumns('users', $this->columns_added)) {
            Schema::table('users', function (Blueprint $table) {
                collect($this->columns_added)->each(function ($column) use ($table) {
                    switch ($column) {
                        case 'type':
                            $table->integer($column)->default(1)->comment('1: normal, 2: admin')->after('id');
                            break;
                        case 'status':
                            $table->tinyInteger($column)->default(1)->after('remember_token');
                            break;
                        case 'updated_by':
                        case 'created_by':
                            $table->string($column)->nullable()->after('status');
                            break;
                    }
                });

                $table->index('name');
                $table->index('status');
                $table->index(['email', 'status']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            collect($this->columns_added)->each(function ($column) use ($table) {
                $table->dropColumn($column);
            });

            $table->dropUnique('users_name_index');
            $table->dropIndex('users_email_status_index');
        });
    }
}
