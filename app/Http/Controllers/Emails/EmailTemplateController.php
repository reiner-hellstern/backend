<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmailTemplateRequest;
use App\Http\Requests\UpdateEmailTemplateRequest;
use App\Models\EmailTemplate;
use App\Models\Person;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the email templates.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = EmailTemplate::with(['section', 'assignables.assignable']);

            if ($request->has('search') && ! empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('thema', 'like', "%{$search}%")
                        ->orWhere('vue_component', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%")
                        ->orWhere('betreff', 'like', "%{$search}%")
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
            $allowedSortFields = ['id', 'thema', 'betreff', 'position', 'vue_component', 'slug', 'aktiv', 'created_at'];
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
                    'betreff' => $template->betreff,
                    'position' => $template->position,
                    'vue_component' => $template->vue_component,
                    'slug' => $template->slug,
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
                'success' => 'Email Templates erfolgreich geladen.',
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
                'error' => 'Fehler beim Laden der Email Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreEmailTemplateRequest $request): JsonResponse
    {
        try {
            $template = EmailTemplate::create($request->validated());
            if ($request->has('assignables')) {
                $this->updateAssignables($template, $request->assignables);
            }
            $template->load(['section', 'assignables']);
            $assignableData = $this->getAssignableData($template);

            return response()->json([
                'success' => 'Email Template erfolgreich erstellt.',
                'data' => [
                    'id' => $template->id,
                    'section' => $template->section ? [
                        'id' => $template->section->id,
                        'name' => $template->section->name,
                        'name_kurz' => $template->section->name_kurz,
                    ] : null,
                    'thema' => $template->thema,
                    'betreff' => $template->betreff,
                    'position' => $template->position,
                    'vue_component' => $template->vue_component,
                    'slug' => $template->slug,
                    'body' => $template->body,
                    'aktiv' => $template->aktiv,
                    'created_at' => $template->created_at,
                    'updated_at' => $template->updated_at,
                    'roles_count' => $assignableData['roles_count'],
                    'persons_count' => $assignableData['persons_count'],
                    'assignables_summary' => $assignableData['summary'],
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Erstellen des Email Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(EmailTemplate $emailTemplate): JsonResponse
    {
        try {
            $emailTemplate->load(['section', 'assignables.assignable']);
            $assignableData = $this->getAssignableData($emailTemplate);
            $detailedAssignables = $this->getDetailedAssignables($emailTemplate);

            return response()->json([
                'success' => 'Email Template erfolgreich geladen.',
                'data' => [
                    'id' => $emailTemplate->id,
                    'section' => $emailTemplate->section ? [
                        'id' => $emailTemplate->section->id,
                        'name' => $emailTemplate->section->name,
                        'name_kurz' => $emailTemplate->section->name_kurz,
                    ] : null,
                    'thema' => $emailTemplate->thema,
                    'betreff' => $emailTemplate->betreff,
                    'position' => $emailTemplate->position,
                    'vue_component' => $emailTemplate->vue_component,
                    'slug' => $emailTemplate->slug,
                    'body' => $emailTemplate->body,
                    'data' => $emailTemplate->data,
                    'aktiv' => $emailTemplate->aktiv,
                    'created_at' => $emailTemplate->created_at,
                    'updated_at' => $emailTemplate->updated_at,
                    'roles_count' => $assignableData['roles_count'],
                    'persons_count' => $assignableData['persons_count'],
                    'assignables_summary' => $assignableData['summary'],
                    'assignables_detailed' => $detailedAssignables,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Laden des Email Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateEmailTemplateRequest $request, EmailTemplate $emailTemplate): JsonResponse
    {
        try {
            $emailTemplate->update($request->validated());
            if ($request->has('assignables')) {
                $this->updateAssignables($emailTemplate, $request->assignables);
            }
            $emailTemplate->load(['section', 'assignables']);
            $assignableData = $this->getAssignableData($emailTemplate);

            return response()->json([
                'success' => 'Email Template erfolgreich aktualisiert.',
                'data' => [
                    'id' => $emailTemplate->id,
                    'section' => $emailTemplate->section ? [
                        'id' => $emailTemplate->section->id,
                        'name' => $emailTemplate->section->name,
                        'name_kurz' => $emailTemplate->section->name_kurz,
                    ] : null,
                    'thema' => $emailTemplate->thema,
                    'betreff' => $emailTemplate->betreff,
                    'position' => $emailTemplate->position,
                    'vue_component' => $emailTemplate->vue_component,
                    'slug' => $emailTemplate->slug,
                    'body' => $emailTemplate->body,
                    'aktiv' => $emailTemplate->aktiv,
                    'created_at' => $emailTemplate->created_at,
                    'updated_at' => $emailTemplate->updated_at,
                    'roles_count' => $assignableData['roles_count'],
                    'persons_count' => $assignableData['persons_count'],
                    'assignables_summary' => $assignableData['summary'],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Aktualisieren des Email Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(EmailTemplate $emailTemplate): JsonResponse
    {
        try {
            $emailTemplate->delete();

            return response()->json([
                'success' => 'Email Template erfolgreich gelöscht.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fehler beim Löschen des Email Templates: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ... Methoden für Rollen-/Personen-Zuweisung und Test analog Notification ...

    /**
     * Assign a role to an email template.
     */
    public function assignRole(Request $request, EmailTemplate $emailTemplate): JsonResponse
    {
        // ...analog Notification, aber für EmailTemplate...
        return response()->json([
            'success' => 'Rolle zugewiesen (Demo)',
        ]);
    }

    /**
     * Assign person(s) to an email template.
     */
    public function assignPerson(Request $request, EmailTemplate $emailTemplate): JsonResponse
    {
        // ...analog Notification, aber für Personen...
        return response()->json([
            'success' => 'Person(en) zugewiesen (Demo)',
        ]);
    }

    /**
     * Remove a person from an email template.
     */
    public function unassignPerson(EmailTemplate $emailTemplate, Person $person): JsonResponse
    {
        // ...analog Notification, aber für Personen...
        return response()->json([
            'success' => 'Person entfernt (Demo)',
        ]);
    }

    /**
     * Test email template by sending to specific person(s).
     */
    public function test(Request $request, EmailTemplate $emailTemplate): JsonResponse
    {
        // ...analog Notification, aber für Personen...
        return response()->json([
            'success' => 'Test-E-Mail gesendet (Demo)',
        ]);
    }
}
