<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SyncTranslations extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Sync:LangInJSON';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync translations from the database to the JSON file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $langFilePath = lang_path('Lang.json');
         // Ensure the directory exists
         $dir = dirname($langFilePath);
         if (!is_dir($dir)) {
             mkdir($dir, 0755, true); // Create directory if it doesn't exist
         }

        $data=[];

         // Fetch translations from the database
         $translations = DB::table('translation')->get(['id','en','du','ur']); // Assume table name is 'translations'
         if(!empty($translations)){

            foreach( $translations as $key => $translation){
                $data[$translation->id]=[
                  'en'=>$translation->en,
                  'de'=>$translation->du,
                  'ur'=>$translation->ur
                ];
            }
            // Attempt to write the file and check for errors
            $jsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            if($jsonContent === false) {
                $this->error('Failed to encode JSON');
                return 1;
            }

            $writeResult = file_put_contents($langFilePath, $jsonContent);

            if ($writeResult === false) {
                $this->error("Failed to write translations to " . $langFilePath);
                return 1;
            }

            $this->info("Translations synced successfully to " . $langFilePath);
            return 0;
    }
            $this->warn("No translations found to sync.");
            return 0;
  }
}
