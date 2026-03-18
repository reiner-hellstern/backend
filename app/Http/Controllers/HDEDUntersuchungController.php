<?php

namespace App\Http\Controllers;

use App\Models\Dokument;
use App\Models\HDEDUntersuchung;
use App\Models\HDEDUntersuchung_v1;
use Illuminate\Http\Request;

class HDEDUntersuchungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['id'] == 0) {

            $data = $request->all();

            $hdeduntersuchung = new HDEDUntersuchung();

            $hdeduntersuchung->anmerkungen = $data['anmerkungen'];
            $hdeduntersuchung->arzt_email = $data['arzt_email'];
            $hdeduntersuchung->arzt_id = $data['arzt_id'];
            $hdeduntersuchung->arzt_land = $data['arzt_land'];
            $hdeduntersuchung->arzt_land_kuerzel = $data['arzt_land_kuerzel'];
            $hdeduntersuchung->arzt_nachname = $data['arzt_nachname'];
            $hdeduntersuchung->arzt_ort = $data['arzt_ort'];
            $hdeduntersuchung->arzt_plz = $data['arzt_plz'];
            $hdeduntersuchung->arzt_praxis = $data['arzt_praxis'];
            $hdeduntersuchung->arzt_strasse = $data['arzt_strasse'];
            $hdeduntersuchung->arzt_telefon_1 = $data['arzt_telefon_1'];
            $hdeduntersuchung->arzt_telefon_2 = $data['arzt_telefon_2'];
            $hdeduntersuchung->arzt_titel = $data['arzt_titel'];
            $hdeduntersuchung->arzt_vorname = $data['arzt_vorname'];
            $hdeduntersuchung->arzt_website = $data['arzt_website'];
            $hdeduntersuchung->coronoid = $data['coronoid'];
            $hdeduntersuchung->ct_datum = $data['ct_datum'];
            $hdeduntersuchung->ct_grund_id = $data['ct_grund_id'];
            $hdeduntersuchung->datum = $data['datum'];
            $hdeduntersuchung->dokument_id = $data['dokument_id'];
            $hdeduntersuchung->dokumentable_id = $data['dokumentable_id'];
            $hdeduntersuchung->dokumentable_type = $data['dokumentable_type'];
            $hdeduntersuchung->ed = $data['ed'];
            $hdeduntersuchung->ed_ablehnung_id = $data['ed_ablehnung_id'];
            $hdeduntersuchung->ed_l_arthrose_score_id = $data['ed_arthrose_l_score']['id'];
            $hdeduntersuchung->ed_r_arthrose_score_id = $data['ed_arthrose_r_score']['id'];
            $hdeduntersuchung->ed_bearbeitungscode = $data['ed_bearbeitungscode'];
            //  $hdeduntersuchung->ed_id = $data['ed_id'];
            // $hdeduntersuchung->ed_l_id = $data['ed_l_id'];
            $hdeduntersuchung->ed_l_score_id = $data['ed_l_score']['id'];
            $hdeduntersuchung->ed_l_status_id = $data['ed_l_status_id'];
            $hdeduntersuchung->ed_lagerung_mangelhaft = $data['ed_lagerung_mangelhaft'];
            // $hdeduntersuchung->ed_og_id = $data['ed_og_id'];
            $hdeduntersuchung->ed_qualitaet_mangelhaft = $data['ed_qualitaet_mangelhaft'];
            // $hdeduntersuchung->ed_r_id = $data['ed_r_id'];
            $hdeduntersuchung->ed_r_score_id = $data['ed_r_score']['id'];
            $hdeduntersuchung->ed_r_status_id = $data['ed_r_status_id'];
            $hdeduntersuchung->ed_score_id = $data['ed_score']['id'];
            $hdeduntersuchung->ed_scoretyp_id = $data['ed_scoretyp_id'];
            $hdeduntersuchung->ed_status_id = $data['ed_status_id'];
            $hdeduntersuchung->fcp = $data['fcp'];
            $hdeduntersuchung->formularcode = $data['formularcode'];
            $hdeduntersuchung->gutachter_email = $data['gutachter_email'];
            $hdeduntersuchung->gutachter_id = $data['gutachter_id'];
            $hdeduntersuchung->gutachter_land = $data['gutachter_land'];
            $hdeduntersuchung->gutachter_land_kuerzel = $data['gutachter_land_kuerzel'];
            $hdeduntersuchung->gutachter_nachname = $data['gutachter_nachname'];
            $hdeduntersuchung->gutachter_ort = $data['gutachter_ort'];
            $hdeduntersuchung->gutachter_plz = $data['gutachter_plz'];
            $hdeduntersuchung->gutachter_strasse = $data['gutachter_strasse'];
            $hdeduntersuchung->gutachter_telefon_1 = $data['gutachter_telefon_1'];
            $hdeduntersuchung->gutachter_telefon_2 = $data['gutachter_telefon_2'];
            $hdeduntersuchung->gutachter_titel = $data['gutachter_titel'];
            $hdeduntersuchung->gutachter_vorname = $data['gutachter_vorname'];
            $hdeduntersuchung->gutachter_website = $data['gutachter_website'];
            $hdeduntersuchung->hd = $data['hd'];
            $hdeduntersuchung->hd_ablehnung_id = $data['hd_ablehnung_id'];
            $hdeduntersuchung->hd_bearbeitungscode = $data['hd_bearbeitungscode'];
            //  $hdeduntersuchung->hd_id = $data['hd_id'];
            //   $hdeduntersuchung->hd_l_id = $data['hd_l_id'];
            $hdeduntersuchung->hd_l_score_id = $data['hd_l_score']['id'];
            $hdeduntersuchung->hd_l_status_id = $data['hd_l_status_id'];
            $hdeduntersuchung->hd_lagerung_mangelhaft = $data['hd_lagerung_mangelhaft'];
            // $hdeduntersuchung->hd_og_id = $data['hd_og_id'];
            $hdeduntersuchung->hd_qualitaet_mangelhaft = $data['hd_qualitaet_mangelhaft'];
            // $hdeduntersuchung->hd_r_id = $data['hd_r_id'];
            $hdeduntersuchung->hd_r_score_id = $data['hd_r_score']['id'];
            $hdeduntersuchung->hd_r_status_id = $data['hd_r_status_id'];
            $hdeduntersuchung->hd_score_id = $data['hd_score']['id'];
            $hdeduntersuchung->hd_scoretyp_id = $data['hd_scoretyp_id'];
            $hdeduntersuchung->hd_status_id = $data['hd_status_id'];
            $hdeduntersuchung->hd_uwirbel = $data['hd_uwirbel'];
            $hdeduntersuchung->hd_uwirbel_score_id = $data['hd_uwirbel_score']['id'];
            $hdeduntersuchung->hund_id = $data['hund_id'];
            $hdeduntersuchung->ipa = $data['ipa'];
            $hdeduntersuchung->ocd = $data['ocd'];
            $hdeduntersuchung->roentgen_anmerkungen = $data['roentgen_anmerkungen'];
            $hdeduntersuchung->roentgen_art_id = $data['roentgen_art_id'];
            $hdeduntersuchung->roentgen_arzt_id = $data['roentgen_arzt_id'];
            $hdeduntersuchung->roentgen_arzt_nachname = $data['roentgen_arzt_nachname'];
            $hdeduntersuchung->roentgen_arzt_titel = $data['roentgen_arzt_titel'];
            $hdeduntersuchung->roentgen_arzt_vorname = $data['roentgen_arzt_vorname'];
            $hdeduntersuchung->roentgen_datum = $data['roentgen_datum'];
            $hdeduntersuchung->roentgen_praxis_email = $data['roentgen_praxis_email'];
            $hdeduntersuchung->roentgen_praxis_id = $data['roentgen_praxis_id'];
            $hdeduntersuchung->roentgen_praxis_land = $data['roentgen_praxis_land'];
            $hdeduntersuchung->roentgen_praxis_land_kuerzel = $data['roentgen_praxis_land_kuerzel'];
            $hdeduntersuchung->roentgen_praxis_name = $data['roentgen_praxis_name'];
            $hdeduntersuchung->roentgen_praxis_ort = $data['roentgen_praxis_ort'];
            $hdeduntersuchung->roentgen_praxis_plz = $data['roentgen_praxis_plz'];
            $hdeduntersuchung->roentgen_praxis_strasse = $data['roentgen_praxis_strasse'];
            $hdeduntersuchung->roentgen_praxis_telefon_1 = $data['roentgen_praxis_telefon_1'];
            $hdeduntersuchung->roentgen_praxis_telefon_2 = $data['roentgen_praxis_telefon_2'];
            $hdeduntersuchung->roentgen_praxis_website = $data['roentgen_praxis_website'];
            $hdeduntersuchung->roentgen_vetsxl_nr = $data['roentgen_vetsxl_nr'];
            $hdeduntersuchung->scoreable_id = $data['scoreable_id'];
            $hdeduntersuchung->scoreable_type = $data['scoreable_type'];
            $hdeduntersuchung->sedierung_menge = $data['sedierung_menge'];
            $hdeduntersuchung->sedierung_praeparat = $data['sedierung_praeparat'];
            $hdeduntersuchung->status_id = $data['status']['id'];
            $hdeduntersuchung->typ_id = $data['typ']['id'];

            $hdeduntersuchung->save();
            // $hdeduntersuchung = HDEDUntersuchung::create($data);

            $dokumente = $data['dokumente'];

            foreach ($dokumente as $dokument) {
                $tags = $dokument['tags'];
                unset($dokument['tags']);
                $dokument = $hdeduntersuchung->dokumente()->create($dokument);
                $dokument->tags()->sync($tags);
            }

            return response()->json([
                'success' => 'HDEDUntersuchung gespeichert.',
                'id' => $hdeduntersuchung->id,
            ]);
        } else {
            $hdeduntersuchung = HDEDUntersuchung::find($request['id']);
            $data = $request->all();

            $hdeduntersuchung->update($data);

            $dokumente = $data['dokumente'];

            $db_dokuments = [];
            $dok_ids = [];

            foreach ($dokumente as $dokument) {
                $db_dokument = Dokument::find($dokument['id']);
                $db_dokuments[] = $db_dokument;
                $dok_ids[] = $db_dokument->id;
                $db_dokument->update($dokument);

                $tags = $dokument['tags'];
                $tag_ids = array_map(function ($tag) {
                    return $tag['id'];
                }, $tags);
                $db_dokument->tags()->sync($tag_ids);
            }

            $hdeduntersuchung->dokumente()->sync($dok_ids);
        }

        $hdeduntersuchung->fresh();

        return response()->json([
            'success' => 'HDEDUntersuchung aktualisiert.',
            'id' => $hdeduntersuchung->id,
        ]);
    }

    public function store_v1(Request $request)
    {
        if ($request['id'] == 0) {

            $data = $request->all();

            $hdeduntersuchung = HDEDUntersuchung_v1::create($data);

            $dokumente = $data['dokumente'];

            foreach ($dokumente as $dokument) {
                $tags = $dokument['tags'];
                unset($dokument['tags']);
                $dokument = $hdeduntersuchung->dokumente()->create($dokument);
                $dokument->tags()->sync($tags);
            }

            return response()->json([
                'success' => 'HDEDUntersuchung gespeichert.',
                'id' => $hdeduntersuchung->id,
            ]);
        } else {
            $hdeduntersuchung = HDEDUntersuchung_v1::find($request['id']);
            $data = $request->all();

            $hdeduntersuchung->update($data);

            $dokumente = $data['dokumente'];

            $db_dokuments = [];
            $dok_ids = [];

            foreach ($dokumente as $dokument) {
                $db_dokument = Dokument::find($dokument['id']);
                $db_dokuments[] = $db_dokument;
                $dok_ids[] = $db_dokument->id;
                $db_dokument->update($dokument);

                $tags = $dokument['tags'];
                $tag_ids = array_map(function ($tag) {
                    return $tag['id'];
                }, $tags);
                $db_dokument->tags()->sync($tag_ids);
            }

            $hdeduntersuchung->dokumente()->sync($dok_ids);
        }

        return response()->json([
            'success' => 'HDEDUntersuchung aktualisiert.',
            'id' => $hdeduntersuchung->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(HDEDUntersuchung $hdeduntersuchung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HDEDUntersuchung $hdeduntersuchung)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HDEDUntersuchung  $hdeduntersuchung
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $untersuchung = HDEDUntersuchung::find($request['id']);

        if ($untersuchung) {
            HDEDUntersuchung::destroy($request['id']);

            return response()->json([
                'success' => 'HDEDBefund gelöscht.',
            ]);
        }
    }
}
