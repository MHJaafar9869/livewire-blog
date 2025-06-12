<div id="posts" class=" px-3 lg:px-7 py-6">
    <div class="flex justify-between items-center border-b border-gray-100">
        <div class="text-xl font-semibold text-gray-900">
            @if ($this->search)
                Search Results for:
                <span class="text-yellow-600 border-b border-yellow-600">{{ $this->search }}</span>
                </h3>
            @endif
        </div>
        <div id="filter-selector" class="flex items-center space-x-4 font-light ">
            <button class="{{ $sort === 'desc' ? 'text-gray-900 border-b border-gray-700' : 'text-gray-500' }} py-4"
                wire:click="toggleSort('desc')">Latest</button>

            <button class="{{ $sort === 'asc' ? 'text-gray-900 border-b border-gray-700' : 'text-gray-500' }} py-4"
                wire:click="toggleSort('asc')">Oldest</button>

        </div>
    </div>
    <div class="py-4">
        @foreach ($this->posts as $post)
            <x-posts.post-item :post="$post" />
        @endforeach
    </div>
    <div class="my-2">
        {{ $this->posts->onEachSide(3)->links() }}
    </div>
</div>
