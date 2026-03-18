<?php

namespace App\Helpers;

class BroadcastHelper
{
    /**
     * Holt sich den eindeutigen Instanzbezeichner für diese Laravel-Installation
     *
     * Priority:
     * 1. BROADCAST_INSTANCE_ID aus der .env (manuelle Überschreibung)
     * 2. APP_KEY hash (automatisch, wenn die Schlüssel unterschiedlich sind)
     *
     * @return string Instance identifier ( "mamp-dev", "stage", "blooming" oder hash)
     */
    public static function getInstanceId(): string
    {
        // Prüfe manuelle Einstellung in der .env
        $manualId = config('broadcasting.instance_id');
        if ($manualId) {
            return $manualId;
        }

        // Fallback auf APP_KEY hash
        return substr(md5(config('app.key')), 0, 8);
    }

    /**
     * Erstelle den user channel Namen mit Instanzpräfix
     *
     * @return string Channel name z.B. "stage.user.123"
     */
    public static function getUserChannel(int $userId): string
    {
        $instanceId = self::getInstanceId();

        return "{$instanceId}.user.{$userId}";
    }

    /**
     * Erstelle den role channel Namen mit Instanzpräfix
     *
     * @return string Channel name z.B. "stage.role.5"
     */
    public static function getRoleChannel(int $roleId): string
    {
        $instanceId = self::getInstanceId();

        return "{$instanceId}.role.{$roleId}";
    }
}
