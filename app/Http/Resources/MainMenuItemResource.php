<?php

namespace App\Http\Resources;

use App\Models\MainMenuItem;
use Illuminate\Http\Resources\Json\JsonResource;

class MainMenuItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Prüfe, ob ein Menü-Filter im Request-Kontext gesetzt ist
        $assignedMenuIds = $request->get('assigned_menu_ids');
        $adminMode = $request->get('admin_mode', false);

        if (is_array($assignedMenuIds) && count($assignedMenuIds) > 0) {
            // Nur zugewiesene Submenüpunkte laden
            $children = MainMenuItem::aktiv()
                ->orderBy('order')
                ->where('parent_id', $this->id)
                ->whereIn('id', $assignedMenuIds)
                ->get();
        } elseif ($adminMode) {
            // Admin-Modus: Alle Submenüpunkte laden (auch inaktive)
            $children = MainMenuItem::orderBy('order')
                ->where('parent_id', $this->id)
                ->get();
        } else {
            // Normale Abfrage: Nur aktive Submenüpunkte laden
            $children = MainMenuItem::aktiv()
                ->orderBy('order')
                ->where('parent_id', $this->id)
                ->get();
        }

        // Stelle sicher, dass assigned_menu_ids und admin_mode an Kinder-Resources weitergegeben wird
        $childrenCollection = MainMenuItemResource::collection($children);
        if ($assignedMenuIds || $adminMode) {
            $childrenCollection = $childrenCollection->each(function ($item) use ($assignedMenuIds, $adminMode, $request) {
                if ($assignedMenuIds) {
                    $item->resource->assignedMenuIds = $assignedMenuIds;
                }
                if ($adminMode) {
                    $request->merge(['admin_mode' => true]);
                }
            });
        }

        $result = [
            'id' => $this->id,
            'title' => $this->title,
            'name' => $this->title, // Alias für Frontend
            'route' => $this->to, // Alias für Frontend
            'order' => $this->order,
            'to' => $this->to,
            'icon' => $this->icon,
            'parent_id' => $this->parent_id,
            'aktiv' => (bool) $this->aktiv,
            'items' => $childrenCollection,
            'children' => $childrenCollection, // Alias für Frontend
        ];

        return $result;
    }
}
