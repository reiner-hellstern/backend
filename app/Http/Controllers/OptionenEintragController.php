<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OptionenEintragController extends Controller
{
    public function index($optionenlisteId)
    {
        $liste = \App\Models\Optionenliste::findOrFail($optionenlisteId);
        $model = $liste->model;
        $modelClass = Str::startsWith($model, '\\') ? $model : '\\' . $model;

        $query = $modelClass::query();

        // Sortierung bestimmen basierend auf verfügbaren Spalten
        if (\Schema::hasColumn((new $modelClass())->getTable(), 'sortierung')) {
            $entries = $query->orderBy('sortierung')->get();
        } elseif (\Schema::hasColumn((new $modelClass())->getTable(), 'order')) {
            $entries = $query->orderBy('order')->get();
        } else {
            $entries = $query->orderBy('name')->get();
        }

        return response()->json([
            'success' => true,
            'data' => $entries,
        ]);
    }

    public function store(Request $request, $optionenlisteId)
    {
        try {
            $liste = \App\Models\Optionenliste::findOrFail($optionenlisteId);
            $model = $liste->model;
            $modelClass = Str::startsWith($model, '\\') ? $model : '\\' . $model;

            // Bestimme das nächste Sortierungsfeld
            $sortField = 'sortierung';
            if (! \Schema::hasColumn((new $modelClass())->getTable(), 'sortierung')) {
                $sortField = 'order';
            }

            // Bestimme die nächste Sortierungsnummer
            $nextSort = $modelClass::max($sortField) + 1;

            // Temporär Mass Assignment deaktivieren
            \Illuminate\Database\Eloquent\Model::unguard();

            // Neuen Eintrag erstellen
            $entry = new $modelClass();
            $data = $request->all();
            $data[$sortField] = $nextSort;

            // Felder einzeln setzen
            foreach ($data as $field => $value) {
                if ($field !== 'created_at' && $field !== 'updated_at') {
                    $entry->$field = $value;
                }
            }
            $entry->save();

            // Mass Assignment wieder aktivieren
            \Illuminate\Database\Eloquent\Model::reguard();

            return response()->json([
                'success' => true,
                'data' => $entry,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Database\Eloquent\Model::reguard();

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $optionenlisteId, $id)
    {
        try {
            $liste = \App\Models\Optionenliste::findOrFail($optionenlisteId);
            $model = $liste->model;
            $modelClass = Str::startsWith($model, '\\') ? $model : '\\' . $model;
            $entry = $modelClass::findOrFail($id);

            // Temporär Mass Assignment deaktivieren
            \Illuminate\Database\Eloquent\Model::unguard();

            // Einzelne Felder setzen
            $data = $request->except(['id']);
            foreach ($data as $field => $value) {
                if ($field !== 'created_at' && $field !== 'updated_at') {
                    $entry->$field = $value;
                }
            }
            $entry->save();

            // Mass Assignment wieder aktivieren
            \Illuminate\Database\Eloquent\Model::reguard();

            return response()->json([
                'success' => true,
                'data' => $entry,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Database\Eloquent\Model::reguard();

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($optionenlisteId, $id)
    {
        try {
            $liste = \App\Models\Optionenliste::findOrFail($optionenlisteId);
            $model = $liste->model;
            $modelClass = Str::startsWith($model, '\\') ? $model : '\\' . $model;
            $entry = $modelClass::findOrFail($id);
            $entry->delete();

            return response()->json([
                'success' => true,
                'message' => 'Eintrag erfolgreich gelöscht.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function reorder(Request $request, $optionenlisteId)
    {
        try {
            $liste = \App\Models\Optionenliste::findOrFail($optionenlisteId);
            $model = $liste->model;
            $modelClass = Str::startsWith($model, '\\') ? $model : '\\' . $model;
            $ids = $request->input('ids', []);

            // Temporär Mass Assignment deaktivieren
            \Illuminate\Database\Eloquent\Model::unguard();

            // Prüfe welches Sortierungsfeld vorhanden ist
            $sortField = 'sortierung';
            if (! \Schema::hasColumn((new $modelClass())->getTable(), 'sortierung')) {
                $sortField = 'order';
            }

            foreach ($ids as $index => $id) {
                $entry = $modelClass::find($id);
                if ($entry) {
                    $entry->$sortField = $index + 1;
                    $entry->save();
                }
            }

            // Mass Assignment wieder aktivieren
            \Illuminate\Database\Eloquent\Model::reguard();

            return response()->json([
                'success' => true,
                'message' => 'Reihenfolge erfolgreich aktualisiert.',
            ]);
        } catch (\Exception $e) {
            \Illuminate\Database\Eloquent\Model::reguard();

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
