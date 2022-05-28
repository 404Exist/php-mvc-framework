<?php 

namespace App\Core;

class DB
{
    public \PDO $pdo;
    private string $migrationsDir = __DIR__.'/../../migrations/';

    public function __construct()
    {
        $this->pdo = new \PDO(
            'mysql:host='.config('database.host').
            ';port='.config('database.port').
            ';dbname='.config('database.database'), 
            config('database.username'), 
            config('database.password')
        );
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function query(string $sql, array $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function exec(string $sql)
    {
        return $this->pdo->exec($sql);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        if (count($this->getMigrationsToApply()) == 0) 
            return $this->log('No migrations to apply');
        foreach ($this->getMigrationsToApply() as $migration) 
            $this->migrateUp($migration);
    }

    public function createMigrationsTable()
    {
        $this->exec('
            CREATE TABLE IF NOT EXISTS `migrations` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `migration` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            )
        ');
    }

    public function getMigrationsToApply()
    {
        $migrationFiles = scandir($this->migrationsDir);
        $migratedFiles = $this->query('SELECT migration FROM migrations')->fetchAll(\PDO::FETCH_COLUMN);
        return array_diff($migrationFiles, [...$migratedFiles, '.', '..']);
    }

    public function pushToMigrationsTable(string $migration)
    {
        $this->exec("INSERT INTO migrations (migration) VALUES ('$migration')");
        $this->log("$migration migrated\n");
    }

    public function migrateUp($migration)
    {
        $class = require_once $this->migrationsDir.$migration;
        $this->exec((new $class())->up());
        $this->pushToMigrationsTable($migration);
    }

    protected function log(string $message)
    {
        echo "[".date('Y-m-d H:i:s')."] - $message\n";
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

}