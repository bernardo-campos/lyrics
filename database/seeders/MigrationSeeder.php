<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\Song;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MigrationSeeder extends Seeder
{
    private $artists_count = 0;
    private $albums_count = 0;
    private $songs_count = 0;

    public function getFiles($folder)
    {
        abort_if(!is_dir($folder), 403, "Directory $folder does not exist");

        $files = glob($folder.'/[!__example]*.json');

        return count($files) > 0
               ? $files
               : glob($folder.'/*.json');
    }

    public function sanearUrlImagen($img_url) {
        // Si la URL comienza con "//", agrega "http:"
        if (strpos($img_url, '//') === 0) {
            return 'http:' . $img_url;
        }
        // Si la URL no tiene protocolo, agrega "http://"
        elseif (strpos($img_url, 'http') !== 0) {
            return 'http://' . $img_url;
        }
        // Si ya tiene protocolo, devuélvela igual
        else {
            return $img_url;
        }
    }

    public function obtenerFilenameConPunto($filename1, $filename2) {
        if (strpos($filename1, '.') !== false) {
            return $filename1;
        } elseif (strpos($filename2, '.') !== false) {
            return $filename2;
        } else {
            return null;
        }
    }

    public function insertImageToAlbum($album, $img_url, $img_mini_url, $type='cover')
    {
        $img_url = $this->sanearUrlImagen($img_url);
        $img_mini_url = $this->sanearUrlImagen($img_mini_url);

        $filename1 = basename($img_url);
        $filename2 = basename($img_mini_url);

        $filename = $this->obtenerFilenameConPunto($filename1, $filename2);

        $img_path = "public/images/albums/$filename";

        if (str_ends_with($img_url, ".com.ar/tapas-cd/")) {
            $img_url .= $filename;
        }

        if (Storage::exists($img_path)) {
            $album->image()->create([
                'type' => 'cover',
                'url' => "storage/images/albums/$filename",
            ]);
        } else {
            try {
                // Descargar la imagen desde la URL
                $response = Http::get($img_url);

                if ($response->successful()) {
                    // Guardar la imagen en la carpeta especificada
                    Storage::put($img_path, $response->body());

                    // Crear el registro en la base de datos
                    $album->image()->create([
                        'type' => 'cover',
                        'url' => "storage/images/albums/$filename",
                    ]);
                    $this->command->info("Image downloaded from " . $img_url);
                } else {
                    $this->command->error("Album Image: $filename could not be downloaded [$img_url]. Artist: " . $album->artist->name);
                }
            } catch (\Exception $e) {
                $this->command->error("Album Image: $filename does not exist and cannot be downloaded. Error: " . $e->getMessage());
            }
        }
    }

    public function insertData($array)
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

            if ( !empty($albumArray['img_url']) || !empty($albumArray['img_url']) ) {
                $img_mini_url = $albumArray['img_mini_url'];
                $img_url = $albumArray['img_url'];
                $this->insertImageToAlbum($album, $img_url, $img_mini_url);
            }

            $songsToInsert = [];
            $timestamp = now();

            foreach ($albumArray['songs'] as $songArray) {
                $lyric = $songArray['lyric'] ?? null;

                if ($lyric !== null) {
                    $lyric = str_replace(["<br>\n", "\n<br>", '<br> ', '<br>'], "\n", $lyric);
                    $lyric = strip_tags(trim($lyric));
                }

                $songsToInsert[] = [
                    'album_id' => $album->id,
                    'artist_id' => $artist->id,
                    'number' => $songArray['number'],
                    'name' => $songArray['title'],
                    'lyric' => $lyric,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];

                $this->songs_count++;
            }

            Song::insert($songsToInsert);

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
