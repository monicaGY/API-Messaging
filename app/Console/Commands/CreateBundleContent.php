<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
class CreateBundleContent extends Command
{
    protected $signature = 'ddd {root}';
    protected $description = 'Create structure folders';

    public function handle():void
    {
        $root = str_replace('\\', '/', $this->argument('root'));
        $root = trim($root, '/');

        $basePath = base_path("src/{$root}");

        $structure = [
            'Infrastructure' => [
                'Entrypoint' => [
                    'Http' => []
                ],
                'Persistence' => []
            ],
            'Domain'=> [
                'Contract' => [],
                'Model' => [],
                'ValueObject' => [],
                'Service' => [],
                'UseCase' => [],
            ],
            'Application' => [
                'Handler' => [],
                'Transformer' => [],
            ],
        ];

        $this->createFolders($structure, $basePath);
    }
    private function createFolders($structure, $rootBase): void
    {
        foreach ($structure as $folder => $subFolders) {
            $root = $rootBase . '/' . $folder;

            if (!File::exists($root)) {
                File::makeDirectory($root, 0755, true);
            }

            if (is_array($subFolders)) {
                $this->createFolders($subFolders, $root);
            }
        }
    }
}
