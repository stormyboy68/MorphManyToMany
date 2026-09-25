# MorphManyToMany

Maybe for you, implementing a series of models and repetitive relationships is boring,
time-consuming and annoying, and you will have to copy your previous codes or refactor them,
which will be a waste of time.
This package provides you with a module to automatically files need (Model, Migrations, ...) add
Morph many-to-many relations to your project along with commonly used basic commands.
which minimizes the trial and error operation for you.

![][rel]

## how to use this package :

There is no need to define relationships anymore,
and it is enough to Add the necessary Trait **_Has+yourModel_** (like this => hasStatus)
in the models to which the Model is applied.

## Requirements

**The package requires PHP 8.0 or higher. The Laravel package also requires Laravel 10 or higher.**

---

### Quick Start

## 1. Installation:

```bash
composer require asb/morphmtm
```
## 2. Publish the package's configuration file:
bash
php artisan vendor:publish --tag=morph-mtm-config
## 3. Autoloading
By default, the module classes are not loaded automatically. You can autoload your modules using psr-4. For example:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Rack\\": "Rack/"
    }
}
```
    Tip: don't forget to run composer dump-autoload afterward.

## 4. Build module:
```bash
php artisan mtm:build <Modulename>
```
## Example:

```bash
php artisan mtm:build category
```
In continue, the command will ask you a few questions. You can confirm the default value by pressing the enter key:

```text
What is the Model Name [Category]:
>[enter]
What is the Model Plural Name [categories]:
>[enter]
What is the Model Relation Name [categoryable]:
>categorizable   // here we changed the default relation name.
```
Options:

```Option	Description
--force	Recreate module files even if they already exist (migrations are safe)
--uuid	Create the module with UUID primary keys
--migrate	Run migrations automatically after build
```
Tip: If you need to remove a module:

```bash
php artisan mtm:remove <ModuleName>
```
## 5. Add the necessary Trait to your model:
php
// The class model requires this trait.
use HasCategory; // Has + yourModelName
## 6. Using CRUD of Model in Module
## 6.1 Creating a new record (uniqueness safe) ⭐
⚠️ Important: Always use mtmCreate() instead of create() to respect uniqueness rules.

php
use Rack\Morph\MTM\Category\App\Models\Category;

// ✅ Correct — respects uniqueness
$cat = Category::mtmCreate('Electronics', Post::class);

// ❌ Wrong — bypasses uniqueness check
$cat = Category::create(['title' => 'Electronics', 'model_type' => Post::class]);
## 6.2 Updating a record
```php
$cat = Category::mtmUpdate('New Title');
```
## 6.3 Restoring a soft-deleted record
```php
$cat = Category::withTrashed()->find(1);
$cat->mtmRestore();
```
## 6.4 Checking existence
```php
Category::mtmExists('Electronics', Post::class); // bool
```
## 7. Using Facade (MTM + ModelName)
All facade methods are callable statically with the format MTM+modelName:

```php
use Rack\Morph\MTM\Category\Facades\MTMCategory;
```
## 7.1 Relations
```Method	Description
getModelsHave(string|int $mtmModel)	Get all models that have this Category
getCategories(Model $model, bool|string $pluck = false)	Get all Categories of a Model
hasCategories(Model $model, string|int $mtmModel)	Check if the model has this Category
assignCategory(Model $model, string|int $mtmModel)	Assign a Category (replaces all)
addCategory(Model $model, string|int $mtmModel)	Add a Category (without removing others)
updateCategory(Model $model, string|int $mtmModel, string|int $newMtmModel)	Replace one Category with another
removeCategory(Model $model, string|int $mtmModel)	Remove a Category
removeAllCategory(Model $model)	Remove all Categories from the model
```
## 7.2 CRUD
```Method	Description
createCategoryModel(string $title, ?string $model_type = null)	Create a new Category (uniqueness safe)
getAllCategoryModel(bool $onlyTrashed = false)	Get all Categories (or only trashed ones)
getCategoryModel(string|int $mtmModel)	Get a Category by Title or ID
updateCategoryModel(string|int $mtmModel, string $newTitle)	Update a Category
removeCategoryModel(string|int $mtmModel)	Soft-delete a Category
restoreCategoryModel(string|int $mtmModel)	Restore a soft-deleted Category
```
## 8. Uniqueness Strategies ⭐ NEW
The package supports three uniqueness strategies, configured via MTM_UNIQUE in your .env:

```Strategy	Behavior	Use case
none	No uniqueness check (duplicates allowed)	When you want multiple rows with the same title
check	Application-level check before create/update/restore (default)	Single-server, fast, race-prone
lock	check + cache lock (race-safe)	Multi-server, production-ready
Set in .env:
```
.env
```text
MTM_UNIQUE=lock
```
    Or in config/mtm.php:

```php
'unique' => env('MTM_UNIQUE', 'check'),

'lock' => [
    'timeout' => 10,   // seconds
    'wait'    => 3,    // seconds to wait for lock
    'prefix'  => 'mtm:unique:',
],
```
⚠️ Cache Lock Requirements
If you use MTM_UNIQUE=lock, your default cache driver must support atomic locks:

Driver	Atomic?
redis	✅
memcached	✅
database	✅
dynamodb	✅
file	⚠️ (single-server only)
array	⚠️ (single-process only)
Do NOT use file or array in production with lock.

Handling Duplicate Exceptions
```php
use ASB\MorphMTM\Exceptions\DuplicateMtmModelException;

try {
    Category::mtmCreate('Electronics', Post::class);
} catch (DuplicateMtmModelException $e) {
    return response()->json(['error' => $e->getMessage()], 422);
}
```
## 9. Upgrading from v1.x
In v1.x, uniqueness was enforced by a database-level unique index on
(title, model_type). This broke SoftDeletes — you couldn't recreate a record
with the same title after soft-deleting it.

In v2.x, uniqueness is enforced at the application layer instead.

After upgrading, run:
bash
php artisan mtm:upgrade-unique
Preview first:

```bash
php artisan mtm:upgrade-unique --dry-run
```
This will:

Find all your MTM tables (tables containing a model_type column)

Drop the old unique indexes

Add regular indexes on (title, model_type, deleted_at) for performance

>Then set your strategy:
env
MTM_UNIQUE=check   # or 'lock' if you have Redis
## 10. API Reference (full)
Relations (Facade + Command)
```php
getModelsHave(string|int $MTMmodel)
getCategories(Model $model, bool|string $pluck = false)
hasCategories(Model $model, string|int $MTMmodel)
assignCategory(Model $model, string|int $MTMmodel)
addCategory(Model $model, string|int $MTMmodel)
updateCategory(Model $model, string|int $MTMmodel, string|int $newMTMmodel)
removeCategory(Model $model, string|int $MTMmodel)
removeAllCategory(Model $model)
```
CRUD (Facade + Command)
```php
createCategoryModel(string $title, ?string $model_type = null): Category
getAllCategoryModel(bool $onlyTrashed = false): Collection
getCategoryModel(string|int $MTMmodel): ?Category
updateCategoryModel(string|int $MTMmodel, string $newTitle): Category
removeCategoryModel(string|int $MTMmodel): bool
restoreCategoryModel(string|int $MTMmodel): Category
```
Direct Model API (trait HasMtmModel)
```php
Category::mtmCreate(string $title, ?string $modelType = null): static
Category::mtmExists(string $title, ?string $modelType = null): bool
$category->mtmUpdate(string $newTitle): static
$category->mtmRestore(): static
```
11. Common Examples
    Example 1: Create a Category and assign to a Post
```php
use Rack\Morph\MTM\Category\Facades\MTMCategory;

$cat = MTMCategory::createCategoryModel('Tech', Post::class);
MTMCategory::assignCategory($post, 'Tech');
Example 2: Safe create with try/catch
php
use ASB\MorphMTM\Exceptions\DuplicateMtmModelException;

try {
    $cat = MTMCategory::createCategoryModel('Tech', Post::class);
} catch (DuplicateMtmModelException $e) {
    $cat = MTMCategory::getCategoryModel('Tech');
}
Example 3: Restore a soft-deleted category
php
$cat = MTMCategory::restoreCategoryModel('Tech');
Example 4: All categories of a model, plucked by ID
php
$ids = MTMCategory::getCategories($post, 'id'); // [1, 2, 3]
```
