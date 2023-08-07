Created simple task manager application.

I used Breeze & Blade for the login and registration process, and to create the crud i used https://github.com/misterdebug/crud-generator-laravel, after doing it i made some tweaks for it to work as expected, (in the select configs for example), plus i filtered in the dashboard the tasks by the user_id, and on the report (assuming the user is some sort of super admin) the select should display all the users that are registered to show the report.

i also added the reports section to the navigation bar, and put the navigation bar in the previously generated CRUD operations.

on the report i added a simple ajax request to bring the information and created a search method on the reportsController.


--------------------


    i forgot to add the file to the table but i guess it shoulnt be difficult to add
    after putting it into the migration:

    {!! Form::open(['route' => 'upload', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        {!! Form::file('file') !!}
        {!! Form::submit('Upload File') !!}
    {!! Form::close() !!}

    and to store it, should be something like this in the controller:

    $file = $request->file('file');
    $validatedData = $request->validate([
        'file' => 'required|mimes:jpeg,png,pdf|max:2048', // Example validation rules
    ]);
    $path = $file->store('files');


--------------------

just wanted to finish it on time.

Before running migrations, make sure you have set up your database configuration properly in the .env file located at the root of your Laravel project. Open the .env file and provide the necessary database connection details, such as DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD.

instructions to make it work:

git clone git@github.com:alfredogon82/big-holding.git
composer require laravel/breeze --dev
php artisan breeze:install
select -> Blade, no, phpunit options
npm install
npm run dev

php artisan migrate


Alfredo Gonzàlez

“When one sleeps on the floor one need not worry about falling out of bed.”


