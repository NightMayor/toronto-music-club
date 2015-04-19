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
                'description' => 'Aeolian harp'
            ],
            [
                'description' => 'Agida'
            ],
            [
                'description' => 'Agung a tamlang'
            ],
            [
                'description' => 'Air horn'
            ],
            [
                'description' => 'Ajaeng'
            ],
            [
                'description' => 'Alboka'
            ],
            [
                'description' => 'Alcahuete'
            ],
            [
                'description' => 'AlphaSphere'
            ],
            [
                'description' => 'Alphorn'
            ],
            [
                'description' => 'Alto horn'
            ],
            [
                'description' => 'Apinti'
            ],
            [
                'description' => 'Appalachian dulcimer'
            ],
            [
                'description' => 'Archlute'
            ],
            [
                'description' => 'Arghul'
            ],
            [
                'description' => 'Armonica'
            ],
            [
                'description' => 'Arobapa'
            ],
            [
                'description' => 'Arpeggione'
            ],
            [
                'description' => 'Asadullah (Meerut, India)'
            ],
            [
                'description' => 'Ashiko'
            ],
            [
                'description' => 'Assotor'
            ],
            [
                'description' => 'Atenteben'
            ],
            [
                'description' => 'Audiocubes'
            ],
            [
                'description' => 'Autoharp'
            ],
            [
                'description' => 'Baboula'
            ],
            [
                'description' => 'Baglama'
            ],
            [
                'description' => 'Bagpipe'
            ],
            [
                'description' => 'Balaban'
            ],
            [
                'description' => 'Balaban'
            ],
            [
                'description' => 'Balalaika'
            ],
            [
                'description' => 'Balsie'
            ],
            [
                'description' => 'Bamboula'
            ],
            [
                'description' => 'Bandoneon'
            ],
            [
                'description' => 'Bandura'
            ],
            [
                'description' => 'Banjo'
            ],
            [
                'description' => 'Banjo mandolin'
            ],
            [
                'description' => 'Banjo ukulele'
            ],
            [
                'description' => 'Bansuri'
            ],
            [
                'description' => 'Barbat'
            ],
            [
                'description' => 'Bari'
            ],
            [
                'description' => 'Baritone horn'
            ],
            [
                'description' => 'Barrel drum'
            ],
            [
                'description' => 'Barriles'
            ],
            [
                'description' => 'Baryton'
            ],
            [
                'description' => 'Bass drum'
            ],
            [
                'description' => 'Bass guitar'
            ],
            [
                'description' => 'Bassoon'
            ],
            [
                'description' => 'Bawu'
            ],
            [
                'description' => 'Bayan'
            ],
            [
                'description' => 'Bazooka'
            ],
            [
                'description' => 'Beatboxing'
            ],
            [
                'description' => 'Berimbau'
            ],
            [
                'description' => 'Bifora'
            ],
            [
                'description' => 'Birbyne'
            ],
            [
                'description' => 'Biwa'
            ],
            [
                'description' => 'Blul'
            ],
            [
                'description' => 'Bodhran'
            ],
            [
                'description' => 'Bombarde'
            ],
            [
                'description' => 'Bongo drums'
            ],
            [
                'description' => 'Boobam'
            ],
            [
                'description' => 'Bordonua'
            ],
            [
                'description' => 'Bouzouki'
            ],
            [
                'description' => 'Buccina'
            ],
            [
                'description' => 'Bugle'
            ],
            [
                'description' => 'Bullroarer'
            ],
            [
                'description' => 'Cajon'
            ],
            [
                'description' => 'Calliope'
            ],
            [
                'description' => 'Candombe'
            ],
            [
                'description' => 'Carillon'
            ],
            [
                'description' => 'Castanets'
            ],
            [
                'description' => 'Castrato'
            ],
            [
                'description' => 'Cavaquinho'
            ],
            [
                'description' => 'Celesta'
            ],
            [
                'description' => 'Cello (violoncello)'
            ],
            [
                'description' => 'Chalumeau'
            ],
            [
                'description' => 'Chapman stick'
            ],
            [
                'description' => 'Charango'
            ],
            [
                'description' => 'Chenda (Chande)'
            ],
            [
                'description' => 'Cimbalom'
            ],
            [
                'description' => 'Cimbasso'
            ],
            [
                'description' => 'Citole'
            ],
            [
                'description' => 'Cittern'
            ],
            [
                'description' => 'Clapsticks'
            ],
            [
                'description' => 'Clarinet'
            ],
            [
                'description' => 'Clarytone'
            ],
            [
                'description' => 'Clavichord'
            ],
            [
                'description' => 'Clavinet'
            ],
            [
                'description' => 'Concertina'
            ],
            [
                'description' => 'Conch'
            ],
            [
                'description' => 'Conga (Tumbadura)'
            ],
            [
                'description' => 'Cornamuse'
            ],
            [
                'description' => 'Cornet'
            ],
            [
                'description' => 'Cornett'
            ],
            [
                'description' => 'Cornu'
            ],
            [
                'description' => 'Corrugaphone'
            ],
            [
                'description' => 'Countertenor'
            ],
            [
                'description' => 'Croix Sonore'
            ],
            [
                'description' => 'Cromorne'
            ],
            [
                'description' => 'Crumhorn'
            ],
            [
                'description' => 'Crwth'
            ],
            [
                'description' => 'Crystallophone'
            ],
            [
                'description' => 'Cuatro'
            ],
            [
                'description' => 'Cuica'
            ],
            [
                'description' => 'Cumbus'
            ],
            [
                'description' => 'Dabakan'
            ],
            [
                'description' => 'Daf (Dap, Def)'
            ],
            [
                'description' => 'Dahu'
            ],
            [
                'description' => 'Dan bau'
            ],
            [
                'description' => 'Dan gao'
            ],
            [
                'description' => 'Dan nguyat'
            ],
            [
                'description' => 'Dan ta ba'
            ],
            [
                'description' => 'Dan tam thap lac'
            ],
            [
                'description' => 'Dan tranh'
            ],
            [
                'description' => 'Danso'
            ],
            [
                'description' => 'Davul (Dahol, Daul, Daouli, Dhaulli)'
            ],
            [
                'description' => "Denis d'or"
            ],
            [
                'description' => 'Dhaa'
            ],
            [
                'description' => 'Dhimay (Dhimaya)'
            ],
            [
                'description' => 'Dhol'
            ],
            [
                'description' => 'Dholak (Dholaki)'
            ],
            [
                'description' => 'Diddley bow'
            ],
            [
                'description' => 'Didgeridoo'
            ],
            [
                'description' => 'Dihu'
            ],
            [
                'description' => 'Dimdi'
            ],
            [
                'description' => 'Diple (or dvojnice)'
            ],
            [
                'description' => 'Dizi'
            ],
            [
                'description' => 'Djembe'
            ],
            [
                'description' => 'Dollu'
            ],
            [
                'description' => 'Dombra'
            ],
            [
                'description' => 'Domra'
            ],
            [
                'description' => 'Double bass'
            ],
            [
                'description' => 'Double bell euphonium'
            ],
            [
                'description' => 'Double-neck guitjo'
            ],
            [
                'description' => 'Doulophone/cuprophone'
            ],
            [
                'description' => 'Drum kit'
            ],
            [
                'description' => 'Drum machine'
            ],
            [
                'description' => 'Dubreq stylophone'
            ],
            [
                'description' => 'Duduk'
            ],
            [
                'description' => 'Dulcian'
            ],
            [
                'description' => 'Dulcimer'
            ],
            [
                'description' => 'Dulzaina'
            ],
            [
                'description' => 'Dung-Dkar'
            ],
            [
                'description' => 'Dunun (Dundun)'
            ],
            [
                'description' => 'Dutar'
            ],
            [
                'description' => 'Duxianqin'
            ],
            [
                'description' => 'Dzhamara'
            ],
            [
                'description' => 'Eigenharp'
            ],
            [
                'description' => 'Ektara'
            ],
            [
                'description' => 'Electric cymbalum'
            ],
            [
                'description' => 'Electronic organ'
            ],
            [
                'description' => 'English horn'
            ],
            [
                'description' => 'Erhu'
            ],
            [
                'description' => 'Erxian'
            ],
            [
                'description' => 'Esraj'
            ],
            [
                'description' => 'Euphonium'
            ],
            [
                'description' => 'EWI'
            ],
            [
                'description' => 'Faglong/Fuglung'
            ],
            [
                'description' => 'Fegereng'
            ],
            [
                'description' => 'Fiddle'
            ],
            [
                'description' => 'Fife'
            ],
            [
                'description' => 'Firebird (trumpet)'
            ],
            [
                'description' => 'Fiscorn'
            ],
            [
                'description' => 'Flabiol'
            ],
            [
                'description' => 'Flageolet'
            ],
            [
                'description' => 'Flatt trumpet'
            ],
            [
                'description' => 'Flugelhorn'
            ],
            [
                'description' => 'Flumpet'
            ],
            [
                'description' => 'Flute'
            ],
            [
                'description' => 'Flute'
            ],
            [
                'description' => 'Flutina'
            ],
            [
                'description' => 'Folgerphone'
            ],
            [
                'description' => 'Fortepiano'
            ],
            [
                'description' => 'Fujara'
            ],
            [
                'description' => 'Gaida'
            ],
            [
                'description' => 'Garmon'
            ],
            [
                'description' => 'Gayageum'
            ],
            [
                'description' => 'Gehu'
            ],
            [
                'description' => 'Gemshorn'
            ],
            [
                'description' => 'Geomungo'
            ],
            [
                'description' => 'Gittern'
            ],
            [
                'description' => 'Glass Armonica'
            ],
            [
                'description' => 'Glasschord'
            ],
            [
                'description' => 'Goblet drum'
            ],
            [
                'description' => 'Gopuz'
            ],
            [
                'description' => 'Gottuvadhyam'
            ],
            [
                'description' => 'Gralla'
            ],
            [
                'description' => 'Gran Cassa'
            ],
            [
                'description' => 'Guan'
            ],
            [
                'description' => 'Guitar'
            ],
            [
                'description' => 'Guitarra quinta huapanguera'
            ],
            [
                'description' => 'Guitarron'
            ],
            [
                'description' => 'Guqin'
            ],
            [
                'description' => 'Gusli'
            ],
            [
                'description' => 'Guzheng'
            ],
            [
                'description' => 'Guzheng'
            ],
            [
                'description' => 'Haegeum'
            ],
            [
                'description' => 'Hammered dulcimer'
            ],
            [
                'description' => 'Hammond organ'
            ],
            [
                'description' => 'Handpan/Hang'
            ],
            [
                'description' => 'Hano'
            ],
            [
                'description' => 'Hardanger fiddle'
            ],
            [
                'description' => 'Harmonica'
            ],
            [
                'description' => 'Harmonico'
            ],
            [
                'description' => 'Harmonium'
            ],
            [
                'description' => 'Harp'
            ],
            [
                'description' => 'Harpsichord'
            ],
            [
                'description' => 'Heckelphone'
            ],
            [
                'description' => 'Hegelong'
            ],
            [
                'description' => 'Helicon'
            ],
            [
                'description' => 'Hira-daiko'
            ],
            [
                'description' => 'Horagai'
            ],
            [
                'description' => 'Horn/French horn'
            ],
            [
                'description' => 'Hosaphone'
            ],
            [
                'description' => 'Hotchiku'
            ],
            [
                'description' => 'Huluhu'
            ],
            [
                'description' => 'Hulusi'
            ],
            [
                'description' => 'Hun'
            ],
            [
                'description' => 'Huqin'
            ],
            [
                'description' => 'Hurdy-gurdy'
            ],
            [
                'description' => 'Hydraulophone'
            ],
            [
                'description' => 'Igil'
            ],
            [
                'description' => 'Ilimba drum'
            ],
            [
                'description' => 'Inci'
            ],
            [
                'description' => 'Ingoma'
            ],
            [
                'description' => 'Irish bouzouki'
            ],
            [
                'description' => 'Irish flute'
            ],
            [
                'description' => 'Jammer keyboard'
            ],
            [
                'description' => 'Janggu (Janggo, changgo)'
            ],
            [
                'description' => 'Jarana de son jarocho'
            ],
            [
                'description' => 'Jarana huasteca'
            ],
            [
                'description' => 'Jarana mosquito'
            ],
            [
                'description' => 'Jarana segunda'
            ],
            [
                'description' => 'Jarana tercera'
            ],
            [
                'description' => 'Jiaohu'
            ],
            [
                'description' => 'Jug'
            ],
            [
                'description' => 'Kabosy'
            ],
            [
                'description' => 'Kadlong'
            ],
            [
                'description' => 'Kagurabue'
            ],
            [
                'description' => 'Kakko'
            ],
            [
                'description' => 'Kalaleng'
            ],
            [
                'description' => 'Kamancha'
            ],
            [
                'description' => 'Kanjira'
            ],
            [
                'description' => 'Kantele'
            ],
            [
                'description' => 'Kaval'
            ],
            [
                'description' => 'Kazoo'
            ],
            [
                'description' => 'Kemenche'
            ],
            [
                'description' => 'Ken bau'
            ],
            [
                'description' => 'Kendang'
            ],
            [
                'description' => 'Key bugle'
            ],
            [
                'description' => 'Keyboard'
            ],
            [
                'description' => 'Keytar'
            ],
            [
                'description' => 'Khene'
            ],
            [
                'description' => 'Khim'
            ],
            [
                'description' => 'Khloy'
            ],
            [
                'description' => 'Khlui'
            ],
            [
                'description' => 'Khol (Mrdanga)'
            ],
            [
                'description' => 'Kobza'
            ],
            [
                'description' => 'Kokyu'
            ],
            [
                'description' => 'Komabue'
            ],
            [
                'description' => 'Komungo'
            ],
            [
                'description' => 'Koncovka'
            ],
            [
                'description' => 'Kora'
            ],
            [
                'description' => 'Kortholt'
            ],
            [
                'description' => 'Koto'
            ],
            [
                'description' => 'Koudi'
            ],
            [
                'description' => 'Kraakdoos (or cracklebox)'
            ],
            [
                'description' => 'Kubing'
            ],
            [
                'description' => 'Kudyapi'
            ],
            [
                'description' => 'Kuhlohorn'
            ],
            [
                'description' => 'Lambeg drum'
            ],
            [
                'description' => 'Langeleik'
            ],
            [
                'description' => 'Laruan'
            ],
            [
                'description' => 'Laser harp'
            ],
            [
                'description' => 'Launeddas'
            ],
            [
                'description' => 'Leiqin'
            ],
            [
                'description' => 'Lirone'
            ],
            [
                'description' => 'Lituus'
            ],
            [
                'description' => 'Livenka'
            ],
            [
                'description' => 'Lokanga'
            ],
            [
                'description' => 'Lusheng'
            ],
            [
                'description' => 'Lute'
            ],
            [
                'description' => 'Lyra (Byzantine)'
            ],
            [
                'description' => 'Lyra (Cretan)'
            ],
            [
                'description' => 'Lyre'
            ],
            [
                'description' => 'Madal'
            ],
            [
                'description' => 'Maddale'
            ],
            [
                'description' => 'Madhalam'
            ],
            [
                'description' => 'Maguhu'
            ],
            [
                'description' => 'Maktoum (maktoom, katem)'
            ],
            [
                'description' => 'Mando-bass'
            ],
            [
                'description' => 'Mandocello'
            ],
            [
                'description' => 'Mandola'
            ],
            [
                'description' => 'Mandolin'
            ],
            [
                'description' => 'Mandora'
            ],
            [
                'description' => 'Mandore'
            ],
            [
                'description' => 'Mangtong'
            ],
            [
                'description' => 'Marimba'
            ],
            [
                'description' => 'Marimba'
            ],
            [
                'description' => 'Marovany'
            ],
            [
                'description' => 'Mellophone'
            ],
            [
                'description' => 'Mellotron'
            ],
            [
                'description' => 'Melodeon'
            ],
            [
                'description' => 'Melodica'
            ],
            [
                'description' => 'Melodica'
            ],
            [
                'description' => 'Mezzo-soprano'
            ],
            [
                'description' => 'Mijwiz'
            ],
            [
                'description' => 'Mizmar'
            ],
            [
                'description' => 'Mohan veena'
            ],
            [
                'description' => 'Morin khuur'
            ],
            [
                'description' => 'Mridangam'
            ],
            [
                'description' => 'Musette de cour'
            ],
            [
                'description' => 'Musical bow'
            ],
            [
                'description' => 'Nadaswaram'
            ],
            [
                'description' => 'Nagak'
            ],
            [
                'description' => 'Naqara'
            ],
            [
                'description' => 'Naqareh'
            ],
            [
                'description' => 'Ney'
            ],
            [
                'description' => 'Nguru'
            ],
            [
                'description' => 'Nohkan'
            ],
            [
                'description' => 'Nose flute'
            ],
            [
                'description' => 'Nyckelharpa'
            ],
            [
                'description' => 'Oboes'
            ],
            [
                'description' => 'Ocarina'
            ],
            [
                'description' => 'Octaban'
            ],
            [
                'description' => 'Octave mandolin (Octave mandola)'
            ],
            [
                'description' => 'Octavin'
            ],
            [
                'description' => 'Octobass'
            ],
            [
                'description' => 'O-daiko'
            ],
            [
                'description' => 'Okedo-daiko'
            ],
            [
                'description' => 'Omnichord'
            ],
            [
                'description' => 'Ondes Martenot'
            ],
            [
                'description' => 'Ophicleide'
            ],
            [
                'description' => 'Oud'
            ],
            [
                'description' => 'Overtone zither'
            ],
            [
                'description' => 'Paixiao'
            ],
            [
                'description' => 'Pakhavaj'
            ],
            [
                'description' => 'Palendag'
            ],
            [
                'description' => 'Pan flute'
            ],
            [
                'description' => 'Pandero'
            ],
            [
                'description' => 'Pasiyak or water whistle'
            ],
            [
                'description' => 'Pavari'
            ],
            [
                'description' => 'Piano (pianoforte)'
            ],
            [
                'description' => 'Pibgorn'
            ],
            [
                'description' => 'Picco pipe'
            ],
            [
                'description' => 'Piccolo'
            ],
            [
                'description' => 'Piccolo cello/violoncello piccolo'
            ],
            [
                'description' => 'Piccolo snare'
            ],
            [
                'description' => 'Piccolo trumpet'
            ],
            [
                'description' => 'Piccolo violino'
            ],
            [
                'description' => 'Pipa'
            ],
            [
                'description' => 'Pipe organ'
            ],
            [
                'description' => 'Pitch pipe'
            ],
            [
                'description' => 'Piwancha'
            ],
            [
                'description' => 'Plasmaphone'
            ],
            [
                'description' => 'Pocket cornet'
            ],
            [
                'description' => 'Pocket trumpet'
            ],
            [
                'description' => 'Post horn'
            ],
            [
                'description' => 'Psaltery'
            ],
            [
                'description' => 'Pu'
            ],
            [
                'description' => 'Pulalu'
            ],
            [
                'description' => 'Pyrophone'
            ],
            [
                'description' => 'Quatro'
            ],
            [
                'description' => 'Quena'
            ],
            [
                'description' => 'Quintephone'
            ],
            [
                'description' => 'Quinticlave'
            ],
            [
                'description' => 'Rackett'
            ],
            [
                'description' => 'Rapping'
            ],
            [
                'description' => 'Rauschpfeife'
            ],
            [
                'description' => 'Ravanahatha'
            ],
            [
                'description' => 'Rebab'
            ],
            [
                'description' => 'Rebec'
            ],
            [
                'description' => 'Recorder'
            ],
            [
                'description' => 'Reed contrabass'
            ],
            [
                'description' => 'Reed organ'
            ],
            [
                'description' => 'Repique'
            ],
            [
                'description' => 'Requinto jarocho'
            ],
            [
                'description' => 'Rhaita'
            ],
            [
                'description' => 'Robero'
            ],
            [
                'description' => 'Roman tuba'
            ],
            [
                'description' => 'Ruan'
            ],
            [
                'description' => 'Rudra vina'
            ],
            [
                'description' => 'Ryuteki'
            ],
            [
                'description' => 'Sabar'
            ],
            [
                'description' => 'Sackbut'
            ],
            [
                'description' => 'Saenghwang'
            ],
            [
                'description' => 'Sallameh'
            ],
            [
                'description' => 'Samphor'
            ],
            [
                'description' => 'Sampler'
            ],
            [
                'description' => 'Samponia'
            ],
            [
                'description' => 'Sanshin'
            ],
            [
                'description' => 'Santoor'
            ],
            [
                'description' => 'Sanxian'
            ],
            [
                'description' => 'Sarangi'
            ],
            [
                'description' => 'Saratovskaya garmonika'
            ],
            [
                'description' => 'Sarod'
            ],
            [
                'description' => 'Sarrusophone'
            ],
            [
                'description' => 'Saung'
            ],
            [
                'description' => 'Saw sam sai'
            ],
            [
                'description' => 'Saxhorn'
            ],
            [
                'description' => 'Saxophone'
            ],
            [
                'description' => 'Saxotromba'
            ],
            [
                'description' => 'Saxtuba'
            ],
            [
                'description' => 'Saz'
            ],
            [
                'description' => 'Schwyzerorgeli'
            ],
            [
                'description' => 'Se'
            ],
            [
                'description' => 'Sea organ'
            ],
            [
                'description' => 'Serpent'
            ],
            [
                'description' => 'Setar (lute)'
            ],
            [
                'description' => 'Shakuhachi'
            ],
            [
                'description' => 'Shamisen'
            ],
            [
                'description' => 'Shankha'
            ],
            [
                'description' => 'Shawm'
            ],
            [
                'description' => 'Shehnai'
            ],
            [
                'description' => 'Sheng'
            ],
            [
                'description' => 'Shime-jishi daiko'
            ],
            [
                'description' => 'Shinobue'
            ],
            [
                'description' => 'Shishi odoshi (Japan)'
            ],
            [
                'description' => 'Sho'
            ],
            [
                'description' => 'Shofar'
            ],
            [
                'description' => 'Shvi'
            ],
            [
                'description' => 'Siku'
            ],
            [
                'description' => 'Siren'
            ],
            [
                'description' => 'Sitar'
            ],
            [
                'description' => 'Sitarla'
            ],
            [
                'description' => 'Skoog'
            ],
            [
                'description' => 'Slide trumpet'
            ],
            [
                'description' => 'Slide whistle'
            ],
            [
                'description' => 'Snare'
            ],
            [
                'description' => 'Sodina'
            ],
            [
                'description' => 'Sopila'
            ],
            [
                'description' => 'Sopranino mandolin'
            ],
            [
                'description' => 'Soprano'
            ],
            [
                'description' => 'Sorna'
            ],
            [
                'description' => 'Sousaphone'
            ],
            [
                'description' => 'Sralai'
            ],
            [
                'description' => 'Steelpan'
            ],
            [
                'description' => 'Stroh violin'
            ],
            [
                'description' => 'Sudrophone'
            ],
            [
                'description' => 'Suikinkutsu (Japanese water zither)'
            ],
            [
                'description' => 'Suling'
            ],
            [
                'description' => 'Suona'
            ],
            [
                'description' => 'Superbone'
            ],
            [
                'description' => 'Surdo'
            ],
            [
                'description' => 'Swordblade'
            ],
            [
                'description' => 'Synclavier'
            ],
            [
                'description' => 'Synthesizer'
            ],
            [
                'description' => 'Tabla'
            ],
            [
                'description' => 'Tabor pipe'
            ],
            [
                'description' => 'Taepyeongso'
            ],
            [
                'description' => 'Taiko'
            ],
            [
                'description' => 'Talking drum'
            ],
            [
                'description' => 'Tambor huacana'
            ],
            [
                'description' => 'Tamboril'
            ],
            [
                'description' => 'Tamborita (Mexico)'
            ],
            [
                'description' => 'Tambou bas a de fas'
            ],
            [
                'description' => 'Tambou bas a yon fas'
            ],
            [
                'description' => 'Tambourine'
            ],
            [
                'description' => 'Tamburitza'
            ],
            [
                'description' => 'Tanpura'
            ],
            [
                'description' => 'Tan-tan'
            ],
            [
                'description' => 'Taphon'
            ],
            [
                'description' => 'Tar (lute)'
            ],
            [
                'description' => 'Tarogato'
            ],
            [
                'description' => 'Tea chest bass'
            ],
            [
                'description' => 'Teleharmonium'
            ],
            [
                'description' => 'Tembur'
            ],
            [
                'description' => 'Tembur'
            ],
            [
                'description' => 'Tenor'
            ],
            [
                'description' => 'Tenor viola'
            ],
            [
                'description' => 'Tenora'
            ],
            [
                'description' => 'Tenori-on'
            ],
            [
                'description' => 'Thavil'
            ],
            [
                'description' => 'Theorbo'
            ],
            [
                'description' => 'Theremin'
            ],
            [
                'description' => 'Tible'
            ],
            [
                'description' => 'Timpani (kettledrum)'
            ],
            [
                'description' => 'Timple'
            ],
            [
                'description' => 'Tin whistle'
            ],
            [
                'description' => 'Tombak'
            ],
            [
                'description' => 'Tom-tom'
            ],
            [
                'description' => 'Tonette'
            ],
            [
                'description' => 'Tres'
            ],
            [
                'description' => 'Triangle'
            ],
            [
                'description' => 'Trikiti'
            ],
            [
                'description' => 'Tro'
            ],
            [
                'description' => 'Trombones'
            ],
            [
                'description' => 'Tromboon'
            ],
            [
                'description' => 'Trompeta china'
            ],
            [
                'description' => 'Trumpet'
            ],
            [
                'description' => 'Trumpet marine/tromba marina'
            ],
            [
                'description' => 'Tsukeshime-daiko'
            ],
            [
                'description' => 'Tsuzumi'
            ],
            [
                'description' => 'Tsymbaly'
            ],
            [
                'description' => 'Tuba'
            ],
            [
                'description' => 'Tube trumpet'
            ],
            [
                'description' => 'Tuhu'
            ],
            [
                'description' => 'Tumpong'
            ],
            [
                'description' => 'Tungso'
            ],
            [
                'description' => 'Tupan'
            ],
            [
                'description' => 'Turntable'
            ],
            [
                'description' => 'Tutek'
            ],
            [
                'description' => 'Txistu'
            ],
            [
                'description' => 'Uchiwa-daiko'
            ],
            [
                'description' => 'Uilleann pipes'
            ],
            [
                'description' => 'Ukulele'
            ],
            [
                'description' => 'Valiha'
            ],
            [
                'description' => 'Veena'
            ],
            [
                'description' => 'Venu'
            ],
            [
                'description' => 'Vertical viola (and other members of the violin octet family)'
            ],
            [
                'description' => 'Vichitra vina'
            ],
            [
                'description' => 'Vielle'
            ],
            [
                'description' => 'Vienna horn'
            ],
            [
                'description' => 'Vihuela'
            ],
            [
                'description' => 'Vihuela'
            ],
            [
                'description' => 'Viola'
            ],
            [
                'description' => 'Viola da gamba'
            ],
            [
                'description' => "Viola d'amore"
            ],
            [
                'description' => 'Viola organista'
            ],
            [
                'description' => 'Violin'
            ],
            [
                'description' => 'Violotta'
            ],
            [
                'description' => 'Vuvuzela'
            ],
            [
                'description' => 'Wagner tuba'
            ],
            [
                'description' => 'Washint'
            ],
            [
                'description' => 'Washtub bass'
            ],
            [
                'description' => 'Whamola'
            ],
            [
                'description' => 'Wheelharp'
            ],
            [
                'description' => 'Whip'
            ],
            [
                'description' => 'Whistle'
            ],
            [
                'description' => 'Willow flute'
            ],
            [
                'description' => 'Wobble board (Australia)'
            ],
            [
                'description' => 'Wood block'
            ],
            [
                'description' => 'Xalam/Khalam'
            ],
            [
                'description' => 'Xiao'
            ],
            [
                'description' => 'Xun'
            ],
            [
                'description' => 'Xylophone'
            ],
            [
                'description' => 'Yangqin'
            ],
            [
                'description' => 'Yayli tanbur'
            ],
            [
                'description' => 'Yazheng'
            ],
            [
                'description' => 'Yodel'
            ],
            [
                'description' => 'Yotar'
            ],
            [
                'description' => 'Yu'
            ],
            [
                'description' => 'Zhaleika'
            ],
            [
                'description' => 'Zhonghu'
            ],
            [
                'description' => 'Zhuihu'
            ],
            [
                'description' => 'Zither'
            ],
            [
                'description' => 'Zufolo'
            ],
            [
                'description' => 'Zugtrompette'
            ],
            [
                'description' => 'Zurna (Turkey)'
            ],
        ];

        foreach ($instruments as $instrument) {
        	Instrument::create($instrument);
        }
    }

}