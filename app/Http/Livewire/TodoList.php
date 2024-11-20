<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Todo;
use App\Events\TodoCreated;

class TodoList extends Component
{
    public $content;
    public $todos = [];

    //#[On['echo:add, ']]
    public function mount()
    {
        $this->todos = Todo::all(); // Load existing todos
    }

    public function createTodo()
    {
        $this->validate([
            'content' => 'required|string|max:255',
        ]);

        $todo = Todo::create(['content' => $this->content]);

        broadcast(new TodoCreated($todo)); // Broadcast the event

        $this->todos->prepend($todo); // Update the list on the page
        $this->content = ''; // Clear the input
    }

    public function render()
    {
        return view('livewire.todo-list')->layout('layouts.app'); 
    }
    
    public function todoAdded($todo)
    {
        $this->todos->prepend($todo); // Add the new to-do item to the list
    }

}
