# FoxholeProject-


Okay welcome in.

First thing we can do is update our database to get started..

php artisan tinker

Artisan::call('foxhole:update');

These two commands will update our database by pulling from the foxhole api.




Now we have lots of views, 

Things in resources/views/livewire is HTML and a bit of PHP for the front end

They use things in app/Livewire as the backend

We also have things in resources/views/layouts to be a base layout that our pages will utilize

Routes is what we will use to add pages in and then code in the transitions in there.