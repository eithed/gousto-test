<?php

use Illuminate\Database\Seeder;

use App\Recipe;
use App\RecipeBoxType;
use App\RecipeCuisine;
use App\RecipeDietType;
use App\RecipeEquipment;
use App\Slug;

use League\Csv\Reader;
use League\Csv\Statement;

use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reader = Reader::createFromPath(base_path().'/database/seeds/recipe-data.csv', 'r');
        $reader->setHeaderOffset(0);

        $records = (new Statement())->process($reader);

        foreach($records as $record)
        {
            $recipe = Recipe::find($record['id']);

            if ($recipe)
            {
                continue;
            }

            $recipeBoxType = RecipeBoxType::where('title', $record['box_type'])->first();
            if (!$recipeBoxType)
            {
                $recipeBoxType = new RecipeBoxType([
                    'title' => $record['box_type']
                ]);
                $recipeBoxType->save();
            }
            unset($record['box_type']);


            $recipeDietType = RecipeDietType::where('title', $record['recipe_diet_type_id'])->first();
            if (!$recipeDietType)
            {
                $recipeDietType = new RecipeDietType([
                    'title' => $record['recipe_diet_type_id']
                ]);
                $recipeDietType->save();
            }
            unset($record['recipe_diet_type_id']);

            $recipeEquipment = RecipeEquipment::where('title', $record['equipment_needed'])->first();
            if (!$recipeEquipment)
            {
                $recipeEquipment = new RecipeEquipment([
                    'title' => $record['equipment_needed']
                ]);
                $recipeEquipment->save();
            }
            unset($record['equipment_needed']);

            $recipeCuisine = RecipeCuisine::where('title', $record['recipe_cuisine'])->first();
            if (!$recipeCuisine)
            {
                $recipeCuisine = new RecipeCuisine([
                    'title' => $record['recipe_cuisine']
                ]);
                $recipeCuisine->save();
            }
            unset($record['recipe_cuisine']);

            $record['created_at'] = Carbon::createFromFormat('d/m/Y H:i:s', $record['created_at']);
            $record['updated_at'] = Carbon::createFromFormat('d/m/Y H:i:s', $record['updated_at']);

            $slug = $record['slug'];
            unset($record['slug']);

            $recipe = new Recipe($record);
            $recipe->save();

            $recipe->recipeBoxTypes()->attach($recipeBoxType);
            $recipe->recipeDietTypes()->attach($recipeDietType);
            $recipe->recipeEquipments()->attach($recipeEquipment);
            $recipe->recipeCuisines()->attach($recipeCuisine);

            $slug = new Slug([
                'item_type' => Recipe::class,
                'item_id' => $recipe->id,
                'title' => $slug
            ]);
        }
    }
}
