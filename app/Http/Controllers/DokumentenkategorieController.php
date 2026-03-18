<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDokumentenkategorieRequest;
use App\Http\Requests\UpdateDokumentenkategorienOrderRequest;
use App\Http\Requests\UpdateDokumentenkategorieRequest;
use App\Http\Resources\DokumentenkategorieResource;
use App\Models\Dokumentenkategorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Silber\Bouncer\Database\Role;

class DokumentenkategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Dokumentenkategorie::with(['assignedRoles', 'dokumente']);

            // Filter by active status if requested
            if ($request->has('aktiv')) {
                $query->where('aktiv', $request->boolean('aktiv'));
            }

            // Order by reihenfolge
            $query->ordered();

            $dokumentenkategorien = $query->get();

            return response()->json([
                'success' => true,
                'data' => DokumentenkategorieResource::collection($dokumentenkategorien),
                'message' => 'Dokumentenkategorien erfolgreich geladen.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Dokumentenkategorien.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDokumentenkategorieRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Determine next reihenfolge if not provided
            $reihenfolge = $request->get('reihenfolge', Dokumentenkategorie::max('reihenfolge') + 1);

            $dokumentenkategorie = Dokumentenkategorie::create([
                'name' => $request->name,
                'beschreibung' => $request->beschreibung,
                'reihenfolge' => $reihenfolge,
                'aktiv' => $request->get('aktiv', true),
            ]);

            // Assign roles if provided
            if ($request->has('assigned_roles')) {
                $dokumentenkategorie->assignedRoles()->attach($request->assigned_roles);
            }

            // Load relationships for response
            $dokumentenkategorie->load(['assignedRoles', 'dokumente']);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => new DokumentenkategorieResource($dokumentenkategorie),
                'message' => 'Dokumentenkategorie erfolgreich erstellt.',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Erstellen der Dokumentenkategorie.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokumentenkategorie $dokumentenkategorie): JsonResponse
    {
        try {
            $dokumentenkategorie->load(['assignedRoles', 'dokumente']);

            return response()->json([
                'success' => true,
                'data' => new DokumentenkategorieResource($dokumentenkategorie),
                'message' => 'Dokumentenkategorie erfolgreich geladen.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Laden der Dokumentenkategorie.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDokumentenkategorieRequest $request, Dokumentenkategorie $dokumentenkategorie): JsonResponse
    {
        try {
            DB::beginTransaction();

            $dokumentenkategorie->update($request->only([
                'name',
                'beschreibung',
                'reihenfolge',
                'aktiv',
            ]));

            // Update role assignments if provided
            if ($request->has('assigned_roles')) {
                $dokumentenkategorie->assignedRoles()->sync($request->assigned_roles);
            }

            // Load relationships for response
            $dokumentenkategorie->load(['assignedRoles', 'dokumente']);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => new DokumentenkategorieResource($dokumentenkategorie),
                'message' => 'Dokumentenkategorie erfolgreich aktualisiert.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Aktualisieren der Dokumentenkategorie.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumentenkategorie $dokumentenkategorie): JsonResponse
    {
        try {
            // Check if there are documents in this group
            if ($dokumentenkategorie->dokumente()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'error' => 'Diese Dokumentenkategorie kann nicht gelöscht werden, da sie noch Dokumente enthält.',
                    'message' => 'Bitte verschieben oder löschen Sie zuerst alle Dokumente aus dieser Gruppe.',
                ], 422);
            }

            $name = $dokumentenkategorie->name;
            $dokumentenkategorie->delete();

            return response()->json([
                'success' => true,
                'message' => "Dokumentenkategorie \"{$name}\" wurde erfolgreich gelöscht.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Löschen der Dokumentenkategorie.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Update the order of document groups (drag & drop functionality).
     */
    public function updateOrder(UpdateDokumentenkategorienOrderRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            foreach ($request->order as $orderData) {
                Dokumentenkategorie::where('id', $orderData['id'])
                    ->update(['reihenfolge' => $orderData['reihenfolge']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reihenfolge der Dokumentenkategorien erfolgreich aktualisiert.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Aktualisieren der Reihenfolge.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
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
                        'title' => $role->title, // Frontend erwartet 'title'
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

    /**
     * Assign roles to a dokumentenkategorie.
     */
    public function assignRole(Request $request, Dokumentenkategorie $dokumentenkategorie): JsonResponse
    {
        try {
            $roleIds = $request->input('role_ids', []);

            if (empty($roleIds)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Keine Rollen angegeben.',
                ], 400);
            }

            // Attach roles to dokumentenkategorie via pivot table
            foreach ($roleIds as $roleId) {
                \DB::table('dokumentenkategorie_roles')->updateOrInsert([
                    'dokumentenkategorie_id' => $dokumentenkategorie->id,
                    'role_id' => $roleId,
                ], [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return response()->json([
                'success' => 'Rollen erfolgreich zugeordnet.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Zuordnen der Rollen.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }

    /**
     * Remove a role from a dokumentenkategorie.
     */
    public function unassignRole(Dokumentenkategorie $dokumentenkategorie, Role $role): JsonResponse
    {
        try {
            // Remove role from dokumentenkategorie via pivot table
            \DB::table('dokumentenkategorie_roles')
                ->where('dokumentenkategorie_id', $dokumentenkategorie->id)
                ->where('role_id', $role->id)
                ->delete();

            return response()->json([
                'success' => 'Rolle erfolgreich entfernt.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Entfernen der Rolle.',
                'message' => config('app.debug') ? $e->getMessage() : 'Ein unerwarteter Fehler ist aufgetreten.',
            ], 500);
        }
    }
}
