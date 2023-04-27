<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker) //dependency injection
    {
        //la collection mi diventa un array normale con gli id delle categorie grazie a pluck()
        $types = Type::all()->pluck('id');
        $types[] = null;

        for($i = 0; $i < 40; $i++) {
            $project = new Project;
            $project->type_id = $faker->randomElement($types);
            $project->title = $faker->catchPhrase();
            $project->slug = Str::of($project->title)->slug('-');
            // $project->image= $faker->imageUrl(640, 480, 'animals', true);
            $project->text = $faker->paragraph(35);
            $project->save();
        }
    }
}