<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StarWappie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'planet_name',
    ];

    public static function getRandom() {
        $starWappies = StarWappie::makeHttpCall('https://swapi.dev/api/people/');

        $length = $starWappies['count'];
        $randomIndex = rand(0, $length); // no -1 as id 83 also exists when receiving 82 as count

        $starWappieJSON = ($randomIndex > count($starWappies['results'])) ?
            StarWappie::getSpecificWappie($randomIndex + 1) :
            $starWappies['results'][$randomIndex];

        $starWappie = StarWappie::where('name', $starWappieJSON['name'])->first();
        if(!$starWappie) {
            $starWappie = new StarWappie();
        }

        $starWappie->name = $starWappieJSON['name'];
        $starWappie->planet_name = StarWappie::makeHttpCall($starWappieJSON['homeworld'])['name'];

        return $starWappie;
    }

    public static function getSpecificWappie($id) {
        return StarWappie::makeHttpCall('https://swapi.dev/api/people/' . $id + 1 . '/');
    }

    // Method should be put in helper file. But specifics around this are very preference based. kept here for simplicity.
    public static function makeHttpCall($url) {
        $res = Http::get($url);
        if (!$res->successful()) throw new \Exception('Http call fail');

        return $res->json();
    }
}
