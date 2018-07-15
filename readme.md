# Installation

The project contains standard installation of Laravel, however you'll need to install / update dependancies via composer:

```
composer install && composer update
```

As the installation runs on SQLite database contained within a file, make sure that your Apache supports it. You'll also need to create the file itself by running

Linux
```
touch database\database.sqlite
```

or

Windows
```
copy nul database\database.sqlite
```

Run migrations to populate the database structure, by running:

```
php artisan migrate
```

Run seeder to populate the database with data, by running:

```
php artisan db:seed
```

---

# Description

With the data provided I've decided to split the structure into a number of objects:
- Recipe
- RecipeBoxType (given recipe can be included in different box types)
- RecipeDietType (given recipe can be classified as of multiple diet types)
- RecipeCuisine (given recipe can belong to multiple cuisines)
- RecipeEquipment (given recipe might require multiple equipments to create)
- Slug (a url under which given content is reachable, not restricted to Recipes)
- Review (a review of given content)

To fulfill the criteria of the test, I've created an API with a number of endpoints, each tasked with performing different operations:
- GET:/recipes - displays paginated view of all recipes; can be filtered by passing ?recipe_cuisine_id=x as parameter
- GET:/recipes/[id] - displays view of one recipe, determined by id
- POST:/recipes/[id]/rate - creates a rating of given recipe; rating attribute is required within POST body
- POST:/recipes - creates a recipe; title and slug attributes are required within POST body; as Recipe <-> RecipeFoo relationships are one to many, RecipeFoo ids are passed within an array - e.g. to create a Recipe with both asian and italian cuisine one would pass {recipe_cuisine_id: [1,2]}
- PUT:/recipes/[id] - updates a recipe; Recipe <-> RecipeFoo relationships are overridden with provided data - e.g. if given Recipe has {recipe_cuisine_id: [1]}, passing {recipe_cuisine_id: [2]} will replace existing attribute; missing attributes do not update - e.g. {title: 'foo', 'slug': 'bar'} updated with {title: 'xyz'} will result in {title: 'xyz', 'slug': 'bar'}
- DELETE:/recipes/[id] - deletes a recipe

Other models also have limited CRUD endpoints; each models functionality is contained within a models Controller.
To keep the naming conventions consistent I've introduced namespace, which is used to group functionalities of given model and is derived from class name (for the purpose of nice URLs, it's using kebab-case)

As Laravel grants the ability of loading models per route (/{foo}/, handled by FooController@store with signature `public function store(Foo $foo)`), but PHP prevents inheriting methods with different signature (for `public function store(Foo $foo)` inheriting from `public function store(Bar $bar)`) I couldn't abstract similar CRUD operations; I've decided however to create a Trait that will allow me to chain CRUD operations on controller classes - CrudApiControllerTrait e.g. both `store(Foo $foo)` and `store(Bar $bar)` will take advantage of Laravel model loading, while chaining through store method of Trait. As such, CRUD operations can now be applied to all models without code duplication. This approach also allows to take advantage of dependancy injection of Request classes, allowing for decoupling validations from operations.

I've decided to use two approaches to manage the store/update/delete operations on classes:
- Service approach used for Recipe, where extended functionality is required (saving a Recipe requires saving a Slug and other objects)
- Model approach used for RecipeBoxType, where extended functionality is not required (due to simplicity of model in question)

Still, if RecipeBoxType models functionality extends, it's easily enough to provide given functionality by creating a service that handles its operations.
I've also decided to put in RecipeBoxType CRUD routes to explore if there're no issues with these parts of code.

Generally I've tried to use services wherever possible to take advantage of loose coupling and dependancy injection provided by Laravel.

For the JSON responses, I've decided to use Transformers that are bundled with Laravel, that allow customization, up to a single request (Transformer does allow to look at Request object and customize output dependant upon the headers); it can also be customized based upon user within given request.

I think the approaches I've used make the application easily extendable - adding management of other models should be as simple as:
- creating routes
- creating controller that uses CrudApiControllerTrait, with model extending Base class
- creating service if extended functionality is required
- if index/show output is required - creating transformer

# Additions

- unit tests
- integration tests