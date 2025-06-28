<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class PostList extends Component
{
  use WithPagination;

  #[Url()]
  public $sort = 'desc';

  #[Url()]
  public $search = '';

  #[Url()]
  public $category = '';

  #[Url()]
  public $popular = false;

  #[Url()]
  public $activeCategory = false;

  public function toggleSort($sort)
  {
    $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
  }

  #[On('search')]
  public function updatedSearch($search)
  {
    $this->search = $search;
    $this->resetPage();
  }

  public function resetSearch()
  {
    $this->search = '';
    $this->category = '';
    $this->resetPage();
  }

  #[Computed()]
  public function getPostsProperty()
  {
    return Post::published()
      ->with(['author', 'categories'])
      ->when($this->activeCategory, function ($query) {
        $query->withCategory($this->category);
      })
      ->when($this->popular, function ($query) {
        $query->popular();
      })
      ->search($this->search)
      ->orderBy('published_at', $this->sort)
      ->paginate(5);
  }

  #[Computed()]
  public function activeCategory()
  {
    if ($this->category === null || $this->category === '') {
      return;
    }

    return Category::where('slug', $this->category)->first();
  }

  public function render()
  {
    return view('livewire.post-list');
  }
}
