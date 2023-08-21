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
        Schema::create('voters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email');
            $table->string('name');
            $table->string('npm');
            $table->foreignUuid('election_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('candidate_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('generation_id')->constrained('generations', 'id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
