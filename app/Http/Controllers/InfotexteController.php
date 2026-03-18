<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInfotexteRequest;
use App\Http\Requests\UpdateInfotexteRequest;
use App\Models\Infotexte;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Silber\Bouncer\Database\Role;

class InfotexteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Infotexte::with(['section', 'assignables.assignable']);
            if ($request->has('search') && ! empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('thema', 'like', "%{$search}%")
                        ->orWhere('vue_component', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('titel', 'like', "%{$search}%")
                        ->orWhere('text', 'like', "%{$search}%")
                        ->orWhereHas('section', function ($sq) use ($search) {
                            $sq->where('name', 'like', "%{$search}%")
                                ->orWhere('name_kurz', 'like', "%{$search}%");
                        });
                });
            }
            if ($request->has('section_id') && ! empty($request->section_id)) {
                $query->where('section_id', $request->section_id);
            }
            if ($request->has('aktiv') && $request->aktiv !== '') {
                $query->where('aktiv', (bool) $request->aktiv);
            }
            $sortField = $request->get('sort_field', 'id');
            $sortDirection = $request->get('sort_direction', 'asc');
            $allowedSortFields = ['id', 'thema', 'position', 'vue_component', 'slug', 'titel', 'aktiv', 'created_at'];
            if (in_array($sortField, $allowedSortFields)) {
                $query->orderBy($sortField, $sortDirection);
            }
            $perPage = $request->get('per_page', 25);
            $infotexte = $query->paginate($perPage);
            $data = $infotexte->map(function ($infotext) {
                $assignableData = $this->getAssignableData($infotext);

                return [
                    'id' => $infotext->id,
                    'section' => $infotext->section ? [
                        'id' => $infotext->section->id,
                        'name' => $infotext->section->name,
                        'name_kurz' => $infotext->section->name_kurz,
                    ] : null,
                    'thema' => $infotext->thema,
                    'position' => $infotext->position,
                    'vue_component' => $infotext->vue_component,
                    'slug' => $infotext->slug,
                    'titel' => $infotext->titel,
                    'text' => $infotext->text,
                    'aktiv' => $infotext->aktiv,
                    'created_at' => $infotext->created_at,
                    'updated_at' => $infotext->updated_at,
                    'roles_count' => $assignableData['roles_count'],
                    'assignables_summary' => $assignableData['summary'],
                    'assignables' => $infotext->assignables->map(function ($assignable) {
                        return [
                            'id' => $assignable->assignable->id,
                            'name' => $this->getDisplayName($assignable->assignable),
                            'type' => class_basename($assignable->assignable_type),
                        ];
                    })->toArray(),
                ];
            });

            return response()->json([
                'success' => 'Infotexte erfolgreich geladen.',
                'data' => $data,
                'meta' => [
                    'current_page' => $infotexte->currentPage(),
                    'last_page' => $infotexte->lastPage(),
                    'per_page' => $infotexte->perPage(),
                    'total' => $infotexte->total(),
                    'from' => $infotexte->firstItem(),
                    'to' => $infotexte->lastItem(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden der Infotexte: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreInfotexteRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $section = Section::findOrFail($data['section_id']);
            $data['section'] = $section;
            $infotexte = Infotexte::create($data);
            $infotexte->load(['section', 'assignables.assignable']);

            return response()->json([
                'success' => 'Infotext wurde erfolgreich erstellt.',
                'data' => $infotexte,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Erstellen des Infotextes: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(Infotexte $infotexte): JsonResponse
    {
        try {
            $infotexte->load(['section', 'assignables.assignable']);
            $assignableData = $this->getAssignableData($infotexte);
            $data = [
                'id' => $infotexte->id,
                'section' => $infotexte->section ? [
                    'id' => $infotexte->section->id,
                    'name' => $infotexte->section->name,
                    'name_kurz' => $infotexte->section->name_kurz,
                ] : null,
                'thema' => $infotexte->thema,
                'position' => $infotexte->position,
                'vue_component' => $infotexte->vue_component,
                'slug' => $infotexte->slug,
                'titel' => $infotexte->titel,
                'text' => $infotexte->text,
                'aktiv' => $infotexte->aktiv,
                'created_at' => $infotexte->created_at,
                'updated_at' => $infotexte->updated_at,
                'assignables_detailed' => [
                    'roles' => $assignableData['roles'],
                ],
            ];

            return response()->json([
                'success' => 'Infotext erfolgreich geladen.',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden des Infotextes: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateInfotexteRequest $request, Infotexte $infotexte): JsonResponse
    {
        try {
            $data = $request->validated();
            if (isset($data['section_id'])) {
                $section = Section::findOrFail($data['section_id']);
                $data['section'] = $section;
            }
            $infotexte->update($data);
            $infotexte->load(['section', 'assignables.assignable']);

            return response()->json([
                'success' => 'Infotext wurde erfolgreich aktualisiert.',
                'data' => $infotexte,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Aktualisieren des Infotextes: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Infotexte $infotexte): JsonResponse
    {
        try {
            $infotexte->assignables()->delete();
            $infotexte->delete();

            return response()->json([
                'success' => 'Infotext wurde erfolgreich gelöscht.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Löschen des Infotextes: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function getAssignableData($infotext): array
    {
        $roles = [];
        $rolesCount = 0;
        foreach ($infotext->assignables as $assignable) {
            if ($assignable->assignable_type === 'Silber\\Bouncer\\Database\\Role') {
                $roles[] = [
                    'id' => $assignable->assignable->id,
                    'name' => $assignable->assignable->name,
                    'title' => $assignable->assignable->title ?? $assignable->assignable->name,
                ];
                $rolesCount++;
            }
        }
        $summary = [];
        if ($rolesCount > 0) {
            $summary[] = "$rolesCount Rolle(n)";
        }

        return [
            'roles' => $roles,
            'roles_count' => $rolesCount,
            'summary' => implode(', ', $summary),
        ];
    }

    private function getDisplayName($assignable): string
    {
        if ($assignable instanceof Role) {
            return $assignable->title ?? $assignable->name;
        }

        return 'Unknown';
    }

    public function assignRole(Request $request, Infotexte $infotexte): JsonResponse
    {
        try {
            $request->validate([
                'role_ids' => 'required|array',
                'role_ids.*' => 'exists:roles,id',
            ]);
            $addedCount = 0;
            foreach ($request->role_ids as $roleId) {
                $role = Role::findOrFail($roleId);
                $exists = $infotexte->assignables()
                    ->where('assignable_type', get_class($role))
                    ->where('assignable_id', $role->id)
                    ->exists();
                if (! $exists) {
                    $infotexte->assignables()->create([
                        'assignable_type' => get_class($role),
                        'assignable_id' => $role->id,
                    ]);
                    $addedCount++;
                }
            }

            return response()->json([
                'success' => $addedCount > 0 ? "$addedCount Rolle(n) wurden hinzugefügt" : 'Alle Rollen sind bereits zugeordnet',
                'data' => ['added_count' => $addedCount],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Zuordnen der Rolle(n): ' . $e->getMessage(),
            ], 500);
        }
    }

    public function unassignRole(Infotexte $infotexte, Role $role): JsonResponse
    {
        try {
            $infotexte->assignables()
                ->where('assignable_type', get_class($role))
                ->where('assignable_id', $role->id)
                ->delete();

            return response()->json([
                'success' => 'Rolle wurde erfolgreich entfernt',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Entfernen der Rolle: ' . $e->getMessage(),
            ], 500);
        }
    }
}
