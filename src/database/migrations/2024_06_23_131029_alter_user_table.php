<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'status'))
        {Schema::table('users', function (Blueprint $table)
            {
                $table->tinyInteger('status')->default(1);
            });
        }
        if (!Schema::hasColumn('users', 'super_admin'))
        {Schema::table('users', function (Blueprint $table)
        {
            $table->tinyInteger('super_admin')->default(0);
        });
        }
        if (!Schema::hasColumn('users', 'image'))
        {Schema::table('users', function (Blueprint $table)
        {
            $table->string('image')->default('images/default/default_person_icon.png');
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
        if (Schema::hasColumn('users', 'status'))
        {Schema::table('users', function (Blueprint $table)
        {
            $table->dropColumn('status');
        });}
        if (Schema::hasColumn('users', 'super_admin'))
        {Schema::table('users', function (Blueprint $table)
        {
            $table->dropColumn('super_admin');
        });}
        if (Schema::hasColumn('users', 'image'))
        {Schema::table('users', function (Blueprint $table)
        {
            $table->dropColumn('image');
        });}
    }
}
