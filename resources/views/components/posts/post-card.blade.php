@props(['post'])

<div {{ $attributes }}>
  <a href="{{ route('post.show', $post->slug) }}">
    <div>
      <img class="w-full rounded-xl" src="{{ $post->getThumbnailUrl() }}" alt="thumbnail">
    </div>
  </a>
  <div class="mt-3">
    <div class="flex items-center mb-2 gap-x-2">
      @if ($category = $post->categories->first())
        <x-posts.category-badge :$category />
      @endif
      <p class="text-gray-500 text-sm">{{ $post->published_at->diffForHumans() }}</p>
    </div>
    <a class="text-xl font-bold text-gray-900" href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>
  </div>
</div>
