<?php

namespace App\Http\Controllers;

use App\Models\InfotexteTemplate;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Silber\Bouncer\Database\Role;

class InfotexteTemplateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $query = InfotexteTemplate::with(['section', 'assignables.assignable']);
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
            $templates = $query->paginate($perPage);
            $data = $templates->map(function ($template) {
                $assignableData = $this->getAssignableData($template);

                return [
                    'id' => $template->id,
                    'section' => $template->section ? [
                        'id' => $template->section->id,
                        'name' => $template->section->name,
                        'name_kurz' => $template->section->name_kurz,
                    ] : null,
                    'thema' => $template->thema,
                    'position' => $template->position,
                    'vue_component' => $template->vue_component,
                    'slug' => $template->slug,
                    'titel' => $template->titel,
                    'text' => $template->text,
                    'aktiv' => $template->aktiv,
                    'created_at' => $template->created_at,
                    'updated_at' => $template->updated_at,
                    'roles_count' => $assignableData['roles_count'],
                    'assignables_summary' => $assignableData['summary'],
                    'assignables' => $template->assignables->map(function ($assignable) {
                        return [
                            'id' => $assignable->assignable->id,
                            'name' => $this->getDisplayName($assignable->assignable),
                            'type' => class_basename($assignable->assignable_type),
                        ];
                    })->toArray(),
                ];
            });

            return response()->json([
                'success' => 'Infotexte Templates erfolgreich geladen.',
                'data' => $data,
                'meta' => [
                    'current_page' => $templates->currentPage(),
                    'last_page' => $templates->lastPage(),
                    'per_page' => $templates->perPage(),
                    'total' => $templates->total(),
                    'from' => $templates->firstItem(),
                    'to' => $templates->lastItem(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden der Infotexte Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(\App\Http\Requests\StoreInfotexteTemplateRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $section = Section::findOrFail($data['section_id']);
            $data['section'] = $section;
            $template = InfotexteTemplate::create($data);
            $template->load(['section', 'assignables.assignable']);

            return response()->json([
                'success' => 'Infotext wurde erfolgreich erstellt.',
                'data' => $template,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Erstellen des Infotextes: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(InfotexteTemplate $infotexteTemplate): JsonResponse
    {
        try {
            $infotexteTemplate->load(['section', 'assignables.assignable']);
            $assignableData = $this->getAssignableData($infotexteTemplate);
            $data = [
                'id' => $infotexteTemplate->id,
                'section' => $infotexteTemplate->section ? [
                    'id' => $infotexteTemplate->section->id,
                    'name' => $infotexteTemplate->section->name,
                    'name_kurz' => $infotexteTemplate->section->name_kurz,
                ] : null,
                'thema' => $infotexteTemplate->thema,
                'position' => $infotexteTemplate->position,
                'vue_component' => $infotexteTemplate->vue_component,
                'slug' => $infotexteTemplate->slug,
                'titel' => $infotexteTemplate->titel,
                'text' => $infotexteTemplate->text,
                'aktiv' => $infotexteTemplate->aktiv,
                'created_at' => $infotexteTemplate->created_at,
                'updated_at' => $infotexteTemplate->updated_at,
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

    public function update(\App\Http\Requests\UpdateInfotexteTemplateRequest $request, InfotexteTemplate $infotexteTemplate): JsonResponse
    {
        try {
            $data = $request->validated();
            if (isset($data['section_id'])) {
                $section = Section::findOrFail($data['section_id']);
                $data['section'] = $section;
            }
            $infotexteTemplate->update($data);
            $infotexteTemplate->load(['section', 'assignables.assignable']);

            return response()->json([
                'success' => 'Infotext wurde erfolgreich aktualisiert.',
                'data' => $infotexteTemplate,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Aktualisieren des Infotextes: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(InfotexteTemplate $infotexteTemplate): JsonResponse
    {
        try {
            $infotexteTemplate->assignables()->delete();
            $infotexteTemplate->delete();

            return response()->json([
                'success' => 'Infotext wurde erfolgreich gelöscht.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Löschen des Infotextes: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function getAssignableData($template): array
    {
        $roles = [];
        $rolesCount = 0;
        foreach ($template->assignables as $assignable) {
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

    public function assignRole(Request $request, InfotexteTemplate $infotexteTemplate): JsonResponse
    {
        try {
            $request->validate([
                'role_ids' => 'required|array',
                'role_ids.*' => 'exists:roles,id',
            ]);
            $addedCount = 0;
            foreach ($request->role_ids as $roleId) {
                $role = Role::findOrFail($roleId);
                $exists = $infotexteTemplate->assignables()
                    ->where('assignable_type', get_class($role))
                    ->where('assignable_id', $role->id)
                    ->exists();
                if (! $exists) {
                    $infotexteTemplate->assignables()->create([
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

    public function unassignRole(InfotexteTemplate $infotexteTemplate, Role $role): JsonResponse
    {
        try {
            $infotexteTemplate->assignables()
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
