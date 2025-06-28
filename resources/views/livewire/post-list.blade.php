<div id="posts" class=" px-3 lg:px-7 py-6">
  <div class="flex justify-between items-center border-b border-gray-100">
    <div class="flex text-xl font-thin text-gray-900 gap-x-2 items-center">
      @if ($this->activeCategory || $this->search)
        <dfn title="remove filters">
          <button
            class="text-red-800 bg-red-100 rounded px-1 hover:bg-red-200 hover:text-red-900 active:bg-red-100 active:text-red-950"
            wire:click="resetSearch()">&#10005;</button>
        </dfn>
      @endif
      @if ($this->activeCategory)
        Topic:
        <x-posts.category-badge :category="$this->activeCategory" />
      @endif
      @if ($this->search)
        Search Results for:
        <span class="text-black font-bold">{{ $this->search }}</span>
      @endif
    </div>
    <div id="filter-selector" class="flex items-center space-x-4 font-light ">
      <div class="flex items-center space-x-2 border-e-2 p-5 border-gray-300">
        <x-label for="popularbtn" value="Popular" />
        <x-checkbox id="popularbtn" wire:model.live="popular" />
      </div>
      <button class="{{ $sort === 'desc' ? 'text-gray-900 border-b border-gray-700' : 'text-gray-500' }} py-4"
        wire:click="toggleSort('desc')">Latest</button>

      <button class="{{ $sort === 'asc' ? 'text-gray-900 border-b border-gray-700' : 'text-gray-500' }} py-4"
        wire:click="toggleSort('asc')">Oldest</button>
    </div>
  </div>
  <div class="py-4">
    @foreach ($this->posts as $post)
      <div wire:key="post-item-{{ $post->id }}">
        <x-posts.post-item :post="$post" />
      </div>
    @endforeach
  </div>
  <div class="my-2">
    {{ $this->posts->onEachSide(3)->links() }}
  </div>
</div>
