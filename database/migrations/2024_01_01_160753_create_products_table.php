<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Schema, DB};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->uuid('uuid');
            $table->tinyText('name');
            $table->tinyText('slug');
            $table->tinyInteger('quantity');
            $table->decimal('price', 8, 2);
            $table->decimal('discount', 8, 2)->nullable()->default(0);
            $table->boolean('featured')->default(0);
            $table->text('details')->nullable();
            $table->unsignedSmallInteger('added_by');
            $table->foreign('added_by')->references('id')->on('users');
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement('DROP TABLE IF EXISTS products');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
