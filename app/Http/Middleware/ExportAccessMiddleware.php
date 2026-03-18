<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ExportAccessMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. User muss eingeloggt sein
        if (! Auth::check()) {
            Log::warning('Unauthenticated export access attempt', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->url(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Authentifizierung erforderlich',
            ], 401);
        }

        $user = Auth::user();

        // 2. User muss Export-Berechtigung haben
        if (! $user->can('rechnungen.export')) {
            Log::warning('Unauthorized export access attempt', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'ip' => $request->ip(),
                'url' => $request->url(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Keine Berechtigung für Export-Funktionen',
            ], 403);
        }

        // 3. Rate Limiting für Downloads (max 10 Downloads pro Minute)
        $key = 'export_downloads_' . $user->id;
        $downloads = cache()->get($key, 0);

        if ($downloads >= 10) {
            Log::warning('Export download rate limit exceeded', [
                'user_id' => $user->id,
                'downloads_attempted' => $downloads,
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Zu viele Download-Versuche. Bitte warten Sie eine Minute.',
            ], 429);
        }

        // Download-Counter erhöhen
        cache()->put($key, $downloads + 1, 60); // 60 Sekunden

        // 4. Verdächtige Aktivitäten überwachen
        $this->monitorSuspiciousActivity($request, $user);

        return $next($request);
    }

    /**
     * Verdächtige Aktivitäten überwachen
     */
    private function monitorSuspiciousActivity(Request $request, $user)
    {
        // Überwachung auf ungewöhnliche Download-Patterns
        $filename = $request->route('filename');

        if ($filename) {
            // Prüfe auf verdächtige Dateinamen
            $suspiciousPatterns = ['..', '/', '\\', '.env', 'config', 'database'];

            foreach ($suspiciousPatterns as $pattern) {
                if (strpos($filename, $pattern) !== false) {
                    Log::alert('Suspicious export filename detected', [
                        'user_id' => $user->id,
                        'filename' => $filename,
                        'ip' => $request->ip(),
                        'pattern' => $pattern,
                    ]);
                    break;
                }
            }
        }

        // Log alle Export-Zugriffe für Audit
        Log::info('Export access', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip' => $request->ip(),
            'url' => $request->url(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
