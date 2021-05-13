<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\TodoItems;
use App\Models\TodoTask;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        /*$todo = new Todo();
        $todo->user_id = 1;
        $todo->title = 'Project';
        $todo->description = 'Learn the basics of templating';
        $todo->created_at = Carbon::now()->addDays(-2);
        $todo->todo_date = Carbon::now()->addDays(-1);
        $todo->save();

        $todoItem = new TodoTask();
        $todoItem->title = 'Enable dark mood.';
        $todoItem->todo_id = $todo->id;
        $todoItem->status = 'completed';
        $todoItem->save();

        $todo = new Todo();
        $todo->user_id = 1;
        $todo->title = 'Django';
        $todo->description = 'Learn the basics of templating';
        $todo->created_at = Carbon::now()->addDays(-2);
        $todo->todo_date = Carbon::now()->addDays(-2);
        $todo->save();

        $todoItem = new TodoTask();
        $todoItem->title = 'Create User Login';
        $todoItem->todo_id = $todo->id;
        $todoItem->save();




        $todo = new Todo();
        $todo->user_id = 1;
        $todo->title = 'laravel';
        $todo->description = 'learn the basics of templating';
        $todo->created_at = Carbon::now()->addDays(-1);
        $todo->todo_date = Carbon::now()->addDays(-1);
        $todo->save();

        $todoItem = new TodoTask();
        $todoItem->title = 'Enable dark mood.';
        $todoItem->todo_id = $todo->id;
        $todoItem->status = 'completed';
        $todoItem->save();

        $todoItem2 = new TodoTask();
        $todoItem2->title = 'Add items to todo list. Add items to todo list. Add items to todo list.';
        $todoItem2->todo_id = $todo->id;
        $todoItem2->status = 'doing';
        $todoItem2->save();

        $todoItem3 = new TodoTask();
        $todoItem3->title = 'Create a new Laravel project which will contain games. This should be done in 3 months. This a a test todo list item.';
        $todoItem3->todo_id = $todo->id;
        $todoItem3->save();

        $todo = new Todo();
        $todo->user_id = 1;
        $todo->title = 'C#';
        $todo->description = 'Do Assignment';
        $todo->created_at = Carbon::now()->addDays(-1);
        $todo->todo_date = Carbon::now()->addDays(1);
        $todo->save();

        $todoItem = new TodoTask();
        $todoItem->title = 'Do the c# assignment so that you can earn some money and buy a new laptop.';
        $todoItem->todo_id = $todo->id;
        $todoItem->save();*/
    }
}
