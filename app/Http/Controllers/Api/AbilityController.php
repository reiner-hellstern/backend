<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
                'user' => null,
                'debug' => 'No user found',
            ]);
        }

        try {
            // Debug-Info sammeln
            $debug = [
                'user_id' => $user->id,
                'user_class' => get_class($user),
                'bouncer_methods' => [
                    'getAbilities' => method_exists($user, 'getAbilities'),
                    'getRoles' => method_exists($user, 'getRoles'),
                ],
                'roles' => [],
                'direct_abilities' => [],
                'role_abilities' => [],
            ];

            // Hole alle direkten Abilities des Benutzers von Bouncer
            $abilities = collect();

            if (method_exists($user, 'getAbilities')) {
                $userAbilities = $user->getAbilities();
                $debug['direct_abilities'] = $userAbilities->toArray();

                $userAbilitiesFormatted = $userAbilities->map(function ($ability) {
                    return [
                        'action' => $ability->name,
                        'subject' => $ability->entity_type ?? 'all',
                        'conditions' => $this->getConditionsForAbility($ability),
                    ];
                });
                $abilities = $abilities->merge($userAbilitiesFormatted);
            }

            // Hole Rollen-basierte Abilities
            // Verwende $user->roles für echte Role-Objekte, nicht getRoles() für String-Namen
            if ($user->roles && $user->roles->count() > 0) {
                $debug['roles'] = $user->roles->pluck('name')->toArray();

                foreach ($user->roles as $role) {
                    if (method_exists($role, 'getAbilities')) {
                        $roleAbilities = $role->getAbilities();
                        $debug['role_abilities'][] = [
                            'role' => $role->name,
                            'abilities' => $roleAbilities->toArray(),
                        ];

                        $rolePerms = $roleAbilities->map(function ($ability) use ($user) {
                            return [
                                'action' => $ability->name,
                                'subject' => $ability->entity_type ?? 'all',
                                'conditions' => $this->getConditionsForAbility($ability, $user),
                            ];
                        });
                        $abilities = $abilities->merge($rolePerms);
                    }
                }
            }

            // Fallback: Basis-Permissions wenn Bouncer nicht verfügbar
            if ($abilities->isEmpty()) {
                $abilities = collect([
                    ['action' => 'view', 'subject' => 'Dashboard', 'conditions' => []],
                    ['action' => 'view', 'subject' => 'Person', 'conditions' => []],
                ]);
                $debug['fallback_used'] = true;
            }

        } catch (\Exception $e) {
            // Fallback bei Bouncer-Fehlern
            $debug['error'] = $e->getMessage();
            $abilities = collect([
                ['action' => 'view', 'subject' => 'Dashboard', 'conditions' => []],
                ['action' => 'view', 'subject' => 'Person', 'conditions' => []],
            ]);
        }

        // Kombiniere und dedupliziere Abilities
        $allAbilities = $abilities->unique()->values();

        return response()->json([
            'abilities' => $allAbilities,
            'user' => [
                'id' => $user->id,
                'roles' => method_exists($user, 'getRoles') ? $user->getRoles()->pluck('name') : [],
            ],
            'debug' => $debug,
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
