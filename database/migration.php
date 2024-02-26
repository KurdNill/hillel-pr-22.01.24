<?php
use function Core\db;
define('BASE_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);

require_once BASE_DIR . '/configs/constants.php';
require_once BASE_DIR . '/vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(BASE_DIR);
$dotenv->load();

class Migration
{
    const SCRIPTS_DIR = __DIR__ . '/scripts/';
    const MIGRATION = '0_migrations';

    public function __construct()
    {
        try {
            db()->beginTransaction();

            $this->createMigrationTable();
            $this->runMigrations();

            if (db()->inTransaction()) {
                db()->commit();
            }
        } catch (PDOException $exception) {
            if (db()->inTransaction()) {
                db()->rollBack();
            } else {
                db()->rollBack();
            }
            var_dump($exception->getMessage(), $exception->getTrace());
        }
    }

    protected function runMigrations(): void
    {
        $this->log('Fetching migrations');

        $migrations = scandir(self::SCRIPTS_DIR);
        $migrations = array_values(array_diff($migrations, ['.', '..', self::MIGRATION . '.sql']));

        foreach ($migrations as $migration) {
            if ($this->isMigrationsWasRun($migration)) {
                $this->log("- [$migration] SKIPPED!");
                continue;
            }

            $this->log("- Run [$migration]");
            $query = $this->getFileSQL($migration);

            if ($query->execute()) {
                $this->logIntoMigrations($migration);
                $this->log("- [$migration] DONE!");
            }
        }

        $this->log('Migrations done!');
    }

    protected function logIntoMigrations(string $migration)
    {
        $query = db()->prepare("INSERT INTO `migrations`(`name`) VALUES (:migration)");
        //$query->bindParam('migration', $migration);
        $query->execute(['migration' => $migration]);
    }

    protected function isMigrationsWasRun(string $migration): bool
    {
        $query = db()->prepare("SELECT `id` FROM `migrations` WHERE `name` = :name");
//        $query->bindParam('name', $migration);
        $query->execute(['name' => $migration]);
        return (bool) $query->fetch();
    }

    protected function createMigrationTable(): void
    {
        $this->log('Prepare migration table query');
        $query = $this->getFileSQL(static::MIGRATION . '.sql');

        print_r(match ($query->execute()) {
                true => '- Migration table was created (or already exists)',
                false => '- Failed'
            } . PHP_EOL);
        $this->log('Finished migration table query');
    }

    protected function getFileSQL(string $migration): PDOStatement
    {
        $sql = file_get_contents(static::SCRIPTS_DIR . $migration);
        return db()->prepare($sql);
    }

    protected function log(string $text): void
    {
        print_r("---- $text ----" . PHP_EOL);
    }
} new Migration;

$query = db()->prepare("UPDATE `migrations` SET `id` = 6 WHERE `id` = 7");
$query->execute();