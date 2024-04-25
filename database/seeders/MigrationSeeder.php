<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MigrationSeeder extends Seeder
{
    function getFiles($folder)
    {
        abort_if(!is_dir($folder), 403, "Directory $folder does not exist");

        $files = glob($folder.'/[!__example]*.json');

        return count($files) > 0
               ? $files
               : glob($folder.'/*.json');
    }

    function insertData($array)
    {
        $artist = Artist::create([
            'name' => $array['name'],
            'slug' => Str::slug($array['name'], '-'),
        ]);

        foreach ($array['albums'] as $albumArray) {
            $album = $artist->albums()->create([
                'name' => $albumArray['title'],
                'year' => $albumArray['year'],
            ]);
            foreach ($albumArray['songs'] as $songArray) {
                $album->songs()->create([
                    'number' => $songArray['number'],
                    'name' => $songArray['title'],
                    'lyric' => array_key_exists('lyric', $songArray)
                               ? strip_tags(trim($songArray['lyric']))
                               : null,
                ]);
            }
        }
    }

    public function run(): void
    {
        $filenames = $this->getFiles(__DIR__ . "/data");

        // $filenames = array_slice($filenames, 0, 50);

        try {
            DB::beginTransaction();

            $this->command->info('Begin transaction...');

            foreach ($filenames as $filename) {
                $content = file_get_contents($filename);
                $array = json_decode($content, true);
                $this->insertData($array);
            }

            $this->command->info(count($filenames) . ' artists created...');

            DB::commit();
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
            DB::rollBack();
        }

    }
}
