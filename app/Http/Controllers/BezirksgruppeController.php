<?php

namespace App\Http\Controllers;

use App\Models\Bezirksgruppe;
use App\Models\Bund;
use App\Models\Landesgruppe;
use App\Models\Postleitzahl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BezirksgruppeController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Bezirksgruppe $bezirksgruppe) {}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bezirksgruppe  $bezirksgruppe
     * @return \Illuminate\Http\Response
     */
    public function plz($plz)
    {

        $bezirksgruppe = Bezirksgruppe::with(['landesgruppe', 'postleitzahlen'])->select('bezirksgruppen.*')
            ->leftjoin('postleitzahlen', 'postleitzahlen.bezirksgruppe_id', '=', 'bezirksgruppen.id')
            ->where('postleitzahlen.plz', $plz)
            ->get();

        if ($bezirksgruppe) {
            return [
                'id' => $bezirksgruppe[0]['id'],
                'bezirksgruppe' => $bezirksgruppe[0]['name'],
                'landesgruppe' => $bezirksgruppe[0]['landesgruppe']['name'],

            ];
        } else {
            return [
                'id' => 0,
                'bezirksgruppe' => 'Keine Bezirksgruppe gefunden',
                'landesgruppe' => '',

            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bezirksgruppe  $bezirksgruppe
     * @return \Illuminate\Http\Response
     */
    public function geojson(Request $request)
    {

        $landesgruppe_id = $request->landesgruppe_id;
        $bezirksgruppe_id = $request->bezirksgruppe_id;
        $mittelpunkt_plz = $request->plz;
        $umkreis = $request->umkreis;

        if ($umkreis > 50) {
            return [
                'bzgs' => [],
                'lgs' => [],
                'plzs' => [],
                'bund' => [],
                'error' => 'Umkreis darf nicht größer als 50 km sein',
            ];
        }

        $plzs = DB::select('SELECT dest.plz,
         ACOS(
               SIN(RADIANS(src.breitengrad)) * SIN(RADIANS(dest.breitengrad)) 
               + COS(RADIANS(src.breitengrad)) * COS(RADIANS(dest.breitengrad))
               * COS(RADIANS(src.laengengrad) - RADIANS(dest.laengengrad))
         ) * 6380 AS distance
         FROM postleitzahlen dest
         CROSS JOIN postleitzahlen src
         WHERE src.plz = ?
         HAVING distance < ?
         ORDER BY distance;', [$mittelpunkt_plz, $umkreis]);

        $plz_ids = [];
        foreach ($plzs as $plz) {
            $plz_ids[] = $plz->plz;
        }

        // return [
        //    'bzgs' => [],
        //    'lgs' => [],
        //    'plzs' => $plz_ids,
        //    'bund' => [],
        //    'error' => ''
        // ];

        $bezirksgruppe = '';
        $postleitzahl = '';
        $bund = '';

        if (count($plz_ids) > 0) {
            $bezirksgruppen = Bezirksgruppe::with(['postleitzahlen'])->select('bezirksgruppen.*')
                ->leftjoin('postleitzahlen', 'postleitzahlen.bezirksgruppe_id', '=', 'bezirksgruppen.id')
                ->when(count($plz_ids), function ($query) use ($plz_ids) {
                    $query->whereIn('postleitzahlen.plz', $plz_ids);
                })
                ->groupby('bezirksgruppen.id')->get();

            $bezirksgruppe = Bezirksgruppe::with(['postleitzahlen'])->select('bezirksgruppen.*')
                ->leftjoin('postleitzahlen', 'postleitzahlen.bezirksgruppe_id', '=', 'bezirksgruppen.id')
                ->where('postleitzahlen.plz', $mittelpunkt_plz)
                ->first();

            $landesgruppen = [];
            $postleitzahlen = Postleitzahl::whereIn('postleitzahlen.plz', $plz_ids)->get();
            $postleitzahl = Postleitzahl::where('plz', $mittelpunkt_plz)->first();

        } elseif ($bezirksgruppe_id != 0) {

            $bzg = Bezirksgruppe::with(['postleitzahlen'])->find($bezirksgruppe_id);
            $bezirksgruppen = [$bzg];
            $landesgruppen = [];
            $postleitzahlen = $bzg->postleitzahlen;

        } elseif ($landesgruppe_id != 0) {

            $lg = Landesgruppe::with(['bezirksgruppen'])->find($landesgruppe_id);
            $landesgruppen = [$lg];
            $bezirksgruppen = $lg->bezirksgruppen;
            $postleitzahlen = [];

        } else {
            $bezirksgruppen = [];
            $postleitzahlen = [];
            $landesgruppen = Landesgruppe::all();
            $bund = Bund::find(1);
        }

        //  $tmp = $bezirksgruppen->postleitzahlen;
        return [
            'bzgs' => $bezirksgruppen,
            'bzg' => $bezirksgruppe,
            'lgs' => $landesgruppen,
            'plzs' => $postleitzahlen,
            'plz' => $postleitzahl,
            'bund' => $bund,
            'error' => '',
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bezirksgruppe $bezirksgruppe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bezirksgruppe $bezirksgruppe)
    {
        //
    }

    /**
     * Get PLZ assignments for a specific Bezirksgruppe
     */
    public function plzZuordnungen(Request $request, $id)
    {
        $bezirksgruppe = Bezirksgruppe::findOrFail($id);

        $query = $bezirksgruppe->postleitzahlen();

        // Suche
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('plz', 'LIKE', "%{$search}%")
                    ->orWhere('ort', 'LIKE', "%{$search}%");
            });
        }

        // Sortierung
        $sortField = $request->get('sort_field', 'plz');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $plzZuordnungen = $query->paginate($request->get('per_page', 50));

        // Statistiken berechnen
        $allPLZ = $bezirksgruppe->postleitzahlen();
        $statistics = [
            'total_plz' => $allPLZ->count(),
            'total_orte' => $allPLZ->distinct('ort')->count('ort'),
            'total_bundeslaender' => 0, // Keine Bundesland-Daten verfügbar
        ];

        // Transform data for frontend - add missing fields
        $plzZuordnungen->getCollection()->transform(function ($plz) {
            $plz->postleitzahl = $plz->plz;
            $plz->bundesland = 'N/A'; // No bundesland data in DB
            $plz->kreis = 'N/A'; // No kreis data in DB
            $plz->zugeordnet_am = $plz->created_at;

            return $plz;
        });

        return response()->json([
            'success' => true,
            'data' => $plzZuordnungen->items(),
            'meta' => [
                'current_page' => $plzZuordnungen->currentPage(),
                'from' => $plzZuordnungen->firstItem(),
                'last_page' => $plzZuordnungen->lastPage(),
                'per_page' => $plzZuordnungen->perPage(),
                'to' => $plzZuordnungen->lastItem(),
                'total' => $plzZuordnungen->total(),
            ],
            'statistics' => $statistics,
        ]);
    }

    /**
     * Get available Bundesländer for PLZ assignments of a specific Bezirksgruppe
     */
    public function plzZuordnungenBundeslaender($id)
    {
        // Keine Bundesland-Daten in der aktuellen DB-Struktur
        return response()->json([
            'success' => true,
            'bundeslaender' => [],
        ]);
    }

    /**
     * Remove a PLZ assignment from a Bezirksgruppe
     */
    public function removePlzZuordnung($bezirksgruppeId, $plzId)
    {
        $bezirksgruppe = Bezirksgruppe::findOrFail($bezirksgruppeId);
        $postleitzahl = Postleitzahl::findOrFail($plzId);

        // PLZ-Zuordnung entfernen
        $bezirksgruppe->postleitzahlen()->detach($postleitzahl->id);

        return response()->json([
            'success' => true,
            'message' => 'PLZ-Zuordnung erfolgreich entfernt',
        ]);
    }
}
