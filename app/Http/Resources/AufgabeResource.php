<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AufgabeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'log' => $this->log,
            'beschreibung' => $this->beschreibung,
            'faelligkeit' => $this->faelligkeit,

            // 'faelligkeit_raw' => $this->faelligkeit,
            'path' => $this->path,
            'sourceable_type' => $this->sourceable_type,
            'sourceable_id' => $this->sourceable_id,
            // 'completed_at' => $this->completed_at?->format('d.m.Y H:i'),
            'completed_at' => $this->completed_at,
            // 'created_at' => $this->created_at->format('d.m.Y H:i'),
            'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at->format('d.m.Y H:i'),
            'updated_at' => $this->updated_at,
            // Status relationship
            'status' => $this->whenLoaded('status', function () {
                return [
                    'id' => $this->status->id,
                    'name' => $this->status->name,
                    'name_kurz' => $this->status->name_kurz,
                ];
            }),

            // Template relationship with Berechtigte
            'template' => $this->whenLoaded('template', function () {
                return [
                    'id' => $this->template->id,
                    'name' => $this->template->name,
                    'thema' => $this->template->thema,
                    'section' => $this->template->section ? [
                        'id' => $this->template->section->id,
                        'name' => $this->template->section->name,
                    ] : null,
                    // Berechtigte Gruppen/Rollen (nicht einzelne User)
                    'berechtigte' => $this->template->relationLoaded('zugeteilte') ?
                        $this->template->zugeteilte->map(function ($zuteilung) {
                            if ($zuteilung->assignable_type === 'App\\Models\\Role') {
                                return [
                                    'type' => 'rolle',
                                    'id' => $zuteilung->assignable->id,
                                    'name' => $zuteilung->assignable->name,
                                ];
                            } elseif ($zuteilung->assignable_type === 'App\\Models\\PersonRole') {
                                return [
                                    'type' => 'person_role',
                                    'id' => $zuteilung->assignable->id,
                                    'name' => $zuteilung->assignable->name,
                                ];
                            }

                            return null;
                        })->filter()->values() : [],
                ];
            }),

            // Completed by relationship
            'completed_by' => $this->whenLoaded('completedBy', function () {
                return $this->completedBy ? [
                    'id' => $this->completedBy->id,
                    'name' => $this->completedBy->name,
                    'email' => $this->completedBy->email,
                ] : null;
            }),

            // Edited by relationship
            'edited_by' => $this->whenLoaded('editedBy', function () {
                return $this->editedBy ? [
                    'id' => $this->editedBy->id,
                    'name' => $this->editedBy->name,
                    'email' => $this->editedBy->email,
                ] : null;
            }),

            // Assigned users - simplified to only users
            'zugeteilte_users' => $this->whenLoaded('zugeteilte', function () {
                return $this->zugeteilte->map(function ($zuteilung) {
                    return [
                        'id' => $zuteilung->user->id,
                        'name' => $zuteilung->user->name,
                        'email' => $zuteilung->user->email,
                    ];
                })->values();
            }),

            // Übernahmeberechtigte groups/roles (for display)
            'uebernahmeberechtigte' => $this->whenLoaded('template', function () {
                return $this->uebernahmeberechtigte;
            }),

            // Übernahmeberechtigte users (for assignment selector)
            'uebernahmeberechtigte_users' => $this->whenLoaded('template', function () {
                return $this->uebernahmeberechtigte_users;
            }),

            // Helper: Can current user take over?
            'can_take_over' => $this->when($request->user(), function () use ($request) {
                return $this->canUserTakeOver($request->user());
            }),
        ];
    }
}
