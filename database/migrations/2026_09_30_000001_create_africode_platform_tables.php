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
        // Formations table
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('domain'); // dev, cyber, data, network, devops
            $table->string('icon')->default('code');
            $table->string('badge')->nullable();
            $table->text('summary');
            $table->longText('description');
            $table->string('level')->default('Fondamentaux');
            $table->string('duration')->default('3 mois');
            $table->integer('students_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // Modules table
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(1);
            $table->timestamps();
        });

        // Courses / Lessons table
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('duration')->default('15 min');
            $table->string('video_url')->nullable();
            $table->boolean('is_free_preview')->default(false);
            $table->integer('order')->default(1);
            $table->timestamps();
        });

        // Enrollments table
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
            $table->integer('progress_percent')->default(0);
            $table->string('status')->default('active'); // active, completed
            $table->timestamp('enrolled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'formation_id']);
        });

        // Lesson progress table
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->boolean('completed')->default(true);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });

        // Projects table
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->text('description');
            $table->string('domain');
            $table->string('technologies'); // e.g. "Laravel, Vue.js, MySQL"
            $table->string('image_path')->nullable();
            $table->string('author_name');
            $table->string('github_url')->nullable();
            $table->string('demo_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });

        // Trainer / Contributor Applications table
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('role_applied'); // Formateur, Mentor, Expert, Contributeur
            $table->string('domain_expertise'); // Développement, Cybersécurité, Data, Réseaux, DevOps
            $table->string('experience_years')->default('1-3 ans');
            $table->text('bio');
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // Events table
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('Atelier'); // Atelier, Conférence, Hackathon, Webinaire
            $table->date('event_date')->nullable();
            $table->string('event_time')->nullable()->default('18:00 GMT');
            $table->string('location')->default('En ligne / Zoom');
            $table->text('description');
            $table->string('registration_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        // Notifications table
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info'); // info, success, warning
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // Testimonials table
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role_title');
            $table->string('avatar')->nullable();
            $table->text('content');
            $table->integer('rating')->default(5);
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('events');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('progress');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('formations');
    }
};
