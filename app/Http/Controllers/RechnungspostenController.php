<?php

namespace App\Http\Controllers;

use App\Models\Rechnungsposten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RechnungspostenController extends Controller
{
    /**
     * Update the specified rechnungsposten.
     */
    public function update(Request $request, Rechnungsposten $rechnungsposten)
    {
        $request->validate([
            'beschreibung' => 'required|string|max:255',
            'menge' => 'required|numeric|min:0',
            'einzelpreis' => 'required|numeric|min:0',
            'gebuehr_id' => 'nullable|exists:gebuehrenkatalog,id',
            'notizen' => 'nullable|string',
        ]);

        $rechnungsposten->update([
            'beschreibung' => $request->beschreibung,
            'menge' => $request->menge,
            'einzelpreis' => $request->einzelpreis,
            'gebuehr_id' => $request->gebuehr_id,
            'notizen' => $request->notizen,
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => 'Rechnungsposten erfolgreich aktualisiert',
            'error' => null,
            'data' => $rechnungsposten->load('gebuehr'),
        ]);
    }

    /**
     * Remove the specified rechnungsposten.
     */
    public function destroy(Rechnungsposten $rechnungsposten)
    {
        $rechnungsposten->delete();

        return response()->json([
            'success' => 'Rechnungsposten erfolgreich gelöscht',
            'error' => null,
            'data' => null,
        ]);
    }
}
