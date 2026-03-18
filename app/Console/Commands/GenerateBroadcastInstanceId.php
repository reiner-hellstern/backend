<?php

namespace App\Console\Commands;

use App\Helpers\BroadcastHelper;
use Illuminate\Console\Command;

class GenerateBroadcastInstanceId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:instance-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate unique instance ID for broadcast channels (based on APP_KEY)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $instanceId = BroadcastHelper::getInstanceId();

        $this->info('Broadcast Instance ID for this environment:');
        $this->line('');
        $this->line("  VITE_APP_INSTANCE_ID={$instanceId}");
        $this->line('');
        $this->info('Add this to your frontend .env file (.env.blooming, .env.staging, etc.)');
        $this->line('');

        // Show example channels
        $this->comment('Example channel names:');
        $this->line("  User Channel:         {$instanceId}.user.{userId}");
        $this->line("  Notifications:        {$instanceId}.notifications.{userId}");
        $this->line("  Role Channel:         {$instanceId}.role.{roleId}");
        $this->line("  Organization Channel: {$instanceId}.organization.{orgId}");
        $this->line("  App Channel:          {$instanceId}.app");

        return Command::SUCCESS;
    }
}
