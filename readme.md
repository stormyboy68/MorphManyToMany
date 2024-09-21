# Feature

Maybe for you, implementing a series of models and repetitive relationships is boring,
time-consuming and annoying, and you will have to copy your previous codes or refactor them, 
which will be a waste of time.\
This package provides you with a module to automatically files need (Model,Migrations,...) add Morph many-to-many relations to 
your project along with commonly used basic commands.\
which minimizes the trial and error operation for you.

![][rel]

## how to use this package :
There is no need to define relationships anymore,
and it is enough to Add the necessary Trait **_Has+yourModel_** (like this => hasStatus) and this Trait **MTMcm**
in the models to which the Model is applied.
## Requirements
**The package requires PHP 8 or higher. The Laravel package also requires Laravel 10 or higher.**
### Quick Start <br>


1. #### Installation:
    ````clickhouse
    composer require asb/morphmtm
    ```` 
2. #### publish the package's configuration file by running:
    ````clickhouse
    php artisan vendor:publish --tag=morph-mtm-config
    ````
3. #### Autoloading
    By default, the module classes are not loaded automatically. You can autoload your modules using **_**psr-4**_**. For example:

       "autoload": {
           "psr-4": {
               "App\\": "app/",
               "Rack\\": "Rack/"
           }
       }

    **Tip: don't forget to run composer dump-autoload afterward**\
`In an example to create a category module, I will explain how to use it.`
4. #### build module:<br>
    `php artisan mtm:build *Modulename*`

    ````php
    php artisan mtm:build category
    ````
       in continue the command, you will be asked to named,
       of course, you can confirm and pass the default value by pressed the enter key,
       but some default words may not be to your liking.`
    ````php
    What is the Model Name [Category]:
    >[enter]
     What is the Model Plural Name [categories]:
    >[enter]
    What is the Model Relation Name [categoryable]:
    >categorizable //Here the default name of the relationship is not good, and we changed it.
    ````

    **Tip: If You need to remove a module you can use this command** \
    <strong  style="font-size: 13px;line-height: 2;vertical-align: middle;background: #f0f2f1;color: #f4645f;padding: 1px 5px;border-radius: 3px;margin:0px 15px;">
    php artisan mtm:remove *ModuleName*
    </strong >

5. #### Add the necessary Trait to your model:<br>
    ````php  
    //The class model requires these trait.
    use HasCategory; //has+yourModelName
    use MTMcm;
    ````
6. #### Use predefined functions:<hr>
+ ###### it gets all the models that have Category.
  ````php
  getModelsHave(string $MTMmodel)
  ````
+ ###### it gets all the Categories of Model.
  ````php
  getCategories(Model $model)
  ````
+ ###### it checks the Model has this Category by Title or ID.
  ````php
  hasCategries(Model $model,string $MTMmodel)
  ````
+ ###### it assigns a Category to the Model by Title or ID.
  ````php
  assignCategory(Model $model,string $MTMmodel)
  ````
+ ###### it adds a Category to the Model by Title or ID.
  ````php
  addCategory(Model $model,string $MTMmodel)
  ````
  + ###### it updates a Category from the Model and replace by new Category Or a Category that exists.
  ````php
  updateCategory(Model $model,string $MTMmodel,string $newMTMmodel)
  ````
  + ###### it removes a Category from the model by Title or ID.
  ````php
  removeCategory(Model $model,string $MTMmodel)
  ````
  + ###### it removes all Categories from the model.
  ````php
  removeAllCategory(Model $model)
  ````
6. #### Using CRUD of Model in Module:

    + ##### it Creates a Category by a new Title.
    ````php    
    createCategoryModel(string $MTMmodel)
    ````
    + ##### it gets all of Category And if it is called with "true" parameter, it will get all the deleted Category.
    ````php    
    getAllCategoryModel(bool $onlyTrashed=false)
     ````
    + ##### it gets a Category by Title or ID.
    ````php
     getCategoryModel(string $MTMmodel)
    ````
    + ##### updates a Category by Title or ID and replace by a new Title
    ````php 
    updateCategoryModel(string $MTMmodel, string $update_Category):
    ````
    + ##### it removes a Category by Title or ID and removing the Category and from all Models.
    ````php
     removeCategoryModel(string $MTMmodel) 
    ````   
    + ##### it restored a Category by Title or ID.
    ````php
     removeCategoryModel(string $MTMmodel) 
    ````


[rel]:./img/rel.png  "relationship image"
