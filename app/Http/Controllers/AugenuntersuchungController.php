<?php

namespace App\Http\Controllers;

use App\Models\Augenuntersuchung;
use App\Models\Augenuntersuchung_v1;
use App\Models\Dokument;
use App\Traits\SaveDokumente;
use Illuminate\Http\Request;

class AugenuntersuchungController extends Controller
{
    use SaveDokumente;

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

        //   $augenuntersuchung->aktive_au = $data['aktive_au'];
        //    $augenuntersuchung->aktive_gonio = $data['aktive_gonio'];
        //    $augenuntersuchung->anmerkungen = $data['anmerkungen'];
        //    $augenuntersuchung->arzt_email = $data['arzt_email'];
        //    $augenuntersuchung->arzt_id = $data['arzt_id'];
        //    $augenuntersuchung->arzt_land = $data['arzt_land'];
        //    $augenuntersuchung->arzt_land_kuerzel = $data['arzt_land_kuerzel'];
        //    $augenuntersuchung->arzt_nachname = $data['arzt_nachname'];
        //    $augenuntersuchung->arzt_ort = $data['arzt_ort'];
        //    $augenuntersuchung->arzt_plz = $data['arzt_plz'];
        //    $augenuntersuchung->arzt_praxis = $data['arzt_praxis'];
        //    $augenuntersuchung->arzt_strasse = $data['arzt_strasse'];
        //    $augenuntersuchung->arzt_telefon_1 = $data['arzt_telefon_1'];
        //    $augenuntersuchung->arzt_telefon_2 = $data['arzt_telefon_2'];
        //    $augenuntersuchung->arzt_titel = $data['arzt_titel'];
        //    $augenuntersuchung->arzt_vorname = $data['arzt_vorname'];
        //    $augenuntersuchung->arzt_website = $data['arzt_website'];
        //    $augenuntersuchung->cea_choroidhypo = $data['cea_choroidhypo'];
        //    $augenuntersuchung->cea_id = $data['cea_id'];
        //    $augenuntersuchung->cea_kolobom = $data['cea_kolobom'];
        //    $augenuntersuchung->cea_sonstige = $data['cea_sonstige'];
        //    $augenuntersuchung->cea_sonstige_angaben = $data['cea_sonstige_angaben'];
        //    $augenuntersuchung->datum = $data['datum'];
        //    $augenuntersuchung->distichiasis_id = $data['distichiasis_id'];

        //    $augenuntersuchung->dyslpectabnorm_gewebebruecken = $data['dyslpectabnorm_gewebebruecken'];
        //    $augenuntersuchung->dyslpectabnorm_id = $data['dyslpectabnorm_id'];
        //    $augenuntersuchung->dyslpectabnorm_kolobom = $data['dyslpectabnorm_kolobom'];
        //    $augenuntersuchung->dyslpectabnorm_totaldyspl = $data['dyslpectabnorm_totaldyspl'];
        //    $augenuntersuchung->ektropium_id = $data['ektropium_id'];
        //    $augenuntersuchung->entropium_id = $data['entropium_id'];
        //    $augenuntersuchung->foto = $data['foto'];

        //    $augenuntersuchung->gonioskopie = $data['gonioskopie'];
        //    $augenuntersuchung->hund_id = $data['hund_id'];
        //    $augenuntersuchung->hypoplasie_mikropapille_id = $data['hypoplasie_mikropapille_id'];
        //    $augenuntersuchung->ica_weite_id = $data['ica_weite_id'];
        //    $augenuntersuchung->icaa_grad_id = $data['icaa_grad_id'];
        //    $augenuntersuchung->icaa_id = $data['icaa_id'];
        //    $augenuntersuchung->katarakt_cortikalis = $data['katarakt_cortikalis'];
        //    $augenuntersuchung->katarakt_kon_id = $data['katarakt_kon_id'];
        //    $augenuntersuchung->katarakt_nonkon_id = $data['katarakt_nonkon_id'];
        //    $augenuntersuchung->katarakt_nuklearis = $data['katarakt_nuklearis'];
        //    $augenuntersuchung->katarakt_polpost = $data['katarakt_polpost'];
        //    $augenuntersuchung->katarakt_punctata = $data['katarakt_punctata'];
        //    $augenuntersuchung->katarakt_sonstige = $data['katarakt_sonstige'];
        //    $augenuntersuchung->katarakt_sonstige_angaben = $data['katarakt_sonstige_angaben'];
        //    $augenuntersuchung->katarakt_sutura_ant = $data['katarakt_sutura_ant'];
        //    $augenuntersuchung->korneadystrophie_id = $data['korneadystrophie_id'];
        //    $augenuntersuchung->linsenluxation_id = $data['linsenluxation_id'];
        //    $augenuntersuchung->methode_id = $data['methode_id'];
        //    $augenuntersuchung->mikrophthalamie_id = $data['mikrophthalamie_id'];
        //    $augenuntersuchung->mpp_id = $data['mpp_id'];
        //    $augenuntersuchung->mpp_iris = $data['mpp_iris'];
        //    $augenuntersuchung->mpp_komea = $data['mpp_komea'];
        //    $augenuntersuchung->mpp_linse = $data['mpp_linse'];
        //    $augenuntersuchung->mpp_vorderkammer = $data['mpp_vorderkammer'];
        //    $augenuntersuchung->mydriatikum = $data['mydriatikum'];
        //    $augenuntersuchung->open = $data['open'];
        //    $augenuntersuchung->ophtalmoskopie_d = $data['ophtalmoskopie_d'];
        //    $augenuntersuchung->ophtalmoskopie_ind = $data['ophtalmoskopie_ind'];
        //    $augenuntersuchung->phtvlphpv_id = $data['phtvlphpv_id'];
        //    $augenuntersuchung->phtvlphpv_nfrei_id = $data['phtvlphpv_nfrei_id'];
        //    $augenuntersuchung->pla_id = $data['pla_id'];
        //    $augenuntersuchung->pra_rd_id = $data['pra_rd_id'];
        //    $augenuntersuchung->primaerglaukom_id = $data['primaerglaukom_id'];
        //    $augenuntersuchung->rd_geo = $data['rd_geo'];
        //    $augenuntersuchung->rd_id = $data['rd_id'];
        //    $augenuntersuchung->rd_multifokal = $data['rd_multifokal'];
        //    $augenuntersuchung->rd_total = $data['rd_total'];
        //    $augenuntersuchung->spaltlampe = $data['spaltlampe'];
        //    $augenuntersuchung->tonometrie = $data['tonometrie'];
        //    $augenuntersuchung->typ = $data['typ'];
        //    $augenuntersuchung->weitere_methode = $data['weitere_methode'];
        //    $augenuntersuchung->weitere_methode_b = $data['weitere_methode_b'];

        //    $augenuntersuchung->gesamtergebnis = $data['gesamtergebnis'];
        //    $augenuntersuchung->dokumente = $data['dokumente'];
        //    $augenuntersuchung->typ = $data['typ'];

        // $augenuntersuchung->dokumente()->save($dokument);
        // $dokument->tags()->sync($tags);

        if ($request['id'] == 0) {

            $data = $request->all();
            $augenuntersuchung = Augenuntersuchung::create($data);
            $dokumente = $data['dokumente'];

            foreach ($dokumente as $dokument) {
                $tags = $dokument['tags'];
                unset($dokument['tags']);
                $dokument = $augenuntersuchung->dokumente()->create($dokument);
                $dokument->tags()->sync($tags);
            }

            return response()->json([
                'success' => 'Augenuntersuchung gespeichert.',
                'id' => $augenuntersuchung->id,
            ]);

        } else {
            $augenuntersuchung = Augenuntersuchung::find($request['id']);
            $data = $request->all();

            $augenuntersuchung->update($data);

            $dokumente = $data['dokumente'];

            $this->saveDokumente($augenuntersuchung, $dokumente);

            // $db_dokuments = array();
            // $dok_ids = array();

            // foreach ($dokumente as $dokument) {
            //    $db_dokument = Dokument::find($dokument['id']);
            //    $db_dokuments[] = $db_dokument;
            //    $dok_ids[] = $db_dokument->id;
            //    $db_dokument->update($dokument);

            //    $tags = $dokument['tags'];
            //    $tag_ids = array_map(function ($tag) {
            //       return $tag['id'];
            //    }, $tags);
            //    $db_dokument->tags()->sync($tag_ids);
            // }

            // $augenuntersuchung->dokumente()->sync($dok_ids);
        }

        return response()->json([
            'success' => 'Augenuntersuchung updated.',
            'id' => $augenuntersuchung->id,
        ]);
    }

    public function store_v1(Request $request)
    {
        if ($request['id'] == 0) {

            $data = $request->all();

            $augenuntersuchung = Augenuntersuchung_v1::create($data);

            //   $augenuntersuchung->aktive_au = $data['aktive_au'];
            //    $augenuntersuchung->aktive_gonio = $data['aktive_gonio'];
            //    $augenuntersuchung->anmerkungen = $data['anmerkungen'];
            //    $augenuntersuchung->arzt_email = $data['arzt_email'];
            //    $augenuntersuchung->arzt_id = $data['arzt_id'];
            //    $augenuntersuchung->arzt_land = $data['arzt_land'];
            //    $augenuntersuchung->arzt_land_kuerzel = $data['arzt_land_kuerzel'];
            //    $augenuntersuchung->arzt_nachname = $data['arzt_nachname'];
            //    $augenuntersuchung->arzt_ort = $data['arzt_ort'];
            //    $augenuntersuchung->arzt_plz = $data['arzt_plz'];
            //    $augenuntersuchung->arzt_praxis = $data['arzt_praxis'];
            //    $augenuntersuchung->arzt_strasse = $data['arzt_strasse'];
            //    $augenuntersuchung->arzt_telefon_1 = $data['arzt_telefon_1'];
            //    $augenuntersuchung->arzt_telefon_2 = $data['arzt_telefon_2'];
            //    $augenuntersuchung->arzt_titel = $data['arzt_titel'];
            //    $augenuntersuchung->arzt_vorname = $data['arzt_vorname'];
            //    $augenuntersuchung->arzt_website = $data['arzt_website'];
            //    $augenuntersuchung->cea_choroidhypo = $data['cea_choroidhypo'];
            //    $augenuntersuchung->cea_id = $data['cea_id'];
            //    $augenuntersuchung->cea_kolobom = $data['cea_kolobom'];
            //    $augenuntersuchung->cea_sonstige = $data['cea_sonstige'];
            //    $augenuntersuchung->cea_sonstige_angaben = $data['cea_sonstige_angaben'];
            //    $augenuntersuchung->datum = $data['datum'];
            //    $augenuntersuchung->distichiasis_id = $data['distichiasis_id'];

            //    $augenuntersuchung->dyslpectabnorm_gewebebruecken = $data['dyslpectabnorm_gewebebruecken'];
            //    $augenuntersuchung->dyslpectabnorm_id = $data['dyslpectabnorm_id'];
            //    $augenuntersuchung->dyslpectabnorm_kolobom = $data['dyslpectabnorm_kolobom'];
            //    $augenuntersuchung->dyslpectabnorm_totaldyspl = $data['dyslpectabnorm_totaldyspl'];
            //    $augenuntersuchung->ektropium_id = $data['ektropium_id'];
            //    $augenuntersuchung->entropium_id = $data['entropium_id'];
            //    $augenuntersuchung->foto = $data['foto'];

            //    $augenuntersuchung->gonioskopie = $data['gonioskopie'];
            //    $augenuntersuchung->hund_id = $data['hund_id'];
            //    $augenuntersuchung->hypoplasie_mikropapille_id = $data['hypoplasie_mikropapille_id'];
            //    $augenuntersuchung->ica_weite_id = $data['ica_weite_id'];
            //    $augenuntersuchung->icaa_grad_id = $data['icaa_grad_id'];
            //    $augenuntersuchung->icaa_id = $data['icaa_id'];
            //    $augenuntersuchung->katarakt_cortikalis = $data['katarakt_cortikalis'];
            //    $augenuntersuchung->katarakt_kon_id = $data['katarakt_kon_id'];
            //    $augenuntersuchung->katarakt_nonkon_id = $data['katarakt_nonkon_id'];
            //    $augenuntersuchung->katarakt_nuklearis = $data['katarakt_nuklearis'];
            //    $augenuntersuchung->katarakt_polpost = $data['katarakt_polpost'];
            //    $augenuntersuchung->katarakt_punctata = $data['katarakt_punctata'];
            //    $augenuntersuchung->katarakt_sonstige = $data['katarakt_sonstige'];
            //    $augenuntersuchung->katarakt_sonstige_angaben = $data['katarakt_sonstige_angaben'];
            //    $augenuntersuchung->katarakt_sutura_ant = $data['katarakt_sutura_ant'];
            //    $augenuntersuchung->korneadystrophie_id = $data['korneadystrophie_id'];
            //    $augenuntersuchung->linsenluxation_id = $data['linsenluxation_id'];
            //    $augenuntersuchung->methode_id = $data['methode_id'];
            //    $augenuntersuchung->mikrophthalamie_id = $data['mikrophthalamie_id'];
            //    $augenuntersuchung->mpp_id = $data['mpp_id'];
            //    $augenuntersuchung->mpp_iris = $data['mpp_iris'];
            //    $augenuntersuchung->mpp_komea = $data['mpp_komea'];
            //    $augenuntersuchung->mpp_linse = $data['mpp_linse'];
            //    $augenuntersuchung->mpp_vorderkammer = $data['mpp_vorderkammer'];
            //    $augenuntersuchung->mydriatikum = $data['mydriatikum'];
            //    $augenuntersuchung->open = $data['open'];
            //    $augenuntersuchung->ophtalmoskopie_d = $data['ophtalmoskopie_d'];
            //    $augenuntersuchung->ophtalmoskopie_ind = $data['ophtalmoskopie_ind'];
            //    $augenuntersuchung->phtvlphpv_id = $data['phtvlphpv_id'];
            //    $augenuntersuchung->phtvlphpv_nfrei_id = $data['phtvlphpv_nfrei_id'];
            //    $augenuntersuchung->pla_id = $data['pla_id'];
            //    $augenuntersuchung->pra_rd_id = $data['pra_rd_id'];
            //    $augenuntersuchung->primaerglaukom_id = $data['primaerglaukom_id'];
            //    $augenuntersuchung->rd_geo = $data['rd_geo'];
            //    $augenuntersuchung->rd_id = $data['rd_id'];
            //    $augenuntersuchung->rd_multifokal = $data['rd_multifokal'];
            //    $augenuntersuchung->rd_total = $data['rd_total'];
            //    $augenuntersuchung->spaltlampe = $data['spaltlampe'];
            //    $augenuntersuchung->tonometrie = $data['tonometrie'];
            //    $augenuntersuchung->typ = $data['typ'];
            //    $augenuntersuchung->weitere_methode = $data['weitere_methode'];
            //    $augenuntersuchung->weitere_methode_b = $data['weitere_methode_b'];

            //    $augenuntersuchung->gesamtergebnis = $data['gesamtergebnis'];
            //    $augenuntersuchung->dokumente = $data['dokumente'];
            //    $augenuntersuchung->typ = $data['typ'];

            return response()->json([
                'success' => 'Augenuntersuchung gespeichert.',
                'id' => $augenuntersuchung->id,
            ]);

            // $augenuntersuchung = new Augenuntersuchung();
            // if ( $request['hund_id'] ) $augenuntersuchung->hund_id = $request['hund_id'];
            // if ( $request['datum'] ) $augenuntersuchung->datum = $request['datum'];

            //  $augenuntersuchung->save();
            //  return $augenuntersuchung;

        } else {
            $augenuntersuchung = Augenuntersuchung_v1::find($request['id']);

            $augenuntersuchung->update($request->all());

            return response()->json([
                'success' => 'Augenuntersuchung updated.',
                'id' => $augenuntersuchung->id,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Augenuntersuchung $augenuntersuchung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Augenuntersuchung $augenuntersuchung)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Augenuntersuchung  $augenuntersuchung
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $untersuchung = Augenuntersuchung::find($request['id']);

        if ($untersuchung) {
            Augenuntersuchung::destroy($request['id']);

            return response()->json([
                'success' => 'Augenuntersuchung gelöscht.',
            ]);
        }
    }
}
