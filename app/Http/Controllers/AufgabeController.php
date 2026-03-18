<?php

namespace App\Http\Controllers;

use App\Http\Resources\AufgabeResource;
use App\Models\Aufgabe;
use App\Models\AufgabenZugeteilte;
use App\Models\OptionAufgabeStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AufgabeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Aufgabe::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('log', 'LIKE', "%{$search}%")
                    ->orWhereHas('template', function ($templateQuery) use ($search) {
                        $templateQuery->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('thema', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->get('status_id'));
        }

        // Filter by template
        if ($request->filled('template_id')) {
            $query->where('aufgaben_template_id', $request->get('template_id'));
        }

        // Filter by assigned user
        if ($request->filled('assigned_user_id')) {
            $query->whereHas('zugeteilte', function ($q) use ($request) {
                $q->where('user_id', $request->get('assigned_user_id'));
            });
        }

        // Filter for "meine Aufgaben" - nur Aufgaben des aktuellen Users
        if ($request->filled('meine_aufgaben') && $request->get('meine_aufgaben')) {
            $currentUserId = auth()->id();
            $query->whereHas('zugeteilte', function ($q) use ($currentUserId) {
                $q->where('user_id', $currentUserId);
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        if (in_array($sortBy, ['name', 'faelligkeit', 'created_at', 'updated_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } elseif ($sortBy === 'status') {
            $query->leftJoin('optionen_aufgabe_stati', 'aufgaben.status_id', '=', 'optionen_aufgabe_stati.id')
                ->orderBy('optionen_aufgabe_stati.name', $sortOrder)
                ->select('aufgaben.*');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Load relationships - EXAKT WIE ES FUNKTIONIERT HAT
        $query->with([
            'status',
            'template.section',
            'template.uebernahmeberechtigte.assignable',
            'zugeteilte.user',
            'completedBy',
            'editedBy',
        ]);

        $perPage = min($request->get('per_page', 25), 100);
        $aufgaben = $query->paginate($perPage);

        return response()->json([
            'success' => 'Aufgaben erfolgreich geladen',
            'data' => AufgabeResource::collection($aufgaben),
            'pagination' => [
                'current_page' => $aufgaben->currentPage(),
                'last_page' => $aufgaben->lastPage(),
                'per_page' => $aufgaben->perPage(),
                'total' => $aufgaben->total(),
                'from' => $aufgaben->firstItem(),
                'to' => $aufgaben->lastItem(),
            ],
        ]);
    }

    /**
     * Get available users who can take over this task.
     */
    public function getAvailableUsers(Aufgabe $aufgabe): JsonResponse
    {
        if (! $aufgabe->template) {
            return response()->json([
                'success' => 'Keine verfügbaren User',
                'data' => [],
            ]);
        }

        $users = collect();

        // Get users directly assigned as uebernahmeberechtigte
        $directUsers = $aufgabe->template->uebernahmeberechtigte()
            ->where('assignable_type', User::class)
            ->with('assignable')
            ->get()
            ->pluck('assignable')
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ];
            });

        // Get users from uebernahmeberechtigte roles via Bouncer
        $roleUsers = collect();
        $aufgabe->template->uebernahmeberechtigte()
            ->where('assignable_type', Role::class)
            ->with('assignable')
            ->get()
            ->each(function ($item) use (&$roleUsers) {
                if ($item->assignable) {
                    // Use Bouncer to get users with this role
                    $usersWithRole = User::whereIs($item->assignable->name)->get(['id', 'name', 'email']);
                    foreach ($usersWithRole as $user) {
                        $roleUsers->push([
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                        ]);
                    }
                }
            });

        $allUsers = $users->merge($directUsers)->merge($roleUsers)->unique('id')->values();

        return response()->json([
            'success' => 'Verfügbare User erfolgreich geladen',
            'data' => $allUsers,
        ]);
    }

    public function show(Aufgabe $aufgabe): JsonResponse
    {
        $aufgabe->load([
            'status',
            'template.section',
            'template.uebernahmeberechtigte.assignable',
            'zugeteilte.user',
            'completedBy',
            'editedBy',
        ]);

        return response()->json([
            'success' => 'Aufgabe erfolgreich geladen',
            'data' => new AufgabeResource($aufgabe),
        ]);
    }

    /**
     * Store a new task.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'beschreibung' => 'nullable|string',
            'status_id' => 'sometimes|exists:optionen_aufgabe_stati,id',
            'aufgaben_template_id' => 'required|exists:aufgaben_templates,id',
            'log' => 'nullable|string',
            'faelligkeit' => 'nullable|date',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        // Generate name from template if not provided
        if (! isset($validated['name']) && isset($validated['aufgaben_template_id'])) {
            $template = AufgabenTemplate::find($validated['aufgaben_template_id']);
            if ($template) {
                $validated['name'] = $template->name . ' - ' . now()->format('d.m.Y H:i');
            }
        }

        $aufgabe = Aufgabe::create([
            'name' => $validated['name'],
            'beschreibung' => $validated['beschreibung'] ?? null,
            'status_id' => $validated['status_id'] ?? 1, // Default to "offen"
            'aufgaben_template_id' => $validated['aufgaben_template_id'],
            'log' => $validated['log'] ?? null,
            'faelligkeit' => $validated['faelligkeit'] ?? null,
        ]);

        // Assign specified users
        if (! empty($validated['user_ids'])) {
            foreach ($validated['user_ids'] as $userId) {
                AufgabenZugeteilte::create([
                    'aufgaben_id' => $aufgabe->id,
                    'user_id' => $userId,
                ]);
            }
        }

        $aufgabe->load([
            'status',
            'template.section',
            'zugeteilte.user',
            'completedBy',
            'editedBy',
        ]);

        $aufgabe->load(['status', 'template.section', 'zugeteilte.user']);

        return response()->json([
            'success' => 'Aufgabe erfolgreich erstellt',
            'data' => new AufgabeResource($aufgabe),
        ], 201);
    }

    public function update(Request $request, Aufgabe $aufgabe): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'beschreibung' => 'sometimes|nullable|string',
            'status_id' => 'sometimes|exists:optionen_aufgabe_stati,id',
            'aufgaben_template_id' => 'sometimes|nullable|exists:aufgaben_templates,id',
            'log' => 'sometimes|nullable|string',
            'faelligkeit' => 'sometimes|nullable|date',
            'user_ids' => 'sometimes|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        // Handle automatic editor/completed assignment based on status change
        if (isset($validated['status_id'])) {
            $currentUser = $request->user();

            // Status 2 = "in Bearbeitung" - set editor, clear completed
            if ($validated['status_id'] == 2) {
                $validated['editor_id'] = $currentUser->id;
                $validated['completed_id'] = null;
                $validated['completed_at'] = null;
            }

            // Status 3 = "abgeschlossen" - set completed
            if ($validated['status_id'] == 3) {
                $validated['completed_id'] = $currentUser->id;
                $validated['completed_at'] = now();
            }

            // Status 1 = "offen" - clear both editor and completed
            if ($validated['status_id'] == 1) {
                $validated['editor_id'] = null;
                $validated['completed_id'] = null;
                $validated['completed_at'] = null;
            }
        }

        $aufgabe->update($validated);

        // Update user assignments if provided
        if (isset($validated['user_ids'])) {
            // Delete existing assignments
            $aufgabe->zugeteilte()->delete();

            // Create new assignments
            foreach ($validated['user_ids'] as $userId) {
                AufgabenZugeteilte::create([
                    'aufgaben_id' => $aufgabe->id,
                    'user_id' => $userId,
                ]);
            }
        }

        $aufgabe->load([
            'status',
            'template.section',
            'zugeteilte.user',
            'completedBy',
            'editedBy',
        ]);

        return response()->json([
            'success' => 'Aufgabe erfolgreich aktualisiert',
            'data' => new AufgabeResource($aufgabe),
        ]);
    }

    public function destroy(Aufgabe $aufgabe): JsonResponse
    {
        $aufgabe->delete();

        return response()->json([
            'success' => 'Aufgabe erfolgreich gelöscht',
        ]);
    }

    /**
     * Assign users to a task.
     */
    public function assignUsers(Request $request, Aufgabe $aufgabe): JsonResponse
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $addedCount = 0;
        foreach ($validated['user_ids'] as $userId) {
            $created = AufgabenZugeteilte::firstOrCreate([
                'aufgaben_id' => $aufgabe->id,
                'assignable_type' => User::class,
                'assignable_id' => $userId,
            ]);

            if ($created->wasRecentlyCreated) {
                $addedCount++;
            }
        }

        return response()->json([
            'success' => $addedCount > 0 ? "{$addedCount} Benutzer zugewiesen" : 'Alle Benutzer sind bereits zugewiesen',
            'data' => ['added_count' => $addedCount],
        ]);
    }

    /**
     * Remove a user from a task.
     */
    public function removeUser(Aufgabe $aufgabe, User $user): JsonResponse
    {
        AufgabenZugeteilte::where([
            'aufgaben_id' => $aufgabe->id,
            'assignable_type' => User::class,
            'assignable_id' => $user->id,
        ])->delete();

        return response()->json([
            'success' => 'Benutzer von Aufgabe entfernt',
        ]);
    }

    /**
     * Take over a task (for users who are authorized).
     */
    public function takeOver(Request $request, Aufgabe $aufgabe): JsonResponse
    {
        $user = $request->user();

        if (! $aufgabe->canUserTakeOver($user)) {
            return response()->json([
                'error' => 'Sie sind nicht berechtigt, diese Aufgabe zu übernehmen',
            ], 403);
        }

        // Check if task is not completed
        if ($aufgabe->status_id === 3) { // Assuming status 3 is "completed"
            return response()->json([
                'error' => 'Diese Aufgabe ist bereits abgeschlossen',
            ], 400);
        }

        // Remove ALL existing user assignments
        $aufgabe->zugeteilte()->delete();

        // Add ONLY the current user as assigned user
        AufgabenZugeteilte::create([
            'aufgaben_id' => $aufgabe->id,
            'user_id' => $user->id,
        ]);

        // Update status to "in Bearbeitung" and set editor
        if ($aufgabe->status_id == 1) { // If "offen"
            $aufgabe->update([
                'status_id' => 2, // "in Bearbeitung"
                'editor_id' => $user->id,
                'completed_id' => null,
                'completed_at' => null,
            ]);
        } elseif ($aufgabe->status_id == 2) { // If already "in Bearbeitung"
            $aufgabe->update([
                'editor_id' => $user->id,
                'completed_id' => null,
                'completed_at' => null,
            ]);
        }

        return response()->json([
            'success' => 'Aufgabe erfolgreich übernommen',
            'data' => new AufgabeResource($aufgabe->load([
                'status',
                'template.section',
                'template.zugeteilte.assignable',
                'template.uebernahmeberechtigte.assignable',
                'zugeteilte.user',
                'completedBy',
                'editedBy',
            ])),
        ]);
    }

    /**
     * Get available status options.
     */
    public function statusList(): JsonResponse
    {
        $statuses = OptionAufgabeStatus::active()->ordered()->get(['id', 'name']);

        return response()->json([
            'success' => 'Status-Optionen erfolgreich geladen',
            'data' => $statuses,
        ]);
    }

    /**
     * Search users for assignment.
     */
    public function usersSearch(Request $request): JsonResponse
    {
        $search = $request->get('search', '');

        $users = User::where(function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        })
            ->limit(50)
            ->get(['id', 'name', 'email']);

        return response()->json([
            'success' => 'Benutzer erfolgreich gesucht',
            'data' => $users,
        ]);
    }
}
