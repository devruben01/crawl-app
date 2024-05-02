<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable('samples')) {
            Schema::create('samples', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255)->nullable()->comment('Title of the sample');
                $table->text('description')->nullable()->comment('Description of the sample');
                $table->string('image')->nullable()->comment('Image of the sample');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
