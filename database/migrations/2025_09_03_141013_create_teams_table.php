<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('logo');
            $table->string('name');
            $table->string('manager_name');
            $table->string('contact');
            $table->string('location');
            $table->enum('gender_category', ['male', 'female', 'mixed']);
            $table->tinyInteger('member_count')->unsigned();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
