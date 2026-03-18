<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificationTemplateRequest;
use App\Http\Requests\UpdateNotificationTemplateRequest;
use App\Models\NotificationTemplate;
use App\Models\Role;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationTemplateController extends Controller
{
    /**
     * Display a listing of the notification templates.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = NotificationTemplate::with(['section', 'assignables.assignable']);

            // Filter by search term
            if ($request->has('search') && ! empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('thema', 'like', "%{$search}%")
                        ->orWhere('vue_komponente', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('text', 'like', "%{$search}%")
                        ->orWhereHas('section', function ($sq) use ($search) {
                            $sq->where('name', 'like', "%{$search}%")
                                ->orWhere('name_kurz', 'like', "%{$search}%");
                        });
                });
            }

            // Filter by section
            if ($request->has('section_id') && ! empty($request->section_id)) {
                $query->where('section_id', $request->section_id);
            }

            // Filter by active status
            if ($request->has('active') && $request->active !== '') {
                $query->where('active', (bool) $request->active);
            }

            // Sorting
            $sortField = $request->get('sort_field', 'id');
            $sortDirection = $request->get('sort_direction', 'asc');

            $allowedSortFields = ['id', 'thema', 'position', 'vue_komponente', 'slug', 'active', 'created_at'];
            if (in_array($sortField, $allowedSortFields)) {
                $query->orderBy($sortField, $sortDirection);
            }

            // Pagination
            $perPage = $request->get('per_page', 25);
            $templates = $query->paginate($perPage);

            // Transform data with assignable counts
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
                    'vue_komponente' => $template->vue_komponente,
                    'slug' => $template->slug,
                    'text' => $template->text,
                    'active' => $template->active,
                    'created_at' => $template->created_at,
                    'updated_at' => $template->updated_at,
                    'roles_count' => $assignableData['roles_count'],
                    'users_count' => $assignableData['users_count'],
                    'datenobjekte_count' => $assignableData['datenobjekte_count'],
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
                'success' => 'Notification Templates erfolgreich geladen.',
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
                'error' => 'Fehler beim Laden der Notification Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created notification template.
     */
    public function store(StoreNotificationTemplateRequest $request): JsonResponse
    {
        try {
            $template = NotificationTemplate::create($request->validated());

            // Handle assignables if provided
            if ($request->has('assignables')) {
                $this->updateAssignables($template, $request->assignables);
            }

            $template->load(['section', 'assignables']);
            $assignableData = $this->getAssignableData($template);

            return response()->json([
                'success' => 'Notification Template erfolgreich erstellt.',
                'data' => [
                    'id' => $template->id,
                    'section' => $template->section ? [
                        'id' => $template->section->id,
                        'name' => $template->section->name,
                        'name_kurz' => $template->section->name_kurz,
                    ] : null,
                    'thema' => $template->thema,
                    'position' => $template->position,
                    'vue_komponente' => $template->vue_komponente,
                    'slug' => $template->slug,
                    'text' => $template->text,
                    'active' => $template->active,
                    'created_at' => $template->created_at,
                    'updated_at' => $template->updated_at,
                    'roles_count' => $assignableData['roles_count'],
                    'users_count' => $assignableData['users_count'],
                    'datenobjekte_count' => $assignableData['datenobjekte_count'],
                    'assignables_summary' => $assignableData['summary'],
                ],
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Erstellen des Notification Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified notification template.
     */
    public function show(NotificationTemplate $notificationTemplate): JsonResponse
    {
        try {
            $notificationTemplate->load(['section', 'assignables.assignable']);

            $assignableData = $this->getAssignableData($notificationTemplate);
            $detailedAssignables = $this->getDetailedAssignables($notificationTemplate);

            return response()->json([
                'success' => 'Notification Template erfolgreich geladen.',
                'data' => [
                    'id' => $notificationTemplate->id,
                    'section' => $notificationTemplate->section ? [
                        'id' => $notificationTemplate->section->id,
                        'name' => $notificationTemplate->section->name,
                        'name_kurz' => $notificationTemplate->section->name_kurz,
                    ] : null,
                    'thema' => $notificationTemplate->thema,
                    'position' => $notificationTemplate->position,
                    'vue_komponente' => $notificationTemplate->vue_komponente,
                    'slug' => $notificationTemplate->slug,
                    'text' => $notificationTemplate->text,
                    'active' => $notificationTemplate->active,
                    'created_at' => $notificationTemplate->created_at,
                    'updated_at' => $notificationTemplate->updated_at,
                    'roles_count' => $assignableData['roles_count'],
                    'users_count' => $assignableData['users_count'],
                    'datenobjekte_count' => $assignableData['datenobjekte_count'],
                    'assignables_summary' => $assignableData['summary'],
                    'assignables_detailed' => $detailedAssignables,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden des Notification Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified notification template.
     */
    public function update(UpdateNotificationTemplateRequest $request, NotificationTemplate $notificationTemplate): JsonResponse
    {
        try {
            $notificationTemplate->update($request->validated());

            // Handle assignables if provided
            if ($request->has('assignables')) {
                $this->updateAssignables($notificationTemplate, $request->assignables);
            }

            $notificationTemplate->load(['section', 'assignables']);
            $assignableData = $this->getAssignableData($notificationTemplate);

            return response()->json([
                'success' => 'Notification Template erfolgreich aktualisiert.',
                'data' => [
                    'id' => $notificationTemplate->id,
                    'section' => $notificationTemplate->section ? [
                        'id' => $notificationTemplate->section->id,
                        'name' => $notificationTemplate->section->name,
                        'name_kurz' => $notificationTemplate->section->name_kurz,
                    ] : null,
                    'thema' => $notificationTemplate->thema,
                    'position' => $notificationTemplate->position,
                    'vue_komponente' => $notificationTemplate->vue_komponente,
                    'slug' => $notificationTemplate->slug,
                    'text' => $notificationTemplate->text,
                    'active' => $notificationTemplate->active,
                    'created_at' => $notificationTemplate->created_at,
                    'updated_at' => $notificationTemplate->updated_at,
                    'roles_count' => $assignableData['roles_count'],
                    'users_count' => $assignableData['users_count'],
                    'datenobjekte_count' => $assignableData['datenobjekte_count'],
                    'assignables_summary' => $assignableData['summary'],
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Aktualisieren des Notification Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified notification template.
     */
    public function destroy(NotificationTemplate $notificationTemplate): JsonResponse
    {
        try {
            $notificationTemplate->delete();

            return response()->json([
                'success' => 'Notification Template erfolgreich gelöscht.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Löschen des Notification Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Test notification template by sending to specific user(s).
     */
    public function test(Request $request, NotificationTemplate $notificationTemplate): JsonResponse
    {
        $request->validate([
            'user_id' => 'required_without:user_ids|exists:users,id',
            'user_ids' => 'required_without:user_id|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        try {
            $userIds = [];

            // Support both single user_id and multiple user_ids
            if ($request->has('user_id')) {
                $userIds = [$request->user_id];
            } elseif ($request->has('user_ids')) {
                $userIds = $request->user_ids;
            }

            $users = User::whereIn('id', $userIds)->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'error' => 'Keine gültigen Benutzer gefunden.',
                ], 400);
            }

            // Create notifications for each user
            $createdNotifications = [];
            foreach ($users as $user) {
                $notification = \App\Models\Notification::create([
                    'message' => "Test: {$notificationTemplate->text}",
                    'receiver_id' => $user->id,
                    'path' => $notificationTemplate->vue_komponente ?? '/dashboard',
                    'pathname' => $notificationTemplate->thema,
                ]);

                // Broadcast the notification via Reverb
                broadcast(new \App\Events\SendNotification($notification));

                $createdNotifications[] = $notification->id;
            }

            $recipients = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ];
            });

            $message = count($users) === 1
                ? "Test-Notification erfolgreich an {$users->first()->name} gesendet."
                : 'Test-Notification erfolgreich an ' . count($users) . ' Benutzer gesendet.';

            return response()->json([
                'success' => $message,
                'data' => [
                    'template_id' => $notificationTemplate->id,
                    'template_slug' => $notificationTemplate->slug,
                    'recipients' => $recipients,
                    'recipients_count' => count($users),
                    'notification_ids' => $createdNotifications,
                    'sent_at' => now(),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Senden der Test-Notification: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get available sections for dropdown.
     */
    public function getSections(): JsonResponse
    {
        try {
            $sections = Section::where('aktiv', true)
                ->orderBy('order')
                ->orderBy('name')
                ->get(['id', 'name', 'name_kurz']);

            return response()->json([
                'success' => 'Sections erfolgreich geladen.',
                'data' => $sections,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden der Sections: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get available roles for assignment.
     */
    public function getRoles(): JsonResponse
    {
        try {
            $roles = Role::orderBy('title')->get(['id', 'name', 'title']);

            return response()->json([
                'success' => 'Rollen erfolgreich geladen.',
                'data' => $roles,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden der Rollen: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get available users for assignment.
     */
    public function getUsers(Request $request): JsonResponse
    {
        try {
            $query = User::orderBy('name');

            // Add search functionality
            if ($request->has('search') && ! empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $users = $query->get(['id', 'name', 'email']);

            return response()->json([
                'success' => 'Users erfolgreich geladen.',
                'data' => $users,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden der Users: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get available data object types.
     */
    public function getDataObjectTypes(): JsonResponse
    {
        try {
            $types = NotificationTemplate::getAvailableDataObjectTypes();

            return response()->json([
                'success' => 'Datenobjekt-Typen erfolgreich geladen.',
                'data' => $types,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden der Datenobjekt-Typen: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get assignable data for template.
     */
    private function getAssignableData(NotificationTemplate $template): array
    {
        $roles = $template->assignables()->where('assignable_type', 'App\\Models\\Role')->count();
        $users = $template->assignables()->where('assignable_type', 'App\\Models\\User')->count();

        // Count other data object types
        $datenobjekte = $template->assignables()
            ->whereNotIn('assignable_type', ['App\\Models\\Role', 'App\\Models\\User'])
            ->count();

        $summary = [];
        if ($roles > 0) {
            $summary[] = "{$roles} Rolle(n)";
        }
        if ($users > 0) {
            $summary[] = "{$users} User";
        }
        if ($datenobjekte > 0) {
            $summary[] = "{$datenobjekte} Datenobjekt(e)";
        }

        return [
            'roles_count' => $roles,
            'users_count' => $users,
            'datenobjekte_count' => $datenobjekte,
            'summary' => implode(', ', $summary) ?: 'Keine Zuordnungen',
        ];
    }

    /**
     * Get detailed assignables for template.
     */
    private function getDetailedAssignables(NotificationTemplate $template): array
    {
        $assignables = $template->assignables()->with('assignable')->get();

        $result = [
            'roles' => [],
            'users' => [],
        ];

        foreach ($assignables as $assignable) {
            if ($assignable->assignable_type === 'App\\Models\\Role') {
                $result['roles'][] = [
                    'id' => $assignable->assignable->id,
                    'name' => $assignable->assignable->name,
                    'title' => $assignable->assignable->title,
                ];
            } elseif ($assignable->assignable_type === 'App\\Models\\User') {
                $result['users'][] = [
                    'id' => $assignable->assignable->id,
                    'name' => $assignable->assignable->name,
                    'email' => $assignable->assignable->email,
                ];
            }
        }

        return $result;
    }

    /**
     * Update assignables for template.
     */
    private function updateAssignables(NotificationTemplate $template, array $assignables): void
    {
        // Clear existing assignables
        $template->assignables()->delete();

        // Add new assignables
        foreach ($assignables as $assignable) {
            if (isset($assignable['type']) && isset($assignable['id'])) {
                $template->assignables()->create([
                    'assignable_type' => $assignable['type'],
                    'assignable_id' => $assignable['id'],
                ]);
            }
        }
    }

    /**
     * Get display name for assignable object.
     */
    private function getDisplayName($assignable): string
    {
        if (method_exists($assignable, 'getDisplayName')) {
            return $assignable->getDisplayName();
        }

        if (isset($assignable->name)) {
            return $assignable->name;
        }

        if (isset($assignable->title)) {
            return $assignable->title;
        }

        return "ID: {$assignable->id}";
    }

    /**
     * Get list of available sections for assignment
     */
    public function sectionsList()
    {
        $sections = Section::select('id', 'name', 'name_kurz')->get();

        return response()->json([
            'data' => $sections,
        ]);
    }

    /**
     * Get list of available roles for assignment
     */
    public function rolesList()
    {
        $roles = Role::select('id', 'name', 'title')->get();

        return response()->json([
            'data' => $roles,
        ]);
    }

    /**
     * Get list of available users for assignment
     */
    public function usersList()
    {
        $users = User::with('roles:id,title')->select('id', 'name', 'email')->get();

        return response()->json([
            'data' => $users,
        ]);
    }

    /**
     * Search users for autocomplete (min 4 chars, max 50 results)
     */
    public function usersSearch(Request $request)
    {
        // Support both GET params and POST body
        $query = $request->input('q') ?? $request->get('q', '');
        $limit = (int) ($request->input('limit') ?? $request->get('limit', 50));

        // Minimum 4 characters required
        if (strlen($query) < 4) {
            return response()->json([
                'error' => 'Mindestens 4 Zeichen erforderlich',
                'data' => [],
            ], 400);
        }

        // Maximum 50 results to prevent overload
        $limit = min($limit, 50);

        $users = User::select('id', 'name', 'email')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            })
            ->orderBy('name')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $users,
            'meta' => [
                'count' => $users->count(),
                'query' => $query,
                'limit' => $limit,
            ],
        ]);
    }

    /**
     * Get list of available data objects by type for assignment
     */
    public function dataObjectsList($type)
    {
        $decodedType = urldecode($type);

        // Basic validation that the type is a valid model
        if (! class_exists($decodedType)) {
            return response()->json([
                'error' => 'Invalid data object type',
                'data' => [],
            ], 400);
        }

        try {
            $model = app($decodedType);

            // Basic query - may need to be customized per model type
            $objects = $model->select('id')
                ->when(method_exists($model, 'getRouteKeyName'), function ($query) use ($model) {
                    $query->addSelect($model->getRouteKeyName());
                })
                ->when($model->getTable() === 'users', function ($query) {
                    $query->addSelect(['name', 'email']);
                })
                ->when($model->getTable() === 'mitglieder', function ($query) {
                    $query->addSelect(['vorname', 'nachname']);
                })
                ->when(in_array('name', $model->getFillable()), function ($query) {
                    $query->addSelect('name');
                })
                ->when(in_array('title', $model->getFillable()), function ($query) {
                    $query->addSelect('title');
                })
                ->when(in_array('bezeichnung', $model->getFillable()), function ($query) {
                    $query->addSelect('bezeichnung');
                })
                ->when(in_array('rasse', $model->getFillable()), function ($query) {
                    $query->addSelect('rasse');
                })
                ->limit(100)
                ->get();

            return response()->json([
                'data' => $objects,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error loading data objects: ' . $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    /**
     * Assign role(s) to a notification template.
     * Supports both single role_id and multiple role_ids.
     */
    public function assignRole(Request $request, NotificationTemplate $notificationTemplate): JsonResponse
    {
        try {
            // Validate input - accept either single role_id or array of role_ids
            $request->validate([
                'role_id' => 'required_without:role_ids|exists:roles,id',
                'role_ids' => 'required_without:role_id|array',
                'role_ids.*' => 'exists:roles,id',
            ]);

            $roleIds = [];

            // Handle single role_id (backward compatibility)
            if ($request->has('role_id')) {
                $roleIds = [$request->role_id];
            }

            // Handle multiple role_ids
            if ($request->has('role_ids')) {
                $roleIds = $request->role_ids;
            }

            $assignedRoles = [];
            $alreadyAssigned = [];
            $errors = [];

            foreach ($roleIds as $roleId) {
                try {
                    $role = Role::findOrFail($roleId);

                    // Check if already assigned
                    $exists = $notificationTemplate->assignables()
                        ->where('assignable_type', Role::class)
                        ->where('assignable_id', $role->id)
                        ->exists();

                    if ($exists) {
                        $alreadyAssigned[] = $role->title ?? $role->name;
                        continue;
                    }

                    // Assign the role
                    $notificationTemplate->assignables()->create([
                        'assignable_type' => Role::class,
                        'assignable_id' => $role->id,
                    ]);

                    $assignedRoles[] = $role;

                } catch (\Exception $e) {
                    $errors[] = "Error with role ID {$roleId}: " . $e->getMessage();
                }
            }

            // Prepare response
            $responseData = [
                'assigned_roles' => $assignedRoles,
                'already_assigned' => $alreadyAssigned,
                'errors' => $errors,
            ];

            if (count($assignedRoles) > 0) {
                $message = count($assignedRoles) === 1
                    ? 'Role assigned successfully'
                    : count($assignedRoles) . ' roles assigned successfully';

                if (count($alreadyAssigned) > 0) {
                    $message .= ' (' . count($alreadyAssigned) . ' already assigned)';
                }

                return response()->json([
                    'success' => $message,
                    'data' => $responseData,
                ]);
            } elseif (count($alreadyAssigned) > 0) {
                return response()->json([
                    'error' => 'All selected roles are already assigned',
                    'success' => false,
                    'data' => $responseData,
                ], 422);
            } else {
                return response()->json([
                    'error' => 'No roles could be assigned',
                    'success' => false,
                    'data' => $responseData,
                ], 422);
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error assigning roles: ' . $e->getMessage(),
                'success' => false,
                'data' => [],
            ], 500);
        }
    }

    /**
     * Unassign a role from a notification template.
     */
    public function unassignRole(NotificationTemplate $notificationTemplate, Role $role): JsonResponse
    {
        try {
            $assignment = $notificationTemplate->assignables()
                ->where('assignable_type', Role::class)
                ->where('assignable_id', $role->id)
                ->first();

            if (! $assignment) {
                return response()->json([
                    'error' => 'Role is not assigned to this template',
                    'success' => false,
                ], 404);
            }

            $assignment->delete();

            return response()->json([
                'success' => 'Role unassigned successfully',
                'data' => $role,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error unassigning role: ' . $e->getMessage(),
                'success' => false,
            ], 500);
        }
    }

    /**
     * Assign a user to a notification template.
     */
    public function assignUser(Request $request, NotificationTemplate $notificationTemplate): JsonResponse
    {
        try {
            // Support both single user_id and multiple user_ids
            if ($request->has('user_ids')) {
                // Bulk assignment
                $request->validate([
                    'user_ids' => 'required|array',
                    'user_ids.*' => 'exists:users,id',
                ]);

                $userIds = $request->user_ids;
                $addedCount = 0;
                $skippedCount = 0;

                foreach ($userIds as $userId) {
                    $exists = $notificationTemplate->assignables()
                        ->where('assignable_type', User::class)
                        ->where('assignable_id', $userId)
                        ->exists();

                    if (! $exists) {
                        $notificationTemplate->assignables()->create([
                            'assignable_type' => User::class,
                            'assignable_id' => $userId,
                        ]);
                        $addedCount++;
                    } else {
                        $skippedCount++;
                    }
                }

                return response()->json([
                    'success' => 'Users assigned successfully',
                    'data' => [
                        'added_count' => $addedCount,
                        'skipped_count' => $skippedCount,
                        'total_processed' => count($userIds),
                    ],
                ]);

            } else {
                // Single assignment
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                ]);

                $user = User::findOrFail($request->user_id);

                // Check if already assigned
                $exists = $notificationTemplate->assignables()
                    ->where('assignable_type', User::class)
                    ->where('assignable_id', $user->id)
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'error' => 'User is already assigned to this template',
                        'success' => false,
                    ], 422);
                }

                // Assign the user
                $notificationTemplate->assignables()->create([
                    'assignable_type' => User::class,
                    'assignable_id' => $user->id,
                ]);

                return response()->json([
                    'success' => 'User assigned successfully',
                    'data' => $user,
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error assigning user: ' . $e->getMessage(),
                'success' => false,
            ], 500);
        }
    }

    /**
     * Unassign a user from a notification template.
     */
    public function unassignUser(NotificationTemplate $notificationTemplate, User $user): JsonResponse
    {
        try {
            $assignment = $notificationTemplate->assignables()
                ->where('assignable_type', User::class)
                ->where('assignable_id', $user->id)
                ->first();

            if (! $assignment) {
                return response()->json([
                    'error' => 'User is not assigned to this template',
                    'success' => false,
                ], 404);
            }

            $assignment->delete();

            return response()->json([
                'success' => 'User unassigned successfully',
                'data' => $user,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error unassigning user: ' . $e->getMessage(),
                'success' => false,
            ], 500);
        }
    }

    // /**
    //  * Assign a role to a notification template.
    //  */
    // public function assignRole(Request $request, NotificationTemplate $notificationTemplate): JsonResponse
    // {
    //     try {
    //         $request->validate([
    //             'role_id' => 'required|exists:roles,id'
    //         ]);

    //         $role = Role::findOrFail($request->role_id);

    //         // Check if already assigned
    //         $exists = $notificationTemplate->assignables()
    //             ->where('assignable_type', Role::class)
    //             ->where('assignable_id', $role->id)
    //             ->exists();

    //         if ($exists) {
    //             return response()->json([
    //                 'error' => 'Role is already assigned to this template',
    //                 'success' => false
    //             ], 422);
    //         }

    //         // Assign the role
    //         $notificationTemplate->assignables()->create([
    //             'assignable_type' => Role::class,
    //             'assignable_id' => $role->id
    //         ]);

    //         return response()->json([
    //             'success' => 'Role assigned successfully',
    //             'data' => $role
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Error assigning role: ' . $e->getMessage(),
    //             'success' => false
    //         ], 500);
    //     }
    // }

    // /**
    //  * Unassign a role from a notification template.
    //  */
    // public function unassignRole(NotificationTemplate $notificationTemplate, Role $role): JsonResponse
    // {
    //     try {
    //         $assignment = $notificationTemplate->assignables()
    //             ->where('assignable_type', Role::class)
    //             ->where('assignable_id', $role->id)
    //             ->first();

    //         if (!$assignment) {
    //             return response()->json([
    //                 'error' => 'Role is not assigned to this template',
    //                 'success' => false
    //             ], 404);
    //         }

    //         $assignment->delete();

    //         return response()->json([
    //             'success' => 'Role unassigned successfully',
    //             'data' => $role
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Error unassigning role: ' . $e->getMessage(),
    //             'success' => false
    //         ], 500);
    //     }
    // }

    // /**
    //  * Assign a user to a notification template.
    //  */
    // public function assignUser(Request $request, NotificationTemplate $notificationTemplate): JsonResponse
    // {
    //     try {
    //         $request->validate([
    //             'user_id' => 'required|exists:users,id'
    //         ]);

    //         $user = User::findOrFail($request->user_id);

    //         // Check if already assigned
    //         $exists = $notificationTemplate->assignables()
    //             ->where('assignable_type', User::class)
    //             ->where('assignable_id', $user->id)
    //             ->exists();

    //         if ($exists) {
    //             return response()->json([
    //                 'error' => 'User is already assigned to this template',
    //                 'success' => false
    //             ], 422);
    //         }

    //         // Assign the user
    //         $notificationTemplate->assignables()->create([
    //             'assignable_type' => User::class,
    //             'assignable_id' => $user->id
    //         ]);

    //         return response()->json([
    //             'success' => 'User assigned successfully',
    //             'data' => $user
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Error assigning user: ' . $e->getMessage(),
    //             'success' => false
    //         ], 500);
    //     }
    // }

    // /**
    //  * Unassign a user from a notification template.
    //  */
    // public function unassignUser(NotificationTemplate $notificationTemplate, User $user): JsonResponse
    // {
    //     try {
    //         $assignment = $notificationTemplate->assignables()
    //             ->where('assignable_type', User::class)
    //             ->where('assignable_id', $user->id)
    //             ->first();

    //         if (!$assignment) {
    //             return response()->json([
    //                 'error' => 'User is not assigned to this template',
    //                 'success' => false
    //             ], 404);
    //         }

    //         $assignment->delete();

    //         return response()->json([
    //             'success' => 'User unassigned successfully',
    //             'data' => $user
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Error unassigning user: ' . $e->getMessage(),
    //             'success' => false
    //         ], 500);
    //     }
    // }
}
