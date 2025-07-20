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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Ej: "ark pc", "Tarjeta  $20", "Skin Furia de Dragón"
        $table->text('description');
        $table->decimal('price', 8, 2);
        $table->string('image_url')->nullable();

        // --- Relaciones ---
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->foreignId('platform_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('game_id')->nullable()->constrained()->onDelete('set null');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
