<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostComment;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class PostComments extends Component
{
  use WithPagination;

  #[Validate('required|string|max:250')]
  public $comment;
  public Post $post;

  public function postComment()
  {
    if (auth()->guest()) {
      return $this->redirect(route('login'), false);
    }

    $this->validate();

    PostComment::create([
      'user_id' => auth()->id(),
      'post_id' => $this->post->id,
      'comment' => $this->comment,
    ]);

    $this->reset('comment');
  }

  #[Computed()]
  public function comments()
  {
    return $this->post?->comments()->latest()->paginate(3);
  }

  public function render()
  {
    return view('livewire.post-comments');
  }
}
