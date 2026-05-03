<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();

            // OD – pravé oko
            $table->string('od_ostrost')->nullable();
            $table->float('sphere_right')->nullable();
            $table->float('cylinder')->nullable();
            $table->integer('axis')->nullable();
            $table->float('pupil_distance')->nullable();

            // OS – ľavé oko
            $table->string('os_ostrost')->nullable();
            $table->float('sphere_left')->nullable();
            $table->float('os_cylinder')->nullable();
            $table->integer('os_axis')->nullable();
            $table->float('os_pupil_distance')->nullable();

            // Sklá
            $table->string('lens_type')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
