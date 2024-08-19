<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MigrationSeeder extends Seeder
{
    private $artists_count = 0;
    private $albums_count = 0;
    private $songs_count = 0;

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
        $this->artists_count++;

        foreach ($array['albums'] as $albumArray) {
            $album = $artist->albums()->create([
                'name' => $albumArray['title'],
                'year' => $albumArray['year'],
            ]);
            $this->albums_count++;

            foreach ($albumArray['songs'] as $songArray) {
                $lyric = $songArray['lyric'] ?? null;

                if ($lyric !== null) {
                    $lyric = str_replace(["<br>\n", "\n<br>", '<br> ', '<br>'], "\n", $lyric);
                    $lyric = strip_tags(trim($lyric));
                }

                $album->songs()->create([
                    'artist_id' => $artist->id,
                    'number' => $songArray['number'],
                    'name' => $songArray['title'],
                    'lyric' => $lyric,
                ]);
                $this->songs_count++;
            }
        }
    }

    public function run(): void
    {
        $filenames = $this->getFiles(__DIR__ . "/data");

        try {
            DB::beginTransaction();

            $startTime = microtime(true);
            $this->command->info('Begin transaction...');

            foreach ($filenames as $filename) {
                $content = file_get_contents($filename);
                $array = json_decode($content, true);
                $this->insertData($array);
            }

            $elapsedTime = microtime(true) - $startTime;
            $this->command->info("{$this->artists_count} artists, {$this->albums_count} albums and {$this->songs_count} songs will be created...");
            $this->command->info("Elapsed time: {$elapsedTime} seconds");

            $this->command->info("Starting commit...");
            DB::commit();
            $this->command->info("Commit has finished. Elapsed time: {$elapsedTime} seconds");
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
            $this->command->error("Rolling back...");
            DB::rollBack();
        }

    }
}
