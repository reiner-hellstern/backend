<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AufgabenTemplateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'thema' => $this->thema,
            'beschreibung' => $this->beschreibung,
            'slug' => $this->slug,
            'section_id' => $this->section_id,
            'section' => $this->whenLoaded('section', function () {
                return [
                    'id' => $this->section->id,
                    'name' => $this->section->name,
                ];
            }),
            'zugeteilte_roles' => $this->whenLoaded('zugeteilte', function () {
                return $this->zugeteilte->where('assignable_type', \App\Models\Role::class)->map(function ($item) {
                    return [
                        'id' => $item->assignable_id,
                        'name' => $item->assignable->name ?? '',
                        'title' => $item->assignable->title ?? '',
                    ];
                })->values();
            }),
            'zugeteilte_users' => $this->whenLoaded('zugeteilte', function () {
                return $this->zugeteilte->where('assignable_type', \App\Models\User::class)->map(function ($item) {
                    return [
                        'id' => $item->assignable_id,
                        'name' => $item->assignable->name ?? '',
                        'email' => $item->assignable->email ?? '',
                    ];
                })->values();
            }),
            'zugeteilte_persons' => $this->whenLoaded('zugeteilte', function () {
                return $this->zugeteilte->where('assignable_type', \App\Models\Person::class)->map(function ($item) {
                    return [
                        'id' => $item->assignable_id,
                        'name' => $item->assignable->name ?? '',
                        'vorname' => $item->assignable->vorname ?? '',
                        'full_name' => ($item->assignable->vorname ?? '') . ' ' . ($item->assignable->name ?? ''),
                    ];
                })->values();
            }),
            'uebernahmeberechtigte_roles' => $this->whenLoaded('uebernahmeberechtigte', function () {
                return $this->uebernahmeberechtigte->where('assignable_type', \App\Models\Role::class)->map(function ($item) {
                    return [
                        'id' => $item->assignable_id,
                        'name' => $item->assignable->name ?? '',
                        'title' => $item->assignable->title ?? '',
                    ];
                })->values();
            }),
            'uebernahmeberechtigte_users' => $this->whenLoaded('uebernahmeberechtigte', function () {
                // Nur explizit zugewiesene User für das UI
                return $this->uebernahmeberechtigte->where('assignable_type', \App\Models\User::class)->map(function ($item) {
                    return [
                        'id' => $item->assignable_id,
                        'name' => $item->assignable->name ?? '',
                        'email' => $item->assignable->email ?? '',
                    ];
                })->values();
            }),
            'all_authorized_users' => $this->whenLoaded('uebernahmeberechtigte', function () {
                // Alle verfügbaren User (direkt + aus Rollen) für Create Modal
                $directUsers = $this->uebernahmeberechtigte->where('assignable_type', \App\Models\User::class)->map(function ($item) {
                    return [
                        'id' => $item->assignable_id,
                        'name' => $item->assignable->name ?? '',
                        'email' => $item->assignable->email ?? '',
                    ];
                });

                // Get users from authorized roles using Bouncer
                $roleUserIds = collect();
                $authorizedRoles = $this->uebernahmeberechtigte->where('assignable_type', \App\Models\Role::class);

                foreach ($authorizedRoles as $roleAuth) {
                    if ($roleAuth->assignable) {
                        // Use Bouncer to get users assigned to this role
                        $roleUsers = \App\Models\User::whereIs($roleAuth->assignable->name)->get(['id', 'name', 'email']);
                        foreach ($roleUsers as $user) {
                            $roleUserIds->push([
                                'id' => $user->id,
                                'name' => $user->name,
                                'email' => $user->email,
                            ]);
                        }
                    }
                }

                // Merge and remove duplicates
                $allUsers = $directUsers->concat($roleUserIds)->unique('id');

                return $allUsers->values();
            }),
            'uebernahmeberechtigte_persons' => $this->whenLoaded('uebernahmeberechtigte', function () {
                return $this->uebernahmeberechtigte->where('assignable_type', \App\Models\Person::class)->map(function ($item) {
                    return [
                        'id' => $item->assignable_id,
                        'name' => $item->assignable->name ?? '',
                        'vorname' => $item->assignable->vorname ?? '',
                        'full_name' => ($item->assignable->vorname ?? '') . ' ' . ($item->assignable->name ?? ''),
                    ];
                })->values();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
