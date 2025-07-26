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
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->enum('job', ['ui','front', 'flutter','back','sales']);
            $table->enum('status', ['active','notActive'])->default('active');
            $table->decimal('salary')->default(0);
            $table->date('joiningDate')->nullable();
            $table->text('zahaOpinion')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('creationDate')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developers');
    }
};
