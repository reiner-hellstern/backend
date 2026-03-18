<?php

namespace App\Http\Controllers;

use App\Http\Resources\MainMenuItemResource;
use App\Models\MainMenuItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainMenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $id = Auth::id();
        if (! $id) {
            return;
        }

        $user = User::find($id);
        $roles = $user->roles;

        // Sammle alle zugewiesenen Menü-IDs für alle Rollen des Users
        $roleIds = $roles->pluck('id')->toArray();
        $assignedMenuIds = DB::table('main_menu_item_role')
            ->whereIn('role_id', $roleIds)
            ->pluck('main_menu_item_id')
            ->toArray();

        // Hauptmenüpunkte, die irgendeiner Rolle des Users zugewiesen sind
        // Direkte Abfrage ohne whereHas
        $main_menu_items = MainMenuItem::aktiv()
            ->orderBy('order')
            ->where('parent_id', 0)
            ->where(function ($query) use ($roleIds) {
                // Direkt zugewiesene Hauptmenüpunkte
                $query->whereIn('id', function ($subQuery) use ($roleIds) {
                    $subQuery->select('main_menu_item_id')
                        ->from('main_menu_item_role')
                        ->whereIn('role_id', $roleIds);
                })
                // ODER Hauptmenüpunkte, die Kinder haben, welche zugewiesen sind
                    ->orWhereIn('id', function ($subQuery) use ($roleIds) {
                        $subQuery->select('parent_id')
                            ->from('main_menu_items')
                            ->whereIn('id', function ($innerQuery) use ($roleIds) {
                                $innerQuery->select('main_menu_item_id')
                                    ->from('main_menu_item_role')
                                    ->whereIn('role_id', $roleIds);
                            })
                            ->whereNotNull('parent_id');
                    });
            })
            ->get();

        // Übergib die zugewiesenen Menü-IDs als Filter an die Resource
        request()->merge(['assigned_menu_ids' => $assignedMenuIds]);

        return MainMenuItemResource::collection($main_menu_items);
    }

    public function role(Request $request, $id = null)
    {
        $roleId = $id ?: $request->input('role_id');

        // Wenn keine Rolle angegeben);

        if (! $roleId) {
            $request->merge(['admin_mode' => true]);
            // Keine Rolle angegeben: Alle Menüpunkte als hierarchische Struktur liefern (nur Hauptmenüpunkte)
            $main_menu_items = MainMenuItem::orderBy('order')->where('parent_id', 0)->get();

            return MainMenuItemResource::collection($main_menu_items);
        } else {
            // Alle Menü-IDs, die der Rolle explizit zugewiesen sind
            $assignedMenuIds = \DB::table('main_menu_item_role')
                ->where('role_id', $roleId)
                ->pluck('main_menu_item_id')
                ->toArray();

            // Hauptmenüpunkte, die entweder selbst oder über Submenüs zugewiesen sind
            $main_menu_items = MainMenuItem::where('parent_id', 0)
                ->where(function ($query) use ($assignedMenuIds) {
                    $query->whereIn('id', $assignedMenuIds)
                        // ODER Hauptmenüpunkte, die Kinder haben, welche zugewiesen sind
                        ->orWhereIn('id', function ($subQuery) use ($assignedMenuIds) {
                            $subQuery->select('parent_id')
                                ->from('main_menu_items')
                                ->whereIn('id', $assignedMenuIds)
                                ->whereNotNull('parent_id');
                        });
                })
                ->orderBy('order')
                ->get();

            // Übergebe die zugewiesenen Menü-IDs als Filter an die Resource
            $request->merge(['assigned_menu_ids' => $assignedMenuIds]);

            $collection = MainMenuItemResource::collection($main_menu_items);

            // Füge die zugewiesenen Menü-IDs zur Response hinzu
            return $collection->additional([
                'assigned_menu_ids' => $assignedMenuIds,
            ]);
        }
    }

    /**
     * Synchronisiert MenuItems mit einer Rolle
     */
    public function syncRole(Request $request)
    {
        \Log::info('SyncRole called with:', $request->all());

        $roleId = $request->input('role_id');
        $menuItemIds = $request->input('menu_item_ids');

        \Log::info('SyncRole Debug:', [
            'role_id' => $roleId,
            'menu_item_ids_count' => count($menuItemIds ?? []),
            'menu_item_ids' => $menuItemIds,
        ]);

        // Lösche alle bestehenden Zuweisungen für diese Rolle
        $deletedCount = DB::table('main_menu_item_role')->where('role_id', $roleId)->delete();
        \Log::info('Deleted existing entries:', ['count' => $deletedCount]);

        // Füge neue Zuweisungen hinzu
        $insertData = [];
        foreach ($menuItemIds as $menuItemId) {
            $insertData[] = [
                'role_id' => $roleId,
                'main_menu_item_id' => $menuItemId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (! empty($insertData)) {
            DB::table('main_menu_item_role')->insert($insertData);
            \Log::info('Inserted new entries:', ['count' => count($insertData)]);
        }

        // Verify insertion
        $finalCount = DB::table('main_menu_item_role')->where('role_id', $roleId)->count();
        \Log::info('Final count in database:', ['count' => $finalCount]);

        return response()->json([
            'message' => 'MenuItems erfolgreich mit Rolle synchronisiert',
            'role_id' => $roleId,
            'menu_item_count' => count($menuItemIds),
            'final_db_count' => $finalCount,
            'notification' => [
                'type' => 'success',
                'title' => 'Synchronisierung erfolgreich',
                'text' => 'Die Menüzuweisungen für die Rolle wurden gespeichert.',
            ],
        ]);
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
    public function show(MainMenuItem $mainMenuItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MainMenuItem $mainMenuItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(MainMenuItem $mainMenuItem)
    {
        //
    }

    /**
     * Liefert alle MenuItems als hierarchische Struktur für Admin-Interface
     */
    public function indexAll()
    {
        $main_menu_items = MainMenuItem::with('children')
            ->where('parent_id', 0)
            ->orderBy('order')
            ->get();

        // Füge Admin-Flag zum Request hinzu, damit Resource alle Items (auch inaktive) lädt
        request()->merge(['admin_mode' => true]);

        return MainMenuItemResource::collection($main_menu_items);
    }

    /**
     * Aktualisiert die Reihenfolge der Menüpunkte
     */
    public function updateOrder(Request $request)
    {
        $items = $request->input('items');

        foreach ($items as $item) {
            MainMenuItem::where('id', $item['id'])
                ->update(['order' => $item['order']]);
        }

        return response()->json([
            'message' => 'Reihenfolge erfolgreich aktualisiert',
            'notification' => [
                'type' => 'success',
                'title' => 'Reihenfolge gespeichert',
                'text' => 'Die Menüreihenfolge wurde erfolgreich aktualisiert.',
            ],
        ]);
    }

    /**
     * Aktualisiert die Aktivierung der Menüpunkte
     */
    public function updateActivation(Request $request)
    {
        $items = $request->input('items');

        foreach ($items as $item) {
            MainMenuItem::where('id', $item['id'])
                ->update(['aktiv' => $item['aktiv']]);
        }

        return response()->json([
            'message' => 'Aktivierung erfolgreich aktualisiert',
            'notification' => [
                'type' => 'success',
                'title' => 'Aktivierung gespeichert',
                'text' => 'Die Aktivierungsänderungen wurden erfolgreich gespeichert.',
            ],
        ]);
    }
}
