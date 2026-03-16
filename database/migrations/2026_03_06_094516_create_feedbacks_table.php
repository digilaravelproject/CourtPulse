
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('given_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('given_to')->constrained('users')->onDelete('cascade');
            $table->enum('role_type', ['advocate', 'clerk', 'ca']); // who is being reviewed
            $table->integer('rating')->between(1, 5);
            $table->text('comment')->nullable();
            $table->boolean('is_compulsory')->default(false); // for clerk
            $table->boolean('is_anonymous')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
