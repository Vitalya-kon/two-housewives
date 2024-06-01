<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_cleanings', function (Blueprint $table) {
            $table->id();
            $table->string('service')->nullable();
            $table->string('url_image')->nullable();
            $table->text('description')->nullable();
            $table->float('from_price')->default(0);
            $table->float('to_price')->default(0);
            $table->float('from_last_price')->default(0);
            $table->float('to_last_price')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('service_cleanings');
    }
};
