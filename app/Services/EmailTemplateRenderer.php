<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\Person;
use Illuminate\Database\Eloquent\Model;

class EmailTemplateRenderer
{
    /**
     * Compile template with flexible model context
     *
     * @param  array  $models  Associative array of models, e.g. ['person' => $person, 'hund' => $hund]
     * @param  array  $additionalContext  Additional variables for template
     * @param  array  $meta  Metadata
     * @return array ['subject' => string, 'body' => string, 'context' => array]
     */
    public function compile(EmailTemplate $template, array $models = [], array $additionalContext = [], array $meta = []): array
    {
        if (! is_array($models)) {
            $models = [];
        }

        if (! is_array($additionalContext)) {
            $additionalContext = [];
        }

        if (! is_array($meta)) {
            $meta = [];
        }

        $baseContext = $this->buildContext($template, $models, $additionalContext, $meta);

        $subjectSource = $template->subject ?: $template->thema ?: '';
        $bodySource = $template->body ?: '';

        return [
            'subject' => $subjectSource !== '' ? trim($this->renderString($subjectSource, $baseContext)) : '',
            'body' => $bodySource !== '' ? $this->renderString($bodySource, $baseContext) : '',
            'context' => $baseContext,
        ];
    }

    /**
     * Legacy method for backward compatibility - wraps compile()
     *
     * @deprecated Use compile() instead
     */
    public function compileForPerson(EmailTemplate $template, Person $person, array $context = [], array $meta = []): array
    {
        return $this->compile($template, ['person' => $person], $context, $meta);
    }

    /**
     * Build complete context for template rendering
     *
     * @param  array  $models  Associative array of models
     * @param  array  $additionalContext  Additional variables
     * @param  array  $meta  Metadata
     * @return array Complete context for Blade rendering
     */
    public function buildContext(EmailTemplate $template, array $models = [], array $additionalContext = [], array $meta = []): array
    {
        if (! is_array($models)) {
            $models = [];
        }

        if (! is_array($additionalContext)) {
            $additionalContext = [];
        }

        if (! is_array($meta)) {
            $meta = [];
        }

        // Load common relationships for models
        foreach ($models as $key => $model) {
            if ($model instanceof Model) {
                $this->loadCommonRelations($key, $model);
            }
        }

        // Base context with models directly accessible
        $baseContext = $models;

        // Add convenience aliases for Person model
        if (isset($models['person']) && $models['person'] instanceof Person) {
            $person = $models['person'];
            $baseContext['mitglied'] = $person->mitglied ?? null;
            $baseContext['user'] = $person->user ?? null;
            $baseContext['anrede'] = $person->anrede ?? null;
        }

        // Add metadata
        $baseContext['meta'] = array_merge([
            'template' => [
                'id' => $template->id,
                'slug' => $template->slug,
                'thema' => $template->thema,
            ],
        ], $meta);

        // Merge additional context (can override models)
        if (! empty($additionalContext)) {
            $baseContext = array_replace_recursive($baseContext, $additionalContext);
        }

        return $baseContext;
    }

    /**
     * Load common relationships based on model type
     *
     * @param  string  $key  Model key (person, hund, wurf, etc.)
     */
    protected function loadCommonRelations(string $key, Model $model): void
    {
        $relationshipMap = [
            'person' => ['mitglied', 'anrede', 'user', 'hunde', 'zwinger'],
            'hund' => ['besitzer', 'zuechter', 'rasse', 'geschlecht', 'farbe'],
            'wurf' => ['zuechter', 'mutter', 'vater', 'welpen', 'wurfabnahme'],
            'mitglied' => ['person', 'bezirksgruppe'],
            'zuchtstaette' => ['zwinger', 'zuechter', 'besichtigungen'],
            'zwinger' => ['besitzer', 'rassen', 'zuchtstaette'],
            'wurfplan' => ['ruede', 'huendin', 'zuechter', 'anleger'],
            'zuchtzulassung' => ['hund', 'richter'],
            'veranstaltung' => ['veranstalter', 'bezirksgruppe', 'meldungen'],
            'ahnentafel' => ['hund', 'zuechter', 'besitzer'],
            'zuchtstaettenbesichtigung' => ['zuchtstaette', 'zuchtwart', 'protokoll'],
            'wurfabnahme' => ['wurf', 'zuchtwart', 'protokoll'],
            'leihhund' => ['hund', 'verleiher', 'entleiher'],
        ];

        $relations = $relationshipMap[$key] ?? [];

        if (! empty($relations)) {
            // Only load relations that exist on the model
            $existingRelations = array_filter($relations, function ($relation) use ($model) {
                return method_exists($model, $relation);
            });

            if (! empty($existingRelations)) {
                $model->loadMissing($existingRelations);
            }
        }
    }

    public function renderString(string $content, array $context = []): string
    {
        $trimmed = trim($content);

        if ($trimmed === '') {
            return $content;
        }

        if (! str_contains($content, '@') && ! str_contains($content, '{{') && ! str_contains($content, '<x-')) {
            return $content;
        }

        $tempViewPath = resource_path('views/mail/temp');
        if (! is_dir($tempViewPath)) {
            // Ensures Blade can resolve ad-hoc component templates during rendering.
            mkdir($tempViewPath, 0755, true);
        }

        $hash = md5($content . microtime(true) . random_int(PHP_INT_MIN, PHP_INT_MAX));
        $fileName = "compiled_{$hash}";
        $filePath = "{$tempViewPath}/{$fileName}.blade.php";

        file_put_contents($filePath, $content);

        try {
            return view("mail.temp.{$fileName}", $context)->render();
        } finally {
            @unlink($filePath);
        }
    }
}
