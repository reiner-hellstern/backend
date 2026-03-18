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
            // Entferne die redundanten Felder, da bereits bezahlart_id und bezahlstatus_id existieren
            //   $table->dropColumn(['zahlungsart', 'zahlungsstatus']);

            // Buchungsdatum bleibt
            // $table->date('buchungsdatum')->nullable()->after('anmerkungen');

            // SEPA/BIC Felder (IBAN gibt es bereits)
            // $table->string('auftraggeber_bic', 11)->nullable();
            // $table->string('empfaenger_iban', 34)->nullable();
            // $table->string('empfaenger_bic', 11)->nullable();

            // // SEPA spezifische Felder (verwendungszweck gibt es schon als anmerkungen)
            // $table->string('mandatsreferenz')->nullable();
            // $table->string('glaeubiger_id')->nullable();
            // $table->string('sepa_transaktions_id');

            // // Rücklastschrift Details (ruecklastschrift boolean gibt es bereits)
            // $table->string('ruecklastschrift_grund');
            // $table->date('ruecklastschrift_am');

            // // Währung
            // $table->char('waehrung', 3)->default('EUR');

            // // Indizes für Performance
            // $table->index('buchungsdatum');
            // $table->index('empfaenger_iban');
            // $table->index('mandatsreferenz');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rechnungen', function (Blueprint $table) {
            $table->dropIndex(['buchungsdatum']);
            $table->dropIndex(['empfaenger_iban']);
            $table->dropIndex(['mandatsreferenz']);

            $table->dropColumn([
                'auftraggeber_bic',
                'empfaenger_iban',
                'empfaenger_bic',
                'mandatsreferenz',
                'glaeubiger_id',
                'sepa_transaktions_id',
                'ruecklastschrift_grund',
                'ruecklastschrift_am',
                'waehrung',
            ]);
        });
    }
};
