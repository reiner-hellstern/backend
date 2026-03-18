<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('aufgaben_template_zugeteilte')) {
            Schema::create('aufgaben_template_zugeteilte', function (Blueprint $table) {
                $table->id();
                $table->foreignId('aufgaben_template_id')->constrained('aufgaben_templates', 'id', 'aufgaben_tmpl_zuget_fk')->onDelete('cascade');
                $table->string('assignable_type');
                $table->unsignedBigInteger('assignable_id');
                $table->timestamps();

                $table->index(['assignable_type', 'assignable_id'], 'aufgaben_tmpl_zuget_assign_idx');
                $table->unique(['aufgaben_template_id', 'assignable_type', 'assignable_id'], 'aufgaben_tmpl_zuget_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('aufgaben_template_zugeteilte');
    }
};
