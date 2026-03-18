<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Person;
use App\Models\User;
use App\Traits\SavePerson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

class UserController extends Controller
{
    use SavePerson;

    /**
     * Display a listing of users with filtering, sorting and pagination
     */
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $columns = $request->input('columns');
        $pagination = $request->input('pagination', '100');
        $search = $request->input('search', '');

        $users = User::leftJoin('personen', 'users.person_id', '=', 'personen.id')
            ->leftJoin('mitglieder', 'personen.id', '=', 'mitglieder.person_id')
            ->leftJoin('assigned_roles', 'users.id', '=', 'assigned_roles.entity_id')
            ->leftJoin('roles', function ($join) {
                $join->on('assigned_roles.role_id', '=', 'roles.id')
                    ->where('assigned_roles.entity_type', '=', 'App\\Models\\User');
            })
            ->select(
                'users.*',
                'personen.vorname as person_vorname',
                'personen.nachname as person_nachname',
                'mitglieder.mitglied_nr as person_mitgliedsnummer',
                'personen.strasse as person_strasse',
                'personen.postleitzahl as person_plz',
                'personen.ort as person_ort',
                \DB::raw('GROUP_CONCAT(roles.title SEPARATOR ", ") as roles_assigned'),
                \DB::raw('GROUP_CONCAT(roles.name SEPARATOR ", ") as roles_names')
            )
            ->groupBy('users.id')
            ->where(function ($query) use ($columns) {
                if ($columns) {
                    foreach ($columns as $column) {
                        $table = $column['table'] . '.';
                        $filterField = $column['db_field']; // Use original db_field for filtering, not db_field_as
                        if ($column['filterable'] == true && $column['filtertype'] != 0) {
                            switch ($column['filtertype']) {
                                case 2:
                                    $query->where($table . $filterField, 'NOT LIKE', '%' . $column['filter'] . '%');
                                    break;
                                case 3:
                                    $query->where($table . $filterField, 'LIKE', $column['filter'] . '%');
                                    break;
                                case 4: //LEER
                                    $query->where(function ($q) use ($table, $filterField) {
                                        $q->whereNull($table . $filterField)
                                            ->orWhere($table . $filterField, '=', '')
                                            ->orWhere($table . $filterField, '=', '0000-00-00');
                                    });
                                    break;
                                case 5:  //NICHT LEER
                                    $query->whereNotNull($table . $filterField)
                                        ->where($table . $filterField, '<>', '')
                                        ->where($table . $filterField, '<>', '0000-00-00');
                                    break;
                                case 6:
                                    $query->where($table . $filterField, '=', $column['filter']);
                                    break;
                                case 7:
                                    $query->where($table . $filterField, '<>', $column['filter']);
                                    break;
                                case 8:
                                    $query->where($table . $filterField, '>', $column['filter'])
                                        ->where($table . $filterField, '<>', '');
                                    break;
                                case 9:
                                    $query->where($table . $filterField, '<', $column['filter'])
                                        ->where($table . $filterField, '<>', '');
                                    break;
                                case 10:
                                    $query->where($table . $filterField, '>=', $column['filter'])
                                        ->where($table . $filterField, '<>', '');
                                    break;
                                case 11:
                                    $query->where($table . $filterField, '<=', $column['filter'])
                                        ->where($table . $filterField, '<>', '');
                                    break;
                                case 12:
                                    $sqldate = date('Y-m-d', strtotime($column['filter']));
                                    $query->whereDate($table . $filterField, $sqldate);
                                    break;
                                case 13:
                                    $sqldate = date('Y-m-d', strtotime($column['filter']));
                                    $query->where($table . $filterField, '<=', $sqldate)
                                        ->where($table . $filterField, '<>', '0000-00-00');
                                    break;
                                case 14:
                                    $sqldate = date('Y-m-d', strtotime($column['filter']));
                                    $query->where($table . $filterField, '>=', $sqldate)
                                        ->where($table . $filterField, '<>', '0000-00-00');
                                    break;
                                case 1:
                                default:
                                    $query->where($table . $filterField, 'LIKE', '%' . $column['filter'] . '%');
                                    break;
                            }
                        }
                    }
                }
            })
            ->when($search != '', function ($query) use ($columns, $search) {
                if ($columns) {
                    $first = true;
                    foreach ($columns as $column) {
                        $table = $column['table'] . '.';
                        $searchField = $column['db_field']; // Use original db_field for search, not db_field_as
                        if ($column['searchable'] == true) {
                            if ($first == true) {
                                $query->where($table . $searchField, 'LIKE', '%' . $search . '%');
                                $first = false;
                            } else {
                                $query->orWhere($table . $searchField, 'LIKE', '%' . $search . '%');
                            }
                        }
                    }
                } else {
                    // Default search behavior when no columns are defined
                    $query->where(function ($q) use ($search) {
                        $q->where('users.name', 'LIKE', '%' . $search . '%')
                            ->orWhere('users.email', 'LIKE', '%' . $search . '%')
                            ->orWhere('personen.vorname', 'LIKE', '%' . $search . '%')
                            ->orWhere('personen.nachname', 'LIKE', '%' . $search . '%');
                    });
                }
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate($pagination);

        // Add abilities information to each user
        foreach ($users as $user) {
            // Get user's DIRECT abilities only (for display)
            $directAbilities = \DB::table('permissions')
                ->join('abilities', 'permissions.ability_id', '=', 'abilities.id')
                ->where('permissions.entity_type', 'App\Models\User')
                ->where('permissions.entity_id', $user->id)
                ->where('permissions.forbidden', 0)
                ->select('abilities.title', 'abilities.name', 'abilities.entity_type', 'abilities.entity_id', 'abilities.only_owned')
                ->get();

            // Get user's abilities from ROLES (for filtering)
            $roleAbilities = \DB::table('assigned_roles')
                ->join('permissions as role_permissions', function ($join) {
                    $join->on('role_permissions.entity_id', '=', 'assigned_roles.role_id')
                        ->where('role_permissions.entity_type', '=', 'roles')
                        ->where('role_permissions.forbidden', '=', 0);
                })
                ->join('abilities', 'role_permissions.ability_id', '=', 'abilities.id')
                ->where('assigned_roles.entity_type', 'App\Models\User')
                ->where('assigned_roles.entity_id', $user->id)
                ->select('abilities.title', 'abilities.name', 'abilities.entity_type', 'abilities.entity_id', 'abilities.only_owned')
                ->get();

            // Combine abilities for filtering (ALL abilities: direct + from roles)
            $allAbilities = $directAbilities->concat($roleAbilities)->unique(function ($item) {
                return $item->name . '|' . $item->entity_type . '|' . $item->entity_id . '|' . $item->only_owned;
            });

            // Display only direct abilities
            $user->abilities_assigned = $directAbilities->isEmpty() ? null : $directAbilities->pluck('title')->implode(', ');
            // For frontend filtering: include ALL abilities (direct + from roles) with full info
            $user->abilities_names = $allAbilities->isEmpty() ? null : $allAbilities->pluck('name')->implode(', ');
            $user->abilities_detailed = $allAbilities->map(function ($ability) {
                return [
                    'name' => $ability->name,
                    'entity_type' => $ability->entity_type,
                    'entity_id' => $ability->entity_id,
                    'only_owned' => $ability->only_owned,
                ];
            })->toArray();
        }

        return UserResource::collection($users);
    }

    /**
     * Simple list of users for assignments
     */
    public function list(): JsonResponse
    {
        $users = User::with('person')
            ->where('aktiv', true)
            ->orderBy('name')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'full_name' => $user->person ?
                        trim($user->person->vorname . ' ' . $user->person->nachname) :
                        $user->name,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'aktiv' => 'nullable|boolean',
            'person_id' => 'nullable|exists:personen,id',
            'person' => 'nullable|array',
            'person.nachname' => 'required_with:person|string|max:255',
            'person.vorname' => 'required_with:person|string|max:255',
            'person.strasse' => 'required_with:person|string|max:255',
            'person.postleitzahl' => 'required_with:person|string|max:10',
            'person.ort' => 'required_with:person|string|max:255',
        ]);

        $person_id = null;

        // Falls person_id direkt übergeben wurde, nutze diese
        if (isset($validated['person_id']) && $validated['person_id'] > 0) {
            $person_id = $validated['person_id'];
        }
        // Falls person Daten übergeben wurden, speichere oder finde Person
        elseif (isset($validated['person']) && ! empty($validated['person'])) {
            $personResult = $this->savePerson($validated['person']);
            $person_id = $personResult['person_id'];
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => $validated['aktiv'] ?? false,
            'person_id' => $person_id,
        ]);

        // Load relationships for response
        $user->load(['roles', 'person']);

        return response()->json($user, 201);
    }

    /**
     * Display the specified user
     */
    public function show(User $user): JsonResponse
    {
        $user->load(['roles', 'person']);

        return response()->json($user);
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'person_id' => 'nullable|exists:personen,id',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'person_id' => $validated['person_id'] ?? null,
        ];

        // Only update password if provided
        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        // Load relationships for response
        $user->load(['roles', 'person']);

        return response()->json($user);
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user): JsonResponse
    {
        // Check if user has critical relationships that prevent deletion
        // Add your business logic here if needed

        // Remove all role assignments
        $user->roles()->detach();

        // Delete the user
        $user->delete();

        return response()->json([
            'message' => 'Benutzer wurde erfolgreich gelöscht.',
        ]);
    }

    /**
     * Get all roles for a specific user
     */
    public function roles(User $user): JsonResponse
    {
        $roles = $user->roles()->select('roles.id', 'roles.name', 'roles.title')->get();

        return response()->json($roles);
    }

    /**
     * Assign a role to a user
     */
    public function assignRole(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $role = Role::find($validated['role_id']);

        // Check if user already has this role using the relationship
        if (! $user->roles->contains('id', $role->id)) {
            $user->assign($role);
        }

        return response()->json([
            'message' => 'Rolle wurde dem Benutzer zugewiesen.',
        ]);
    }

    /**
     * Remove a role from a user
     */
    public function removeRole(User $user, Role $role): JsonResponse
    {
        // Check if user has this role using the relationship
        if ($user->roles->contains('id', $role->id)) {
            $user->retract($role);
        }

        return response()->json([
            'message' => 'Rolle wurde vom Benutzer entfernt.',
        ]);
    }

    /**
     * Sync roles for a user (replace all current roles)
     */
    public function syncRoles(Request $request, User $user): JsonResponse
    {
        // Debug: Log incoming data
        \Log::info('syncRoles called', [
            'user_id' => $user->id,
            'request_data' => $request->all(),
        ]);

        // Validate either role_ids (IDs) or roles (names)
        $request->validate([
            'role_ids' => 'sometimes|array',
            'role_ids.*' => 'exists:roles,id',
            'roles' => 'sometimes|array',
            'roles.*' => 'string',
        ]);

        // Get roles either by IDs or by names
        if ($request->has('role_ids')) {
            $roles = Role::whereIn('id', $request->role_ids)->get();
            \Log::info('Using role_ids', ['roles' => $roles->pluck('name')]);
        } elseif ($request->has('roles')) {
            $roles = Role::whereIn('name', $request->roles)->get();
            \Log::info('Using role names', [
                'requested_names' => $request->roles,
                'found_roles' => $roles->pluck('name'),
            ]);
        } else {
            return response()->json(['error' => 'Either role_ids or roles must be provided'], 400);
        }

        // Remove all current roles
        foreach ($user->roles as $currentRole) {
            \Log::info('Removing role', ['role' => $currentRole->name]);
            $user->retract($currentRole);
        }

        // Assign new roles
        foreach ($roles as $role) {
            \Log::info('Assigning role', ['role' => $role->name]);
            $user->assign($role);
        }

        \Log::info('syncRoles completed', [
            'user_id' => $user->id,
            'final_roles' => $roles->pluck('name'),
        ]);

        return response()->json([
            'message' => 'Rollen wurden für den Benutzer synchronisiert.',
            'roles' => $roles->pluck('name'),
        ]);
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin(User $user): JsonResponse
    {
        $user->update([
            'lastlogin_at' => now(),
        ]);

        return response()->json([
            'message' => 'Letzter Login wurde aktualisiert.',
        ]);
    }

    /**
     * Get a user's abilities
     */
    public function abilities(User $user): JsonResponse
    {
        // Get abilities with entity information from abilities table
        $abilities = \DB::table('permissions')
            ->join('abilities', 'permissions.ability_id', '=', 'abilities.id')
            ->where('permissions.entity_type', 'App\Models\User')
            ->where('permissions.entity_id', $user->id)
            ->where('permissions.forbidden', 0)
            ->select(
                'abilities.id',
                'abilities.name',
                'abilities.title',
                'abilities.entity_id as target_entity_id',
                'abilities.entity_type as target_entity_type'
            )
            ->get();

        return response()->json($abilities);
    }

    /**
     * Get user roles and direct abilities combined
     */
    public function getPermissions(User $user): JsonResponse
    {
        // Get user roles
        $roles = $user->roles()->with('abilities')->get();

        // Get direct abilities (individual permissions)
        $directAbilities = \DB::table('permissions')
            ->join('abilities', 'permissions.ability_id', '=', 'abilities.id')
            ->where('permissions.entity_type', 'App\Models\User')
            ->where('permissions.entity_id', $user->id)
            ->where('permissions.forbidden', 0)
            ->select(
                'abilities.id',
                'abilities.name',
                'abilities.title',
                'abilities.entity_id',
                'abilities.entity_type'
            )
            ->get();

        return response()->json([
            'roles' => $roles,
            'direct_abilities' => $directAbilities,
        ]);
    }

    /**
     * Add a single ability to user
     */
    public function addAbility(Request $request, User $user): JsonResponse
    {
        // Validate input
        $request->validate([
            'ability_name' => 'required|string',
            'entity_id' => 'nullable|integer',
            'entity_type' => 'nullable|string',
        ]);

        $abilityName = $request->ability_name;
        $entityId = $request->entity_id;
        $entityType = $request->entity_type;

        // Debug logging
        \Log::info('addAbility called', [
            'user_id' => $user->id,
            'ability_name' => $abilityName,
            'entity_id' => $entityId,
            'entity_type' => $entityType,
            'request_data' => $request->all(),
        ]);

        try {
            if ($entityId && $entityType) {
                // Specific entity ability
                $modelClass = $entityType;
                if (class_exists($modelClass)) {
                    $modelInstance = $modelClass::find($entityId);
                    if ($modelInstance) {
                        // Use Bouncer's allow with model instance
                        $user->allow($abilityName, $modelInstance);
                    } else {
                        // Model instance not found, create ability manually
                        $ability = \Silber\Bouncer\Database\Ability::updateOrCreate([
                            'name' => $abilityName,
                            'entity_id' => $entityId,
                            'entity_type' => $entityType,
                        ], [
                            'title' => ucfirst(str_replace('-', ' ', $abilityName)) . ' ' . (class_basename($entityType) ?: '') . ' #' . $entityId,
                        ]);

                        // Versuche Zuweisung über Bouncer
                        $user->allow($ability);
                        // Fallback: Permission direkt in die Tabelle schreiben, falls keine Permission angelegt wurde
                        $permissionExists = \DB::table('permissions')
                            ->where('entity_type', 'App\\Models\\User')
                            ->where('entity_id', $user->id)
                            ->where('ability_id', $ability->id)
                            ->exists();
                        if (! $permissionExists) {
                            \DB::table('permissions')->insert([
                                'ability_id' => $ability->id,
                                'entity_type' => 'App\\Models\\User',
                                'entity_id' => $user->id,
                                'forbidden' => 0,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                } else {
                    // Unknown entity type, create generic ability
                    $ability = \Silber\Bouncer\Database\Ability::updateOrCreate([
                        'name' => $abilityName,
                        'entity_id' => $entityId,
                        'entity_type' => $entityType,
                    ], [
                        'title' => ucfirst(str_replace('-', ' ', $abilityName)) . ' ' . (class_basename($entityType) ?: '') . ' #' . $entityId,
                    ]);

                    // Versuche Zuweisung über Bouncer
                    $user->allow($ability);
                    // Fallback: Permission direkt in die Tabelle schreiben, falls keine Permission angelegt wurde
                    $permissionExists = \DB::table('permissions')
                        ->where('entity_type', 'App\\Models\\User')
                        ->where('entity_id', $user->id)
                        ->where('ability_id', $ability->id)
                        ->exists();
                    if (! $permissionExists) {
                        \DB::table('permissions')->insert([
                            'ability_id' => $ability->id,
                            'entity_type' => 'App\\Models\\User',
                            'entity_id' => $user->id,
                            'forbidden' => 0,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            } else {
                // General ability - find existing ability with matching name and entity_type
                $ability = \Silber\Bouncer\Database\Ability::where('name', $abilityName)
                    ->where('entity_type', $entityType)
                    ->whereNull('entity_id')
                    ->first();

                if ($ability) {
                    // Use existing ability
                    $user->allow($ability);
                } else {
                    // Create the general ability with correct entity_type
                    $ability = \Silber\Bouncer\Database\Ability::updateOrCreate([
                        'name' => $abilityName,
                        'entity_id' => null,
                    ], [
                        'entity_type' => $entityType,
                        'title' => ucfirst(str_replace('-', ' ', $abilityName)) . ' ' . ($entityType ? class_basename($entityType) : ''),
                    ]);

                    $user->allow($ability);
                }
            }

            return response()->json([
                'message' => 'Berechtigung wurde hinzugefügt.',
                'ability' => [
                    'name' => $abilityName,
                    'entity_id' => $entityId,
                    'entity_type' => $entityType,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Fehler beim Hinzufügen der Berechtigung: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Sync abilities for a user (replace all current abilities)
     */
    public function syncAbilities(Request $request, User $user): JsonResponse
    {
        // Validate input - now supports entity information
        $request->validate([
            'abilities' => 'required|array',
            'abilities.*' => 'required|array',
            'abilities.*.name' => 'required|string',
            'abilities.*.entity_id' => 'nullable|integer',
            'abilities.*.entity_type' => 'nullable|string',
        ]);

        // Remove all current direct abilities (not from roles)
        \DB::table('permissions')
            ->where('entity_type', 'App\Models\User')
            ->where('entity_id', $user->id)
            ->delete();

        // Add new abilities
        foreach ($request->abilities as $abilityData) {
            $abilityName = $abilityData['name'];

            // If entity_id is provided, we need to find or create the specific ability
            if (isset($abilityData['entity_id']) && $abilityData['entity_id']) {
                $entityId = $abilityData['entity_id'];
                $entityType = $abilityData['entity_type'] ?? 'App\Models\User'; // Default to User model

                // Try to find existing model instance
                $modelClass = $entityType;
                if (class_exists($modelClass)) {
                    $modelInstance = $modelClass::find($entityId);
                    if ($modelInstance) {
                        // Use Bouncer's allow with model instance
                        $user->allow($abilityName, $modelInstance);
                    } else {
                        // Model instance not found, but we can still create the ability manually
                        // This creates an ability with the specific entity_id and entity_type
                        $ability = \Silber\Bouncer\Database\Ability::firstOrCreate([
                            'name' => $abilityName,
                            'entity_type' => $entityType,
                            'entity_id' => $entityId,
                        ], [
                            'title' => ucfirst(str_replace('-', ' ', $abilityName)) . ' ' . class_basename($entityType) . ' #' . $entityId,
                        ]);

                        $user->allow($ability);
                    }
                } else {
                    // Unknown entity type, create generic ability with entity info
                    $ability = \Silber\Bouncer\Database\Ability::firstOrCreate([
                        'name' => $abilityName,
                        'entity_type' => $entityType,
                        'entity_id' => $entityId,
                    ], [
                        'title' => ucfirst(str_replace('-', ' ', $abilityName)) . ' #' . $entityId,
                    ]);

                    $user->allow($ability);
                }
            } else {
                // General ability without specific entity
                $user->allow($abilityName);
            }
        }

        return response()->json([
            'message' => 'Berechtigungen wurden für den Benutzer synchronisiert.',
            'abilities' => $request->abilities,
        ]);
    }

    /**
     * Remove a specific ability from user and cleanup if needed
     */
    public function removeAbility(User $user, Request $request): JsonResponse
    {
        $request->validate([
            'ability_name' => 'required|string',
            'entity_id' => 'nullable|integer',
            'entity_type' => 'nullable|string',
        ]);

        $abilityName = $request->ability_name;
        $entityId = $request->entity_id;
        $entityType = $request->entity_type;

        // Debug logging
        \Log::info('removeAbility called', [
            'user_id' => $user->id,
            'ability_name' => $abilityName,
            'entity_id' => $entityId,
            'entity_type' => $entityType,
            'request_data' => $request->all(),
            'request_content_type' => $request->header('Content-Type'),
            'request_method' => $request->method(),
            'raw_input' => $request->getContent(),
        ]);

        // Find the specific ability
        $abilityQuery = \Silber\Bouncer\Database\Ability::where('name', $abilityName);

        if ($entityType) {
            // If entity_type is specified, use it (entity_id can be null)
            $abilityQuery->where('entity_type', $entityType);
            if ($entityId) {
                $abilityQuery->where('entity_id', $entityId);
            } else {
                $abilityQuery->whereNull('entity_id');
            }
        } else {
            // If no entity_type, look for general abilities
            $abilityQuery->whereNull('entity_id')
                ->whereNull('entity_type');
        }

        $ability = $abilityQuery->first();

        if (! $ability) {
            return response()->json(['error' => 'Ability nicht gefunden'], 404);
        }

        // Remove the permission (user-ability connection)
        \DB::table('permissions')
            ->where('entity_type', 'App\Models\User')
            ->where('entity_id', $user->id)
            ->where('ability_id', $ability->id)
            ->delete();

        // Cleanup: If this ability has entity_id/entity_type and no other user has it, delete the ability
        if ($ability->entity_id && $ability->entity_type) {
            $otherUsersCount = \DB::table('permissions')
                ->where('ability_id', $ability->id)
                ->where(function ($query) use ($user) {
                    $query->where('entity_type', '!=', 'App\Models\User')
                        ->orWhere('entity_id', '!=', $user->id);
                })
                ->count();

            if ($otherUsersCount === 0) {
                // No other users have this specific ability, safe to delete
                $ability->delete();
                $message = 'Berechtigung wurde entfernt und Ability wurde aufgeräumt (keine anderen Nutzer).';
            } else {
                $message = 'Berechtigung wurde entfernt (Ability bleibt für andere Nutzer bestehen).';
            }
        } else {
            // General ability - never delete, just remove permission
            $message = 'Berechtigung wurde entfernt (allgemeine Ability bleibt verfügbar).';
        }

        return response()->json([
            'message' => $message,
            'ability_cleaned' => $ability->entity_id && $ability->entity_type && $otherUsersCount === 0,
        ]);
    }

    /**
     * Toggle user active status
     */
    public function toggleActive(User $user): JsonResponse
    {
        $user->update([
            'aktiv' => ! $user->aktiv,
        ]);

        return response()->json([
            'message' => $user->aktiv ? 'Benutzer wurde aktiviert.' : 'Benutzer wurde deaktiviert.',
            'aktiv' => $user->aktiv,
        ]);
    }

    /**
     * Link a person to the user
     */
    public function linkPerson(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'person_id' => 'required|exists:personen,id',
        ]);

        $user->update([
            'person_id' => $request->person_id,
        ]);

        return response()->json([
            'message' => 'Person wurde erfolgreich verknüpft.',
            'user' => new UserResource($user->load('person')),
            'person' => $user->person,
        ]);
    }

    /**
     * Create new person and link to user
     */
    public function createAndLinkPerson(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'person.vorname' => 'required|string|max:255',
            'person.nachname' => 'required|string|max:255',
            'person.anrede.id' => 'required|integer|min:1',
            'person.strasse' => 'required|string|max:255',
            'person.postleitzahl' => 'required|string|max:10',
            'person.ort' => 'required|string|max:255',
        ]);

        try {
            \DB::beginTransaction();

            $personData = $request->input('person');

            // Transform anrede to proper format for SavePerson trait
            if (isset($personData['anrede']['id'])) {
                $personData['anrede_id'] = $personData['anrede']['id'];
            }

            // Set proper id (null or 0 should be 0 for new person)
            $personData['id'] = 0;

            // Set defaults for optional fields
            $personData['adelstitel'] = $personData['adelstitel'] ?? '';
            $personData['akademischetitel'] = $personData['akademischetitel'] ?? '';
            $personData['adresszusatz'] = $personData['adresszusatz'] ?? '';
            $personData['land'] = $personData['land'] ?? 'Deutschland';
            $personData['mitgliedsnummer'] = $personData['mitgliedsnummer'] ?? '';
            $personData['telefon_1'] = $personData['telefon_1'] ?? '';
            $personData['telefon_2'] = $personData['telefon_2'] ?? '';
            $personData['email_1'] = $personData['email_1'] ?? '';
            $personData['email_2'] = $personData['email_2'] ?? '';
            $personData['website_1'] = $personData['website_1'] ?? '';
            $personData['website_2'] = $personData['website_2'] ?? '';
            $personData['personenadresse_id'] = 0; // New person, no existing address

            // Use SavePerson trait to create or find existing person
            $result = $this->savePerson($personData);
            $personId = $result['person_id'];
            $wasCreated = $result['was_created'];

            if ($personId === 0 || $personId === null) {
                \DB::rollBack();

                return response()->json([
                    'message' => 'Person konnte nicht erstellt werden. Möglicherweise fehlen Pflichtfelder.',
                ], 422);
            }

            // Verify person exists before linking
            $person = Person::find($personId);
            if (! $person) {
                \DB::rollBack();

                return response()->json([
                    'message' => 'Erstellte Person konnte nicht gefunden werden.',
                ], 422);
            }

            // Link person to user
            $user->update([
                'person_id' => $personId,
            ]);

            \DB::commit();

            $user->load('person');

            $message = $wasCreated
                ? 'Person wurde erfolgreich erstellt und verknüpft.'
                : 'Person wurde in der Datenbank gefunden und verknüpft.';

            return response()->json([
                'message' => $message,
                'user' => new UserResource($user),
                'person' => $user->person,
                'person_id' => $personId,
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json([
                'message' => 'Fehler beim Erstellen der Person: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Unlink person from user
     */
    public function unlinkPerson(User $user): JsonResponse
    {
        $user->update([
            'person_id' => null,
        ]);

        return response()->json([
            'message' => 'Person-Verknüpfung wurde entfernt.',
            'user' => new UserResource($user->fresh()),
        ]);
    }

    /**
     * Upload profile photo
     */
    public function uploadPhoto(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');

            $user->update([
                'profile_photo_path' => $path,
            ]);

            return response()->json([
                'message' => 'Profilbild wurde erfolgreich hochgeladen.',
                'photo_url' => asset('storage/' . $path),
            ]);
        }

        return response()->json([
            'message' => 'Kein Bild hochgeladen.',
        ], 400);
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Passwort wurde erfolgreich zurückgesetzt.',
        ]);
    }
}
