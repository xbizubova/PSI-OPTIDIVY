<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->float('price');
            $table->float('discount')->default(0);
            $table->integer('quantity');
            $table->integer('min_quantity')->default(1);
            $table->enum('product_type', ['glasses', 'contact_lenses']);
            $table->foreignId('product_id');       // polymorfný – ID glasses alebo contact_lenses
            $table->string('product_type_model');  // 'App\Models\Glasses' alebo 'App\Models\ContactLenses'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
