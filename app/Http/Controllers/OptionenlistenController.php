<?php

namespace App\Http\Controllers;

use App\Models\Optionenliste;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionenlistenController extends Controller
{
    public function index(Request $request)
    {
        $query = Optionenliste::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                ->orWhere('model', 'like', "%$search%")
                ->orWhere('beschreibung', 'like', "%$search%")
                ->orWhere('sortierung', 'like', "%$search%");
        }
        $perPage = $request->input('per_page', 25);
        $optionenlisten = $query->with('section')->orderBy('name')->paginate($perPage);

        return JsonResource::collection($optionenlisten);
    }

    public function show($id)
    {
        $optionenliste = Optionenliste::with('section')->findOrFail($id);

        return new JsonResource($optionenliste);
    }

    public function update(Request $request, $id)
    {
        try {
            $optionenliste = Optionenliste::findOrFail($id);
            $optionenliste->update($request->only(['name', 'beschreibung', 'section_id', 'sortierung']));

            return response()->json([
                'success' => true,
                'data' => new JsonResource($optionenliste->fresh('section')),
                'message' => 'Optionenliste erfolgreich aktualisiert.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
