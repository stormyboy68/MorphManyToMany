# Features

This package is about assigning **models of relation Morph to manny** to another models in **Laravel**.\
and all models and migrations and facades another things you need all of them you need it build 
The type of relationship between tables is morphedByMany-morphToMany,\
but depending on your preference in using the command,\
it can be used like morphTo-morphMany morph relationships.

![][rel]

## main question why we require this package :
There is no need to define relationships anymore,
and it is enough to Add the necessary Trait **Has+yourModel** (like this => hasStatus) and this Trait **MTMcm**
in the models to which the status is applied.
### Quick Start <br>

1. #### Installation:
    ````clickhouse
    composer require asb/morphtomany
    ````
2. #### Run the migrations:<br>
    ````clickhouse
    php artisan migrate
    ````
3. #### Add the necessary Trait to your model:<br>
````php
    // The model requires these trait.
    use HasStatus; //has+yourModelName
    use MTMcm;
````
4. #### Using:<br>
+ ###### Get all the Models that have this Status.<br>
  ````php
  getModelsHave(string $MTMmodel)
  ````
+ ###### Get all the Statuses of Model.
  ````php
  getStatuses(Model $model)
  ````
+ ###### Check The model has this Status.
  ````php
   >   hasStatuses(Model $model,string $MTMmodel)
  ````
+ ###### it assigns a Status to the Model.
  ````php
   >   assignStatus(Model $model,string $MTMmodel)
  ````
+ ###### it adds a Status to the Model.
  ````php
   >   addStatus(Model $model,string $MTMmodel)
  ````
  + ###### it updates a Status from the Model and replace by new or a status that exists.
  ````php
   >   updateStatus(Model $model,string $MTMmodel,string $newMTMmodel)
  ````
  + ###### it removes a status from the model.
  ````php
   >   removeStatus(Model $model,string $MTMmodel)
  ````
  + ###### it removes all statuses from the model.
  ````php
   >   removeAllStatus(Model $model)
  ````
5. #### Using Status Model:

   > + ##### it Creates a Status.
    ````php    
   >       createStatusModel(string $MTMmodel)
    ````
   > + ##### it gets all Status.
    ````php    
   >       getAllStatusModel(bool $onlyTrashed=false)
    ````
   > + ##### it gets a Status by title.
    ````php
   >       getStatusModel(string $MTMmodel)
    ````
   > + ##### it updates a Status by title and replace by new_title.
    ````php 
   >       updateStatusModel(string $MTMmodel, string $update_status):
    ````
   > + ##### it removes a Status by title or id and removing the Status and from all Models.
    ````php
   >       removeStatusModel(string $MTMmodel) 
    ````   
   > + ##### it restore a Status by title or id.
    ````php
   >       removeStatusModel(string $MTMmodel) 
    ````


[rel]:./img/rel.png  "relationship image"
