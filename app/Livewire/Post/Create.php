<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    

    public $media=[];
    public $description;

    public function save()
    {
        dd([
            $this->media,
            $this->description
        ]);
        // $this->validate([
        //     'description' => 'required|string|max:500',
        // ]);

        // TODO: Save the post to database using the Post model
        // auth()->user()->posts()->create([
        //     'description' => $this->description,
        // ]);

        session()->flash('message', 'Post created successfully!');
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.post.create');
    }
}