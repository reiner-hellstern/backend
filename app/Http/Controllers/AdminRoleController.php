<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use ReflectionClass;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of roles with optional filtering
     */
    public function index(Request $request): JsonResponse
    {
        $query = Role::query();

        // Search functionality - search in name and title
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', '%' . $search . '%');
            });
        }

        // Individual field filters (backwards compatibility)
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Include counts for users and abilities, and load the actual abilities
        $query->withCount(['users', 'abilities'])
            ->with('abilities');

        // Sorting
        $sortField = $request->get('sort_field', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');

        // Map frontend field names to actual database columns
        $sortMapping = [
            'name' => 'name',
            'title' => 'title',
            'users_count' => 'users_count',
            'created_at' => 'created_at',
        ];

        if (isset($sortMapping[$sortField])) {
            $query->orderBy($sortMapping[$sortField], $sortDirection);
        } else {
            $query->orderBy('name', 'asc');
        }

        $roles = $query->get();

        return response()->json($roles);
    }

    /**
     * Store a newly created role
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'title' => 'nullable|string|max:255',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'title' => $validated['title'] ?? null,
        ]);

        // Load counts for the response
        $role->loadCount(['users', 'abilities']);

        return response()->json($role, 201);
    }

    /**
     * Display the specified role
     */
    public function show(Role $role): JsonResponse
    {
        $role->loadCount(['users', 'abilities']);
        $role->load(['users:id,name,email', 'abilities:id,name']);

        return response()->json($role);
    }

    /**
     * Update the specified role
     */
    public function update(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
            'title' => 'nullable|string|max:255',
        ]);

        $role->update($validated);
        $role->loadCount(['users', 'abilities']);

        return response()->json($role);
    }

    /**
     * Remove the specified role
     */
    public function destroy(Role $role): JsonResponse
    {
        // Check if role has users assigned
        if ($role->users()->count() > 0) {
            return response()->json([
                'message' => 'Rolle kann nicht gelöscht werden, da sie noch Usern zugewiesen ist.',
            ], 422);
        }

        // Detach all abilities from role
        $role->abilities()->detach();

        // Delete the role
        $role->delete();

        return response()->json([
            'message' => 'Rolle wurde erfolgreich gelöscht.',
        ]);
    }

    /**
     * Get all abilities for a specific role
     */
    public function abilities(Role $role): JsonResponse
    {
        $abilities = $role->abilities()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($abilities);
    }

    /**
     * Assign an ability to a role
     */
    public function assignAbility(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'ability_id' => 'required|exists:abilities,id',
        ]);

        $ability = Ability::find($validated['ability_id']);

        if (! $role->abilities()->where('abilities.id', $ability->id)->exists()) {
            $role->abilities()->attach($ability->id);
        }

        return response()->json([
            'message' => 'Ability wurde der Rolle zugewiesen.',
        ]);
    }

    /**
     * Remove an ability from a role
     */
    public function removeAbility(Role $role, Ability $ability): JsonResponse
    {
        $role->abilities()->detach($ability->id);

        return response()->json([
            'message' => 'Ability wurde von der Rolle entfernt.',
        ]);
    }

    /**
     * Get all users with a specific role with pagination and search
     */
    public function users(Request $request, Role $role): JsonResponse
    {
        $query = $role->users()
            ->select('users.id', 'users.name', 'users.email');

        // Search functionality
        if ($request->has('search') && ! empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%');
            });
        }

        // Sorting
        $sortField = $request->get('sort_field', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');

        // Map frontend field names to actual database columns
        $sortMapping = [
            'id' => 'users.id',
            'name' => 'users.name',
            'email' => 'users.email',
        ];

        $dbSortField = $sortMapping[$sortField] ?? 'users.name';
        $query->orderBy($dbSortField, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 50);
        if ($perPage > 500) {
            $perPage = 500; // Limit to prevent performance issues
        }

        $users = $query->paginate($perPage);

        return response()->json($users);
    }

    /**
     * Assign a role to multiple users (bulk operation)
     */
    public function bulkAssignUsers(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $users = User::whereIn('id', $validated['user_ids'])->get();

        foreach ($users as $user) {
            if (! $user->isA($role->name)) {
                $user->assign($role);
            }
        }

        return response()->json([
            'message' => 'Rolle wurde ' . count($users) . ' Usern zugewiesen.',
        ]);
    }

    /**
     * Remove a role from multiple users (bulk operation)
     */
    public function bulkRemoveUsers(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $users = User::whereIn('id', $validated['user_ids'])->get();

        foreach ($users as $user) {
            if ($user->isA($role->name)) {
                $user->retract($role);
            }
        }

        return response()->json([
            'message' => 'Rolle wurde von ' . count($users) . ' Usern entfernt.',
        ]);
    }

    /**
     * Sync abilities for a role (replace all current abilities)
     */
    public function syncAbilities(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'ability_ids' => 'required|array',
            'ability_ids.*' => 'exists:abilities,id',
        ]);

        $role->abilities()->sync($validated['ability_ids']);

        return response()->json([
            'message' => 'Abilities wurden für die Rolle synchronisiert.',
        ]);
    }

    /**
     * Get available Laravel models for abilities
     */
    public function getModels(): JsonResponse
    {
        $models = [];
        $modelsPath = app_path('Models');

        if (File::exists($modelsPath)) {
            $files = File::allFiles($modelsPath);

            foreach ($files as $file) {
                $className = pathinfo($file->getFilename(), PATHINFO_FILENAME);

                // Skip Option models and abstract classes
                if (strpos($className, 'Option') === false &&
                    ! in_array($className, ['Model', 'BaseModel', 'AbstractModel'])) {

                    $fullClassName = "App\\Models\\$className";

                    // Check if class exists and is instantiable
                    if (class_exists($fullClassName)) {
                        try {
                            $reflection = new ReflectionClass($fullClassName);
                            if (! $reflection->isAbstract() && ! $reflection->isInterface()) {
                                $models[] = $className;
                            }
                        } catch (\Exception $e) {
                            // Skip if reflection fails
                        }
                    }
                }
            }
        }

        sort($models);

        return response()->json($models);
    }
}
