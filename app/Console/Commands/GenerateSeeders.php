<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateSeeders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-seeders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate seeders from existing database data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating seeders from existing data...');

        $tables = [
            'users' => 'UserSeeder',
            'clients' => 'ClientSeeder',
            'products' => 'ProductSeeder',
            'invoices' => 'InvoiceSeeder',
            'invoice_items' => 'InvoiceItemSeeder',
        ];

        foreach ($tables as $table => $className) {
            $this->generateSeeder($table, $className);
        }

        $this->updateDatabaseSeeder(array_values($tables));

        $this->info('All seeders generated successfully!');
    }

    protected function generateSeeder($table, $className)
    {
        $data = DB::table($table)->get();
        $dataArray = $data->map(function ($item) {
            return (array)$item;
        })->toArray();

        // Convert array to string format for PHP file
        $dataString = $this->exportArray($dataArray);

        $content = "<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class {$className} extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('{$table}')->delete();
        
        DB::table('{$table}')->insert({$dataString});
    }
}
";

        $path = database_path("seeders/{$className}.php");
        File::put($path, $content);

        $this->info("Generated {$className}.php");
    }

    protected function exportArray($array)
    {
        // Simple array export, but we need to handle nulls and formatting
        $export = "[\n";
        foreach ($array as $row) {
            $export .= "            [\n";
            foreach ($row as $key => $value) {
                $export .= "                '{$key}' => " . var_export($value, true) . ",\n";
            }
            $export .= "            ],\n";
        }
        $export .= "        ]";
        return $export;
    }

    protected function updateDatabaseSeeder($seeders)
    {
        $path = database_path('seeders/DatabaseSeeder.php');

        $calls = implode(",\n            ", array_map(fn($s) => "$s::class", $seeders));

        $content = "<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \$this->call([
            {$calls},
        ]);
    }
}
";
        File::put($path, $content);
        $this->info('Updated DatabaseSeeder.php');
    }
}
