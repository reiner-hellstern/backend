<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailTemplateRequest;
use App\Http\Requests\StoreEmailTemplateRequest;
use App\Http\Requests\UpdateEmailTemplateRequest;
use App\Mail\TemplateEmail;
use App\Models\EmailTemplate;
use App\Models\Person;
use App\Models\Section;
use App\Services\EmailTemplateRenderer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Silber\Bouncer\Database\Role;

class EmailTemplateController extends Controller
{
    public function __construct(private EmailTemplateRenderer $emailTemplateRenderer) {}

    /**
     * Display a listing of email templates.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = EmailTemplate::with(['section', 'assignables.assignable']);

            // Filter by search term
            if ($request->has('search') && ! empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('thema', 'like', "%{$search}%")
                        ->orWhere('vue_component', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%")
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
            if ($request->has('aktiv') && $request->aktiv !== '') {
                $query->where('aktiv', (bool) $request->aktiv);
            }

            // Sorting
            $sortField = $request->get('sort_field', 'id');
            $sortDirection = $request->get('sort_direction', 'asc');

            $allowedSortFields = ['id', 'thema', 'position', 'vue_component', 'slug', 'aktiv', 'created_at'];
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
                    'vue_component' => $template->vue_component,
                    'file' => $template->file,
                    'slug' => $template->slug,
                    'subject' => $template->subject,
                    'body' => $template->body,
                    'aktiv' => $template->aktiv,
                    'created_at' => $template->created_at,
                    'updated_at' => $template->updated_at,
                    'roles_count' => $assignableData['roles_count'],
                    'persons_count' => $assignableData['persons_count'],
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
                'success' => 'E-Mail Templates erfolgreich geladen.',
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
                'error' => 'Fehler beim Laden der E-Mail Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created email template.
     */
    public function store(StoreEmailTemplateRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // Load section to generate slug
            $section = Section::findOrFail($data['section_id']);
            $data['section'] = $section; // Temporarily add for slug generation

            $template = EmailTemplate::create($data);
            $template->load(['section', 'assignables.assignable']);

            return response()->json([
                'success' => 'E-Mail Template wurde erfolgreich erstellt.',
                'data' => $template,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Erstellen des E-Mail Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified email template.
     */
    public function show(EmailTemplate $emailTemplate): JsonResponse
    {
        try {
            $emailTemplate->load(['section', 'assignables.assignable']);

            $assignableData = $this->getAssignableData($emailTemplate);

            $data = [
                'id' => $emailTemplate->id,
                'section' => $emailTemplate->section ? [
                    'id' => $emailTemplate->section->id,
                    'name' => $emailTemplate->section->name,
                    'name_kurz' => $emailTemplate->section->name_kurz,
                ] : null,
                'thema' => $emailTemplate->thema,
                'position' => $emailTemplate->position,
                'vue_component' => $emailTemplate->vue_component,
                'file' => $emailTemplate->file,
                'slug' => $emailTemplate->slug,
                'subject' => $emailTemplate->subject,
                'body' => $emailTemplate->body,
                'aktiv' => $emailTemplate->aktiv,
                'created_at' => $emailTemplate->created_at,
                'updated_at' => $emailTemplate->updated_at,
                'assignables_detailed' => [
                    'roles' => $assignableData['roles'],
                    'persons' => $assignableData['persons'],
                ],
            ];

            return response()->json([
                'success' => 'E-Mail Template erfolgreich geladen.',
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden des E-Mail Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified email template.
     */
    public function update(UpdateEmailTemplateRequest $request, EmailTemplate $emailTemplate): JsonResponse
    {
        try {
            $data = $request->validated();

            if (isset($data['section_id'])) {
                $section = Section::findOrFail($data['section_id']);
                $data['section'] = $section; // For slug regeneration
            }

            $emailTemplate->update($data);
            $emailTemplate->load(['section', 'assignables.assignable']);

            return response()->json([
                'success' => 'E-Mail Template wurde erfolgreich aktualisiert.',
                'data' => $emailTemplate,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Aktualisieren des E-Mail Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified email template.
     */
    public function destroy(EmailTemplate $emailTemplate): JsonResponse
    {
        try {
            $emailTemplate->assignables()->delete();
            $emailTemplate->delete();

            return response()->json([
                'success' => 'E-Mail Template wurde erfolgreich gelöscht.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Löschen des E-Mail Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get assignable data for a template.
     */
    private function getAssignableData($template): array
    {
        $roles = [];
        $persons = [];
        $rolesCount = 0;
        $personsCount = 0;

        foreach ($template->assignables as $assignable) {
            if ($assignable->assignable_type === 'Silber\\Bouncer\\Database\\Role') {
                $roles[] = [
                    'id' => $assignable->assignable->id,
                    'name' => $assignable->assignable->name,
                    'title' => $assignable->assignable->title ?? $assignable->assignable->name,
                ];
                $rolesCount++;
            } elseif ($assignable->assignable_type === 'App\\Models\\Person') {
                $persons[] = [
                    'id' => $assignable->assignable->id,
                    'name' => $assignable->assignable->vorname . ' ' . $assignable->assignable->nachname,
                    'email' => $assignable->assignable->email,
                ];
                $personsCount++;
            }
        }

        $summary = [];
        if ($rolesCount > 0) {
            $summary[] = "$rolesCount Rolle(n)";
        }
        if ($personsCount > 0) {
            $summary[] = "$personsCount Person(en)";
        }

        return [
            'roles' => $roles,
            'persons' => $persons,
            'roles_count' => $rolesCount,
            'persons_count' => $personsCount,
            'summary' => implode(', ', $summary),
        ];
    }

    /**
     * Get display name for assignable.
     */
    private function getDisplayName($assignable): string
    {
        if ($assignable instanceof Role) {
            return $assignable->title ?? $assignable->name;
        } elseif ($assignable instanceof Person) {
            return $assignable->vorname . ' ' . $assignable->nachname;
        }

        return 'Unknown';
    }

    /**
     * Assign a role to an email template.
     */
    public function assignRole(Request $request, EmailTemplate $emailTemplate): JsonResponse
    {
        try {
            $request->validate([
                'role_ids' => 'required|array',
                'role_ids.*' => 'exists:roles,id',
            ]);

            $addedCount = 0;

            foreach ($request->role_ids as $roleId) {
                $role = Role::findOrFail($roleId);

                // Check if already assigned
                $exists = $emailTemplate->assignables()
                    ->where('assignable_type', get_class($role))
                    ->where('assignable_id', $role->id)
                    ->exists();

                if (! $exists) {
                    $emailTemplate->assignables()->create([
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

    /**
     * Remove a role from an email template.
     */
    public function unassignRole(EmailTemplate $emailTemplate, Role $role): JsonResponse
    {
        try {
            $emailTemplate->assignables()
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

    /**
     * Assign persons to an email template.
     */
    public function assignPerson(Request $request, EmailTemplate $emailTemplate): JsonResponse
    {
        try {
            $request->validate([
                'person_ids' => 'required|array',
                'person_ids.*' => 'exists:personen,id',
            ]);

            $addedCount = 0;

            foreach ($request->person_ids as $personId) {
                $person = Person::findOrFail($personId);

                // Check if already assigned
                $exists = $emailTemplate->assignables()
                    ->where('assignable_type', get_class($person))
                    ->where('assignable_id', $person->id)
                    ->exists();

                if (! $exists) {
                    $emailTemplate->assignables()->create([
                        'assignable_type' => get_class($person),
                        'assignable_id' => $person->id,
                    ]);
                    $addedCount++;
                }
            }

            return response()->json([
                'success' => $addedCount > 0 ? "$addedCount Person(en) wurden hinzugefügt" : 'Alle Personen sind bereits zugeordnet',
                'data' => ['added_count' => $addedCount],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Zuordnen der Person(en): ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove a person from an email template.
     */
    public function unassignPerson(EmailTemplate $emailTemplate, Person $person): JsonResponse
    {
        try {
            $emailTemplate->assignables()
                ->where('assignable_type', get_class($person))
                ->where('assignable_id', $person->id)
                ->delete();

            return response()->json([
                'success' => 'Person wurde erfolgreich entfernt',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Entfernen der Person: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Search for persons to assign to email template.
     */
    public function personsSearch(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'q' => 'required|string|min:4',
                'limit' => 'integer|max:100',
            ]);

            $query = trim($request->get('q'));
            $limit = $request->get('limit', 50);

            $persons = Person::where(function ($q) use ($query) {
                $q->where('vorname', 'like', "%{$query}%")
                    ->orWhere('nachname', 'like', "%{$query}%")
                    ->orWhere('email_1', 'like', "%{$query}%")
                    ->orWhereRaw("CONCAT(vorname, ' ', nachname) LIKE ?", ["%{$query}%"]);
            })
                ->select('id', 'vorname', 'nachname', 'email_1')
                ->limit($limit)
                ->get()
                ->map(function ($person) {
                    return [
                        'id' => $person->id,
                        'name' => $person->vorname . ' ' . $person->nachname,
                        'email' => $person->email_1,
                    ];
                });

            return response()->json([
                'success' => 'Personen erfolgreich gefunden.',
                'data' => $persons,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Suchen der Personen: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send test email.
     */
    public function test(SendEmailTemplateRequest $request, EmailTemplate $emailTemplate): JsonResponse
    {
        $validated = $request->validated();

        try {
            $persons = Person::whereIn('id', $validated['person_ids'])
                ->with(['mitglied', 'anrede', 'user'])
                ->get();

            if ($persons->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Keine gültigen Empfänger gefunden',
                ], 404);
            }

            $overrideConfig = $this->buildRecipientOverrideConfig($validated);
            $metaPayload = $validated['meta'] ?? [];

            $deliveries = [];
            $errors = [];
            $successfulPersons = [];

            foreach ($persons as $person) {
                $recipientName = $this->formatPersonName($person);
                $contextForPerson = $this->resolveContextForPerson($validated['context'] ?? [], $person->id);

                // Build models array for flexible template rendering
                $models = ['person' => $person];

                // Add additional models from context if provided
                if (isset($contextForPerson['models']) && is_array($contextForPerson['models'])) {
                    $models = array_merge($models, $contextForPerson['models']);
                    unset($contextForPerson['models']); // Remove from context to avoid duplication
                }

                $compiled = $this->emailTemplateRenderer->compile(
                    $emailTemplate,
                    $models,
                    $contextForPerson,
                    array_merge($metaPayload, [
                        'is_test' => true,
                        'recipient' => [
                            'person_id' => $person->id,
                            'name' => $recipientName,
                        ],
                    ])
                );

                $subjectLine = $compiled['subject'] ?: ($emailTemplate->subject ?: $emailTemplate->thema ?: 'E-Mail');
                $recipients = $this->resolveRecipientsForPerson($person, $overrideConfig);

                if (empty($recipients)) {
                    $errors[] = "Keine gültige E-Mail-Adresse für {$recipientName} gefunden";
                    Log::warning('Test email skipped due to missing recipient', [
                        'template_id' => $emailTemplate->id,
                        'template_slug' => $emailTemplate->slug,
                        'person_id' => $person->id,
                    ]);
                    continue;
                }

                foreach ($recipients as $recipient) {
                    try {
                        $metadata = array_merge(
                            $compiled['context']['meta'] ?? [],
                            [
                                'person_id' => $person->id,
                                'template_id' => $emailTemplate->id,
                                'template_slug' => $emailTemplate->slug,
                                'recipient_email' => $recipient['email'],
                                'recipient_name' => $recipientName,
                                'override' => $recipient['override'],
                            ]
                        );

                        Mail::to($recipient['email'])->send(new TemplateEmail(
                            subjectLine: $subjectLine,
                            htmlBody: $compiled['body'],
                            isTest: true,
                            metaPayload: $metadata
                        ));

                        $deliveries[] = [
                            'person_id' => $person->id,
                            'recipient_email' => $recipient['email'],
                            'recipient_name' => $recipientName,
                            'override' => $recipient['override'],
                        ];

                        $successfulPersons[$person->id] = true;

                        Log::info('Test email sent', [
                            'template_id' => $emailTemplate->id,
                            'template_slug' => $emailTemplate->slug,
                            'person_id' => $person->id,
                            'recipient_email' => $recipient['email'],
                            'override' => $recipient['override'],
                        ]);
                    } catch (\Throwable $exception) {
                        $errors[] = "Fehler beim Senden an {$recipient['email']}: " . $exception->getMessage();

                        Log::error('Test email failed', [
                            'template_id' => $emailTemplate->id,
                            'template_slug' => $emailTemplate->slug,
                            'person_id' => $person->id,
                            'recipient_email' => $recipient['email'],
                            'override' => $recipient['override'],
                            'exception' => $exception->getMessage(),
                        ]);
                    }
                }
            }

            $personCount = count($successfulPersons);

            if ($personCount > 0) {
                $message = "Test-E-Mail erfolgreich an {$personCount} " . ($personCount === 1 ? 'Person' : 'Personen') . ' gesendet';
                if (! empty($errors)) {
                    $message .= '. ' . count($errors) . ' Fehler aufgetreten.';
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'sent_count' => $personCount,
                    'errors' => $errors,
                    'data' => [
                        'deliveries' => $deliveries,
                        'override' => $overrideConfig,
                    ],
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Keine E-Mails konnten gesendet werden',
                'errors' => $errors,
            ], 400);
        } catch (\Throwable $exception) {
            Log::error('Fehler beim Senden der Test-E-Mail', [
                'template_id' => $emailTemplate->id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Senden der Test-E-Mail: ' . $exception->getMessage(),
            ], 500);
        }
    }

    private function buildRecipientOverrideConfig(array $validated): array
    {
        $override = $validated['recipient_override'] ?? [];
        $override['mode'] = $override['mode'] ?? 'include';
        $override['emails'] = $override['emails'] ?? [];

        if ($this->shouldForceTestOverride()) {
            $testAddress = trim((string) config('mail.test_email_address'));
            if ($testAddress !== '') {
                $override['emails'][] = $testAddress;
                $override['mode'] = $override['mode'] ?? 'replace';
                $override['forced'] = true;
            }
        }

        $override['emails'] = array_values(array_unique(array_filter(
            array_map(fn ($email) => trim((string) $email), $override['emails']),
            fn ($email) => $email !== ''
        )));

        return $override;
    }

    private function shouldForceTestOverride(): bool
    {
        return app()->environment(['local', 'development']) && (bool) config('mail.test_override', false);
    }

    private function resolveRecipientsForPerson(Person $person, array $overrideConfig): array
    {
        $recipients = [];

        if (($overrideConfig['mode'] ?? 'include') !== 'replace') {
            foreach ($this->gatherPersonEmails($person) as $email) {
                $recipients[] = [
                    'email' => $email,
                    'override' => false,
                ];
            }
        }

        foreach ($overrideConfig['emails'] ?? [] as $email) {
            $recipients[] = [
                'email' => $email,
                'override' => true,
            ];
        }

        return collect($recipients)
            ->filter(fn ($recipient) => ! empty($recipient['email']))
            ->unique('email')
            ->values()
            ->all();
    }

    private function gatherPersonEmails(Person $person): array
    {
        $raw = [
            $person->email_1 ?? null,
            $person->email_2 ?? null,
            optional($person->user)->email,
        ];

        return array_values(array_unique(array_filter(
            array_map(fn ($email) => $email !== null ? trim((string) $email) : null, $raw),
            fn ($email) => $email !== null && $email !== ''
        )));
    }

    private function formatPersonName(Person $person): string
    {
        $name = trim(($person->vorname ?? '') . ' ' . ($person->nachname ?? ''));

        if ($name !== '') {
            return $name;
        }

        $fallbacks = [
            $person->post_name ?? null,
            $person->post_anrede ?? null,
        ];

        foreach ($fallbacks as $fallback) {
            $trimmed = $fallback !== null ? trim((string) $fallback) : '';
            if ($trimmed !== '') {
                return $trimmed;
            }
        }

        return 'Empfänger';
    }

    private function resolveContextForPerson($contextPayload, int $personId): array
    {
        if (! is_array($contextPayload)) {
            return [];
        }

        if (array_key_exists($personId, $contextPayload) && is_array($contextPayload[$personId])) {
            return array_replace_recursive(
                $this->extractGlobalContext($contextPayload),
                $contextPayload[$personId]
            );
        }

        if (array_key_exists('*', $contextPayload) && is_array($contextPayload['*'])) {
            return $contextPayload['*'];
        }

        return $contextPayload;
    }

    private function extractGlobalContext(array $contextPayload): array
    {
        return array_key_exists('*', $contextPayload) && is_array($contextPayload['*'])
            ? $contextPayload['*']
            : [];
    }

    /**
     * Get roles list for assignments (consistent naming with other templates).
     */
    public function rolesList(): JsonResponse
    {
        try {
            $roles = Role::orderBy('name')->get(['id', 'name', 'title']);

            return response()->json([
                'success' => true,
                'data' => $roles->map(function ($role) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name,
                        'title' => $role->title ?? $role->name, // Frontend erwartet 'title'
                    ];
                }),
                'message' => 'Verfügbare Rollen erfolgreich geladen.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der verfügbaren Rollen.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }
}
