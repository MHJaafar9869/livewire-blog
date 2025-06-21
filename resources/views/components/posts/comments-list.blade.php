@props(['comment'])

<div class="comment [&:not(:last-child)]:border-b border-gray-100 py-5">
  <div class="user-meta flex mb-4 text-sm items-center">
    <x-posts.author :author="$comment->user" size="sm" />
    &middot;
    <span class="text-gray-500 ms-1">{{ $comment->created_at->diffForHumans() }}</span>
  </div>
  <div class="text-justify text-gray-700 text-sm">
    {{ $comment->comment }}
  </div>
</div>
