<?php

use App\Instrument;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class InstrumentsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('instruments')->delete();

        $instruments = [
        	[
        		'description' => 'Accordion'
        	],
        	[
        		'description' => 'Bagpipe'
        	],
        	[
        		'description' => 'Bassoon'
        	],
        	[
        		'description' => 'Bass'
        	],
        	[
        		'description' => 'Beatboxing'
        	],
        	[
        		'description' => 'Bugle'
        	],
        	[
        		'description' => 'Clarinet'
        	],
        	[
        		'description' => 'Concertina'
        	],
        	[
        		'description' => 'Drums'
        	],
        	[
        		'description' => 'Flute'
        	],
        	[
        		'description' => 'French Horn'
        	],
        	[
        		'description' => 'Guitar'
        	],
        	[
        		'description' => 'Harp'
        	],
        	[
        		'description' => 'Harmonica'
        	],
        	[
        		'description' => 'Mandolin'
        	],
        	[
        		'description' => 'Percussion'
        	],
        	[
        		'description' => 'Piano'
        	],
        	[
        		'description' => 'Saxophone'
        	],
        	[
        		'description' => 'Trombone'
        	],
        	[
        		'description' => 'Trumpet'
        	],
        	[
        		'description' => 'Ukulele'
        	],
        	[
        		'description' => 'Violin'
        	],
        	[
        		'description' => 'Vocals'
        	],
        ];

        foreach ($instruments as $instrument) {
        	Instrument::create($instrument);
        }
    }

}