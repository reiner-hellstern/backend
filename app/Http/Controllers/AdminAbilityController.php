<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

class AdminAbilityController extends Controller
{
    /**
     * Display a listing of abilities with optional filtering
     */
    public function index(Request $request): JsonResponse
    {
        $query = Ability::query();

        // Search functionality - search in both action and subject
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('entity_type', 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', '%' . $search . '%');
            });
        }

        // Legacy filters (keep for backwards compatibility)
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('entity_type')) {
            $query->where('entity_type', 'like', '%' . $request->entity_type . '%');
        }

        // Sorting
        $sortField = $request->get('sort_field', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');

        // Map frontend field names to database field names
        $fieldMapping = [
            'action' => 'name',
            'subject' => 'entity_type',
        ];

        $dbField = $fieldMapping[$sortField] ?? $sortField;

        // Only show general abilities (without specific entity_id) for selection
        $query->whereNull('entity_id');

        $query->orderBy($dbField, $sortDirection);

        // Pagination support
        $pagination = $request->input('pagination', 25);

        // Include counts for roles and users
        $abilities = $query->withCount(['roles'])
            ->paginate($pagination);

        // Add manual user count for direct assignments from permissions table
        foreach ($abilities as $ability) {
            // Count users who have this ability directly assigned (not through roles)
            // entity_type = 'App\Models\User' means direct user assignment
            $userCount = \DB::table('permissions')
                ->where('ability_id', $ability->id)
                ->where('entity_type', 'App\Models\User')
                ->where('forbidden', 0) // Only allowed permissions, not forbidden ones
                ->count();

            $ability->users_count = $userCount;
        }

        return response()->json($abilities);
    }

    /**
     * Store a newly created ability
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'action' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'only_owned' => 'boolean',
        ]);

        // Store action directly in name field (no transformation)
        $name = $validated['action'];

        // Generate auto title: Action + "eigene" + Model name (without namespace)
        $titleParts = [];

        // Format action for title: replace dashes with spaces, capitalize first letter
        // Remove "eigene" from action if it's already there to avoid duplication
        $cleanAction = str_replace('-eigene', '', $validated['action']);
        $actionForTitle = ucfirst(str_replace('-', ' ', $cleanAction));
        $titleParts[] = $actionForTitle;

        // Add "eigene" if only_owned is true
        if (! empty($validated['only_owned'])) {
            $titleParts[] = 'eigene';
        }

        // Add model name without namespace if subject is provided
        if (! empty($validated['subject'])) {
            $modelName = class_basename($validated['subject']);
            $titleParts[] = $modelName;
        }

        $autoTitle = implode(' ', $titleParts);

        // Check if ability already exists
        $existingAbility = Ability::where('name', $name)
            ->where('entity_type', $validated['subject'] ?? null)
            ->where('only_owned', $validated['only_owned'] ?? false)
            ->first();

        if ($existingAbility) {
            return response()->json([
                'message' => 'Diese Ability existiert bereits.',
            ], 422);
        }

        $ability = Ability::create([
            'name' => $name,
            'title' => $autoTitle,
        ]);

        // Set entity_type and only_owned separately since they may not be fillable
        if (! empty($validated['subject'])) {
            $ability->entity_type = $validated['subject'];
        }
        $ability->only_owned = $validated['only_owned'] ?? false;
        $ability->save();

        // Load counts for the response
        $ability->loadCount(['roles']);

        return response()->json($ability, 201);
    }

    /**
     * Display the specified ability
     */
    public function show(Ability $ability): JsonResponse
    {
        $ability->loadCount(['roles']);
        $ability->load(['roles:id,name']);

        return response()->json($ability);
    }

    /**
     * Update the specified ability
     */
    public function update(Request $request, Ability $ability): JsonResponse
    {
        $validated = $request->validate([
            'action' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'only_owned' => 'boolean',
        ]);

        // Store action directly in name field (no transformation)
        $name = $validated['action'];

        // Generate auto title: Action + "eigene" + Model name (without namespace)
        $titleParts = [];

        // Format action for title: replace dashes with spaces, capitalize first letter
        // Remove "eigene" from action if it's already there to avoid duplication
        $cleanAction = str_replace('-eigene', '', $validated['action']);
        $actionForTitle = ucfirst(str_replace('-', ' ', $cleanAction));
        $titleParts[] = $actionForTitle;

        // Add "eigene" if only_owned is true
        if (! empty($validated['only_owned'])) {
            $titleParts[] = 'eigene';
        }

        // Add model name without namespace if subject is provided
        if (! empty($validated['subject'])) {
            $modelName = class_basename($validated['subject']);
            $titleParts[] = $modelName;
        }

        $autoTitle = implode(' ', $titleParts);

        // Check if ability already exists (excluding current one)
        $existingAbility = Ability::where('name', $name)
            ->where('entity_type', $validated['subject'] ?? null)
            ->where('only_owned', $validated['only_owned'] ?? false)
            ->where('id', '!=', $ability->id)
            ->first();

        if ($existingAbility) {
            return response()->json([
                'message' => 'Diese Ability existiert bereits.',
            ], 422);
        }

        $ability->update([
            'name' => $name,
            'title' => $autoTitle,
        ]);

        // Set entity_type and only_owned separately since they may not be fillable
        $ability->entity_type = $validated['subject'] ?? null;
        $ability->only_owned = $validated['only_owned'] ?? false;
        $ability->save();

        $ability->loadCount(['roles']);

        return response()->json($ability);
    }

    /**
     * Remove the specified ability
     */
    public function destroy(Ability $ability): JsonResponse
    {
        // Check if ability is assigned to roles
        if ($ability->roles()->count() > 0) {
            return response()->json([
                'message' => 'Ability kann nicht gelöscht werden, da sie noch Rollen zugewiesen ist.',
            ], 422);
        }

        // Delete the ability
        $ability->delete();

        return response()->json([
            'message' => 'Ability wurde erfolgreich gelöscht.',
        ]);
    }

    /**
     * Get all roles that have this ability
     */
    public function roles(Ability $ability): JsonResponse
    {
        $roles = $ability->roles()
            ->select('id', 'name', 'title')
            ->orderBy('name')
            ->get();

        return response()->json($roles);
    }

    /**
     * Assign this ability to a role
     */
    public function assignToRole(Request $request, Ability $ability): JsonResponse
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $role = Role::find($validated['role_id']);

        if (! $ability->roles()->where('id', $role->id)->exists()) {
            $ability->roles()->attach($role->id);
        }

        return response()->json([
            'message' => 'Ability wurde der Rolle zugewiesen.',
        ]);
    }

    /**
     * Remove this ability from a role
     */
    public function removeFromRole(Ability $ability, Role $role): JsonResponse
    {
        $ability->roles()->detach($role->id);

        return response()->json([
            'message' => 'Ability wurde von der Rolle entfernt.',
        ]);
    }

    /**
     * Bulk assign this ability to multiple roles
     */
    public function bulkAssignToRoles(Request $request, Ability $ability): JsonResponse
    {
        $validated = $request->validate([
            'role_ids' => 'required|array',
            'role_ids.*' => 'exists:roles,id',
        ]);

        $roles = Role::whereIn('id', $validated['role_ids'])->get();

        foreach ($roles as $role) {
            if (! $ability->roles()->where('id', $role->id)->exists()) {
                $ability->roles()->attach($role->id);
            }
        }

        return response()->json([
            'message' => 'Ability wurde ' . count($roles) . ' Rollen zugewiesen.',
        ]);
    }

    /**
     * Remove this ability from multiple roles (bulk operation)
     */
    public function bulkRemoveFromRoles(Request $request, Ability $ability): JsonResponse
    {
        $validated = $request->validate([
            'role_ids' => 'required|array',
            'role_ids.*' => 'exists:roles,id',
        ]);

        $ability->roles()->detach($validated['role_ids']);

        return response()->json([
            'message' => 'Ability wurde von ' . count($validated['role_ids']) . ' Rollen entfernt.',
        ]);
    }

    /**
     * Get all available entity types
     */
    public function entityTypes(): JsonResponse
    {
        $entityTypes = Ability::select('entity_type')
            ->whereNotNull('entity_type')
            ->distinct()
            ->orderBy('entity_type')
            ->pluck('entity_type');

        return response()->json($entityTypes);
    }
}
