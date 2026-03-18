<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbilityController extends Controller
{
    /**
     * Get current user's abilities for CASL frontend
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'abilities' => [],
            ]);
        }

        // Hole alle Abilities des Benutzers von Bouncer
        $abilities = $user->getAbilities()->map(function ($ability) {
            return [
                'action' => $ability->name,
                'subject' => $ability->entity_type ?? 'all',
                'conditions' => $this->getConditionsForAbility($ability),
            ];
        });

        // Hole Rollen-basierte Abilities
        $roleAbilities = collect();

        // Debug: Was ist $user->roles?
        \Log::info('Debug: user->roles type', [
            'type' => gettype($user->roles),
            'class' => is_object($user->roles) ? get_class($user->roles) : 'not object',
            'count' => method_exists($user->roles, 'count') ? $user->roles->count() : 'no count method',
        ]);

        // Verwende $user->roles für Role-Objekte, nicht getRoles() für String-Namen
        foreach ($user->roles as $index => $role) {
            \Log::info('Debug: role item', [
                'index' => $index,
                'type' => gettype($role),
                'class' => is_object($role) ? get_class($role) : 'not object',
                'value' => is_string($role) ? $role : 'object',
            ]);

            if (is_object($role) && method_exists($role, 'getAbilities')) {
                $rolePerms = $role->getAbilities()->map(function ($ability) use ($user) {
                    return [
                        'action' => $ability->name,
                        'subject' => $ability->entity_type ?? 'all',
                        'conditions' => $this->getConditionsForAbility($ability, $user),
                    ];
                });
                $roleAbilities = $roleAbilities->merge($rolePerms);
            } else {
                \Log::warning('Role is not an object or does not have getAbilities method', [
                    'role' => $role,
                ]);
            }
        }

        // Kombiniere direkte und Rollen-Abilities
        $allAbilities = $abilities->merge($roleAbilities)->unique()->values();

        // Debug-Informationen
        $debug = [
            'user_id' => $user->id,
            'role_names' => $user->getRoles(), // String-Namen
            'role_objects_count' => $user->roles->count(), // Objekt-Anzahl
            'direct_abilities_count' => $abilities->count(),
            'role_abilities_count' => $roleAbilities->count(),
            'total_abilities_count' => $allAbilities->count(),
            'direct_abilities' => $abilities->pluck('action'),
            'role_abilities' => $roleAbilities->pluck('action'),
        ];

        return response()->json([
            'abilities' => $allAbilities,
            'debug' => $debug,
            'user' => [
                'id' => $user->id,
                'roles' => $user->getRoles(),
            ],
        ]);
    }

    /**
     * Get conditions for an ability based on user context
     */
    private function getConditionsForAbility($ability, $user = null): array
    {
        $conditions = [];

        // Beispiel-Bedingungen basierend auf Ability-Namen
        switch ($ability->name) {
            case 'edit':
            case 'delete':
                // Nur eigene Entities bearbeiten/löschen
                if ($ability->entity_type === 'App\\Models\\Person' && $user) {
                    $conditions['created_by'] = $user->id;
                }
                break;

            case 'view-sensitive':
                // Nur für bestimmte Rollen
                if ($user && ! $user->isAn('admin', 'zuchtwart')) {
                    $conditions = ['forbidden' => true];
                }
                break;
        }

        return $conditions;
    }

    /**
     * Refresh abilities after role/permission changes
     */
    public function refresh(Request $request): JsonResponse
    {
        return $this->index($request);
    }
}
