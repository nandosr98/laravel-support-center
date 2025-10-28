<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * CATEGORÍAS
         */
        Schema::create('support_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->timestamps();
        });

        /**
         * TICKETS
         */
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('email')->nullable();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('support_categories')
                ->nullOnDelete();

            $table->string('subject');
            $table->longText('description')->nullable();

            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('channel', ['web', 'email', 'telegram', 'whatsapp', 'api'])->default('web');

            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();
        });

        /**
         * MENSAJES
         */
        Schema::create('support_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')
                ->constrained('support_tickets')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->longText('message');
            $table->boolean('is_internal')->default(false);
            $table->enum('sent_via', ['web', 'email', 'telegram', 'whatsapp'])->default('web');

            $table->timestamps();
        });

        /**
         * HISTÓRICO DE ESTADOS
         */
        Schema::create('support_status_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')
                ->constrained('support_tickets')
                ->cascadeOnDelete();

            $table->foreignId('changed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('from_status');
            $table->string('to_status');
            $table->text('comment')->nullable();

            $table->timestamps();
        });

        /**
         * TAGS
         */
        Schema::create('support_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('color')->nullable();
            $table->timestamps();
        });

        /**
         * TABLA INTERMEDIA DE TICKETS Y TAGS
         */
        Schema::create('support_ticket_tag', function (Blueprint $table) {
            $table->foreignId('ticket_id')
                ->constrained('support_tickets')
                ->cascadeOnDelete();

            $table->foreignId('tag_id')
                ->constrained('support_tags')
                ->cascadeOnDelete();

            $table->primary(['ticket_id', 'tag_id']);
        });

        /**
         * AGENTES
         */
        Schema::create('support_agents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('role', ['agent', 'admin'])->default('agent');
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_agents');
        Schema::dropIfExists('support_ticket_tag');
        Schema::dropIfExists('support_tags');
        Schema::dropIfExists('support_status_logs');
        Schema::dropIfExists('support_messages');
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('support_categories');
    }
};
