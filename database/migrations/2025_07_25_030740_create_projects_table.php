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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->decimal('cost')->nullable();
            $table->enum('projectType', ['web', 'flutter','webAndFlutter','other']);
            $table->enum('status', ['pending', 'rejected','completed','canceled','inProgress'])->default('pending');
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->string('hostName')->nullable();
            $table->decimal('hostCost')->nullable();
            $table->date('buyHostDate')->nullable();
            $table->date('renewalHostDate')->nullable();
            $table->string('domainName')->nullable();
            $table->decimal('domainCost')->nullable();
            $table->date('buyDomainDate')->nullable();
            $table->date('renewalDomainDate')->nullable();
            $table->text('reason')->nullable();
            $table->decimal('amount')->nullable();
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
        Schema::dropIfExists('projects');
    }
};
