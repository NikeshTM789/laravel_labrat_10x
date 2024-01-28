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
            // $table->uuid('uuid');
            $table->tinyText('name');
            $table->tinyText('slug');
            $table->tinyInteger('quantity');
            $table->decimal('price', 8, 2);
            $table->decimal('discounted_price', 8, 2);
            $table->boolean('featured')->default(0);
            $table->text('details');
            $table->unsignedSmallInteger('added_by');
            $table->foreign('added_by')->references('id')->on('users');
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
        // DB::select('ALTER TABLE products add column uuid char(36)');
        // DB::select("UPDATE products SET uuid = (SELECT uuid_v4())");
        // DB::select('ALTER TABLE products CHANGE COLUMN uuid uuid char(36) NOT NULL');
        // DB::select('CREATE UINQUE INDEX products_uuid ON products (uuid)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
