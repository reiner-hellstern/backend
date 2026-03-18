<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rechnungen', function (Blueprint $table) {
            // Rename existing columns to match model expectations
            $table->renameColumn('person_id', 'kreditor_id');

            // Add missing foreign key fields
            $table->unsignedBigInteger('export_id')->nullable();
            $table->unsignedBigInteger('bezahlart_id')->nullable();
            $table->unsignedBigInteger('bezahlstatus_id')->nullable();
            $table->unsignedBigInteger('rechungssteller_id')->nullable();
            $table->unsignedBigInteger('bankverbindung_id')->nullable();

            // Add missing address fields
            $table->string('rechnung_name')->nullable();
            $table->string('rechnung_adresszusatz')->nullable();
            $table->string('rechnung_strasse')->nullable();
            $table->string('rechnung_postleitzahl')->nullable();
            $table->string('rechnung_ort')->nullable();

            // Rename and add date/amount fields
            $table->renameColumn('erstellt_am', 'rechnungsdatum');
            $table->renameColumn('summe', 'rechnungssumme');
            $table->renameColumn('bezahlt_am', 'buchungsdatum');
            $table->date('faelligkeit')->nullable();
            $table->decimal('geldeingang', 10, 2)->nullable();
            $table->decimal('offen', 10, 2)->nullable();

            // Rename storno fields
            $table->renameColumn('storniert_am', 'storno_am');
            $table->renameColumn('stornierer_id', 'storno_id');

            // Add SEPA/payment fields
            $table->string('auftraggeber_bankname')->nullable();
            $table->string('auftraggeber_iban')->nullable();
            $table->string('auftraggeber_bic')->nullable();
            $table->string('verwendungszweck')->nullable();
            $table->string('auftraggeber_mandatsreferenz')->nullable();
            $table->string('sepa_transaktions_id')->nullable();
            $table->string('sepa_reason_code')->nullable();
            $table->boolean('ruecklastschrift')->default(false);
            $table->string('waehrung', 3)->default('EUR');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rechnungen', function (Blueprint $table) {
            // Reverse column renames
            $table->renameColumn('kreditor_id', 'person_id');
            $table->renameColumn('rechnungsdatum', 'erstellt_am');
            $table->renameColumn('rechnungssumme', 'summe');
            $table->renameColumn('buchungsdatum', 'bezahlt_am');
            $table->renameColumn('storno_am', 'storniert_am');
            $table->renameColumn('storno_id', 'stornierer_id');

            // Drop added columns
            $table->dropColumn([
                'export_id',
                'bezahlart_id',
                'bezahlstatus_id',
                'rechungssteller_id',
                'bankverbindung_id',
                'rechnung_name',
                'rechnung_adresszusatz',
                'rechnung_strasse',
                'rechnung_postleitzahl',
                'rechnung_ort',
                'faelligkeit',
                'geldeingang',
                'offen',
                'auftraggeber_bankname',
                'auftraggeber_iban',
                'auftraggeber_bic',
                'verwendungszweck',
                'auftraggeber_mandatsreferenz',
                'sepa_transaktions_id',
                'sepa_reason_code',
                'ruecklastschrift',
                'waehrung',
            ]);
        });
    }
};
