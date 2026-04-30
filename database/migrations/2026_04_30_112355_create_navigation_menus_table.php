<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('navigation_menus', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->boolean('is_visible')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Seed initial menus
        DB::table('navigation_menus')->insert([
            ['key' => 'home', 'label' => 'Home', 'is_visible' => true, 'order' => 1],
            ['key' => 'how-it-works', 'label' => 'How it works', 'is_visible' => true, 'order' => 2],
            ['key' => 'search', 'label' => 'Search', 'is_visible' => true, 'order' => 3],
            ['key' => 'blogs', 'label' => 'Blogs', 'is_visible' => true, 'order' => 4],
            ['key' => 'updates', 'label' => 'Updates', 'is_visible' => true, 'order' => 5],
            ['key' => 'contact', 'label' => 'Contact', 'is_visible' => true, 'order' => 6],
            ['key' => 'careers', 'label' => 'Careers', 'is_visible' => true, 'order' => 7],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigation_menus');
    }
};
