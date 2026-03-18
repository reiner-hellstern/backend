<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAufgabenTemplateRequest;
use App\Http\Requests\UpdateAufgabenTemplateRequest;
use App\Http\Resources\AufgabenTemplateResource;
use App\Models\AufgabenTemplate;
use App\Models\AufgabenTemplateUebernahmeberechtigte;
use App\Models\AufgabenTemplateZugeteilte;
use App\Models\Role;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AufgabenTemplateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = AufgabenTemplate::query();

        // Search functionality with multiple keywords
        if ($request->filled('search')) {
            $search = $request->get('search');
            $keywords = array_filter(explode(' ', $search)); // Split by spaces and remove empty

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->where(function ($subQ) use ($keyword) {
                        $subQ->where('name', 'LIKE', "%{$keyword}%")
                            ->orWhere('thema', 'LIKE', "%{$keyword}%")
                            ->orWhereHas('section', function ($sectionQ) use ($keyword) {
                                $sectionQ->where('name', 'LIKE', "%{$keyword}%");
                            });
                    });
                }
            });
        }

        // Exclude templates with {id} in path for task creation
        if ($request->filled('exclude_id_path') && $request->get('exclude_id_path')) {
            $query->where(function ($q) {
                $q->whereNull('path')
                    ->orWhere('path', 'NOT LIKE', '%{id}%');
            });
        }

        // Filter by section
        if ($request->filled('section_id')) {
            $query->where('section_id', $request->get('section_id'));
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        if (in_array($sortBy, ['name', 'thema', 'created_at', 'updated_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } elseif ($sortBy === 'section') {
            $query->orderBy('section_id', $sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }

        $perPage = min($request->get('per_page', 15), 100);

        // Load relationships for table display
        $query->with(['section', 'zugeteilte.assignable', 'uebernahmeberechtigte.assignable']);

        $templates = $query->paginate($perPage);

        return response()->json([
            'data' => AufgabenTemplateResource::collection($templates),
            'pagination' => [
                'current_page' => $templates->currentPage(),
                'last_page' => $templates->lastPage(),
                'per_page' => $templates->perPage(),
                'total' => $templates->total(),
                'from' => $templates->firstItem(),
                'to' => $templates->lastItem(),
            ],
        ]);
    }

    public function store(StoreAufgabenTemplateRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Generate unique slug
        $baseSlug = Str::slug($data['name']);
        $slug = $baseSlug;
        $counter = 1;

        while (AufgabenTemplate::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $data['slug'] = $slug;

        $aufgabenTemplate = AufgabenTemplate::create($data);
        $aufgabenTemplate->load(['section']);

        return response()->json([
            'success' => true,
            'message' => 'Aufgaben-Template erfolgreich erstellt.',
            'data' => new AufgabenTemplateResource($aufgabenTemplate),
        ], 201);
    }

    public function show(AufgabenTemplate $aufgabenTemplate): JsonResponse
    {
        $aufgabenTemplate->load(['section', 'zugeteilte.assignable', 'uebernahmeberechtigte.assignable']);

        return response()->json([
            'success' => true,
            'data' => new AufgabenTemplateResource($aufgabenTemplate),
        ]);
    }

    public function update(UpdateAufgabenTemplateRequest $request, AufgabenTemplate $aufgabenTemplate): JsonResponse
    {
        $data = $request->validated();

        // Update basic template data
        $aufgabenTemplate->update([
            'name' => $data['name'],
            'thema' => $data['thema'],
            'beschreibung' => $data['beschreibung'] ?? null,
            'section_id' => $data['section_id'],
        ]);

        // Handle Übernahmeberechtigte assignments
        if (isset($data['uebernahmeberechtigte'])) {
            // Clear existing assignments
            AufgabenTemplateUebernahmeberechtigte::where('aufgaben_template_id', $aufgabenTemplate->id)->delete();

            // Add new assignments
            foreach ($data['uebernahmeberechtigte'] as $assignment) {
                if ($assignment['type'] === 'role') {
                    AufgabenTemplateUebernahmeberechtigte::create([
                        'aufgaben_template_id' => $aufgabenTemplate->id,
                        'assignable_type' => Role::class,
                        'assignable_id' => $assignment['id'],
                    ]);
                } elseif ($assignment['type'] === 'user') {
                    AufgabenTemplateUebernahmeberechtigte::create([
                        'aufgaben_template_id' => $aufgabenTemplate->id,
                        'assignable_type' => User::class,
                        'assignable_id' => $assignment['id'],
                    ]);
                }
            }
        }

        // Handle Zugeteilte assignments
        if (isset($data['zugeteilte'])) {
            // Clear existing assignments
            AufgabenTemplateZugeteilte::where('aufgaben_template_id', $aufgabenTemplate->id)->delete();

            // Add new assignments
            foreach ($data['zugeteilte'] as $assignment) {
                if ($assignment['type'] === 'role') {
                    AufgabenTemplateZugeteilte::create([
                        'aufgaben_template_id' => $aufgabenTemplate->id,
                        'assignable_type' => Role::class,
                        'assignable_id' => $assignment['id'],
                    ]);
                } elseif ($assignment['type'] === 'user') {
                    AufgabenTemplateZugeteilte::create([
                        'aufgaben_template_id' => $aufgabenTemplate->id,
                        'assignable_type' => User::class,
                        'assignable_id' => $assignment['id'],
                    ]);
                }
            }
        }

        $aufgabenTemplate->load(['section', 'zugeteilte.assignable', 'uebernahmeberechtigte.assignable']);

        return response()->json([
            'success' => true,
            'message' => 'Aufgaben-Template erfolgreich aktualisiert.',
            'data' => new AufgabenTemplateResource($aufgabenTemplate),
        ]);
    }

    public function syncZugeteilteRoles(Request $request, AufgabenTemplate $aufgabenTemplate): JsonResponse
    {
        $request->validate([
            'role_ids' => 'array',
            'role_ids.*' => 'exists:roles,id',
        ]);

        // Add new role assignments (don't delete existing ones)
        if (! empty($request->role_ids)) {
            foreach ($request->role_ids as $roleId) {
                // Check if already assigned
                $existing = AufgabenTemplateZugeteilte::where('aufgaben_template_id', $aufgabenTemplate->id)
                    ->where('assignable_type', Role::class)
                    ->where('assignable_id', $roleId)
                    ->exists();

                if (! $existing) {
                    AufgabenTemplateZugeteilte::create([
                        'aufgaben_template_id' => $aufgabenTemplate->id,
                        'assignable_type' => Role::class,
                        'assignable_id' => $roleId,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => 'Zugeteilte Rollen erfolgreich hinzugefügt.',
            'data' => [],
        ]);
    }

    public function syncZugeteiltePersons(Request $request, AufgabenTemplate $aufgabenTemplate): JsonResponse
    {
        $request->validate([
            'person_ids' => 'array',
            'person_ids.*' => 'exists:personen,id',
        ]);

        // Delete existing person assignments
        AufgabenTemplateZugeteilte::where('aufgaben_template_id', $aufgabenTemplate->id)
            ->where('assignable_type', Person::class)
            ->delete();

        // Add new person assignments
        if (! empty($request->person_ids)) {
            $assignments = collect($request->person_ids)->map(function ($personId) use ($aufgabenTemplate) {
                return [
                    'aufgaben_template_id' => $aufgabenTemplate->id,
                    'assignable_type' => Person::class,
                    'assignable_id' => $personId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

            AufgabenTemplateZugeteilte::insert($assignments->toArray());
        }

        return response()->json([
            'success' => true,
            'message' => 'Zugeteilte Personen erfolgreich aktualisiert.',
        ]);
    }

    public function syncUebernahmeberechtigteRoles(Request $request, AufgabenTemplate $aufgabenTemplate): JsonResponse
    {
        $request->validate([
            'role_ids' => 'array',
            'role_ids.*' => 'exists:roles,id',
        ]);

        // Add new role assignments (don't delete existing ones)
        if (! empty($request->role_ids)) {
            foreach ($request->role_ids as $roleId) {
                // Check if already assigned
                $existing = AufgabenTemplateUebernahmeberechtigte::where('aufgaben_template_id', $aufgabenTemplate->id)
                    ->where('assignable_type', Role::class)
                    ->where('assignable_id', $roleId)
                    ->exists();

                if (! $existing) {
                    AufgabenTemplateUebernahmeberechtigte::create([
                        'aufgaben_template_id' => $aufgabenTemplate->id,
                        'assignable_type' => Role::class,
                        'assignable_id' => $roleId,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => 'Übernahmeberechtigte Rollen erfolgreich hinzugefügt.',
            'data' => [],
        ]);
    }

    public function syncUebernahmeberechtigtePersons(Request $request, AufgabenTemplate $aufgabenTemplate): JsonResponse
    {
        $request->validate([
            'person_ids' => 'array',
            'person_ids.*' => 'exists:personen,id',
        ]);

        // Delete existing person assignments
        AufgabenTemplateUebernahmeberechtigte::where('aufgaben_template_id', $aufgabenTemplate->id)
            ->where('assignable_type', Person::class)
            ->delete();

        // Add new person assignments
        if (! empty($request->person_ids)) {
            $assignments = collect($request->person_ids)->map(function ($personId) use ($aufgabenTemplate) {
                return [
                    'aufgaben_template_id' => $aufgabenTemplate->id,
                    'assignable_type' => Person::class,
                    'assignable_id' => $personId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

            AufgabenTemplateUebernahmeberechtigte::insert($assignments->toArray());
        }

        return response()->json([
            'success' => true,
            'message' => 'Übernahmeberechtigte Personen erfolgreich aktualisiert.',
        ]);
    }

    public function syncZugeteilteUsers(Request $request, AufgabenTemplate $aufgabenTemplate): JsonResponse
    {
        $request->validate([
            'user_ids' => 'array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $addedCount = 0;

        // Add new user assignments (don't delete existing ones)
        if (! empty($request->user_ids)) {
            foreach ($request->user_ids as $userId) {
                // Check if already assigned
                $existing = AufgabenTemplateZugeteilte::where('aufgaben_template_id', $aufgabenTemplate->id)
                    ->where('assignable_type', User::class)
                    ->where('assignable_id', $userId)
                    ->exists();

                if (! $existing) {
                    AufgabenTemplateZugeteilte::create([
                        'aufgaben_template_id' => $aufgabenTemplate->id,
                        'assignable_type' => User::class,
                        'assignable_id' => $userId,
                    ]);
                    $addedCount++;
                }
            }
        }

        return response()->json([
            'success' => 'Zugeteilte Benutzer erfolgreich hinzugefügt.',
            'data' => ['added_count' => $addedCount],
        ]);
    }

    public function removeZugeteilteUser(AufgabenTemplate $aufgabenTemplate, User $user): JsonResponse
    {
        AufgabenTemplateZugeteilte::where('aufgaben_template_id', $aufgabenTemplate->id)
            ->where('assignable_type', User::class)
            ->where('assignable_id', $user->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'User erfolgreich entfernt.',
        ]);
    }

    public function syncUebernahmeberechtigteUsers(Request $request, AufgabenTemplate $aufgabenTemplate): JsonResponse
    {
        $request->validate([
            'user_ids' => 'array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $addedCount = 0;

        // Add new user assignments (don't delete existing ones)
        if (! empty($request->user_ids)) {
            foreach ($request->user_ids as $userId) {
                // Check if already assigned
                $existing = AufgabenTemplateUebernahmeberechtigte::where('aufgaben_template_id', $aufgabenTemplate->id)
                    ->where('assignable_type', User::class)
                    ->where('assignable_id', $userId)
                    ->exists();

                if (! $existing) {
                    AufgabenTemplateUebernahmeberechtigte::create([
                        'aufgaben_template_id' => $aufgabenTemplate->id,
                        'assignable_type' => User::class,
                        'assignable_id' => $userId,
                    ]);
                    $addedCount++;
                }
            }
        }

        return response()->json([
            'success' => 'Übernahmeberechtigte Benutzer erfolgreich hinzugefügt.',
            'data' => ['added_count' => $addedCount],
        ]);
    }

    public function removeUebernahmeberechtigteUser(AufgabenTemplate $aufgabenTemplate, User $user): JsonResponse
    {
        AufgabenTemplateUebernahmeberechtigte::where('aufgaben_template_id', $aufgabenTemplate->id)
            ->where('assignable_type', User::class)
            ->where('assignable_id', $user->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'User erfolgreich entfernt.',
        ]);
    }

    public function removeZugeteilteRole(AufgabenTemplate $aufgabenTemplate, Role $role): JsonResponse
    {
        AufgabenTemplateZugeteilte::where('aufgaben_template_id', $aufgabenTemplate->id)
            ->where('assignable_type', Role::class)
            ->where('assignable_id', $role->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rolle erfolgreich entfernt.',
        ]);
    }

    public function removeUebernahmeberechtigteRole(AufgabenTemplate $aufgabenTemplate, Role $role): JsonResponse
    {
        AufgabenTemplateUebernahmeberechtigte::where('aufgaben_template_id', $aufgabenTemplate->id)
            ->where('assignable_type', Role::class)
            ->where('assignable_id', $role->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rolle erfolgreich entfernt.',
        ]);
    }

    public function destroy(AufgabenTemplate $aufgabenTemplate): JsonResponse
    {
        try {
            $aufgabenTemplate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Aufgaben-Template erfolgreich gelöscht.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Löschen des Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function sections(): JsonResponse
    {
        try {
            $sections = Section::select('id', 'name')->orderBy('name')->get();

            return response()->json([
                'success' => true,
                'data' => $sections,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching sections: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Bereiche',
            ], 500);
        }
    }

    /**
     * Get list of all roles for assignment dropdowns
     */
    public function rolesList(): JsonResponse
    {
        try {
            $roles = Role::select('id', 'title', 'name')
                ->orderBy('title')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $roles,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching roles: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Rollen',
            ], 500);
        }
    }

    /**
     * Get list of all users for assignment dropdowns
     */
    public function usersList(): JsonResponse
    {
        try {
            $users = User::select('id', 'name', 'email')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $users,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching users: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Benutzer',
            ], 500);
        }
    }

    /**
     * Search users for assignment
     */
    public function usersSearch(Request $request): JsonResponse
    {
        try {
            $query = User::select('id', 'name', 'email')
                ->orderBy('name');

            if ($request->filled('q')) {
                $search = $request->get('q');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
            }

            if ($request->filled('limit')) {
                $query->limit($request->get('limit'));
            }

            $users = $query->get();

            return response()->json([
                'success' => true,
                'data' => $users,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error searching users: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Fehler bei der Benutzersuche',
            ], 500);
        }
    }
}
