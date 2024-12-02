<?php

namespace Gpapanotas\Larabac\Config;

class PermissioningConfig
{
    public string $storageType;
    public array $databaseConfig;
    public string $jsonFilePath;

    public function __construct(array $config)
    {
        $this->storageType = $config['rule_storage'] ?? 'database';
        $this->databaseConfig = $config['database'] ?? [];
        $this->jsonFilePath = $config['json']['file_path'] ?? 'rules.json';
    }
}