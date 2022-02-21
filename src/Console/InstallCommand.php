<?php

namespace Noxyz20\Kartobuilder\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\filesystem\Filesystem;

class InstallCommand extends Command
{
    protected $signature = 'kartobuilder:install';

    protected $description = 'Install Kartobuilder';

    public function handle()
    {
        $this->updateNodePackages(function ($packages) {
            return [
                '@vue-leaflet/vue-leaflet' => '^0.6.1',
            ] + $packages;
        });
        
        \Artisan::call('migrate', [
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'map-views',
            '--force' => $this->option('force'),
        ]);

        $this->info('Kartobuilder installed successfully.');
    }

    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}