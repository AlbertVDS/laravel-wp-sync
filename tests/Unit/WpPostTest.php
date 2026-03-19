<?php

use Albertvds\WpSync\DTOs\WpPost;

it('maps api array to WpPost properties', function () {
    $post = WpPost::fromArray([
        'id'      => 1,
        'title'   => ['rendered' => 'Hello World'],
        'content' => ['rendered' => '<p>Content</p>'],
        'excerpt' => ['rendered' => 'Excerpt'],
        'slug'    => 'hello-world',
        'status'  => 'publish',
        'date'    => '2024-01-01T00:00:00',
        'link'    => 'https://example.com/hello-world',
    ]);

    expect($post->id)->toBe(1)
        ->and($post->title)->toBe('Hello World')
        ->and($post->slug)->toBe('hello-world')
        ->and($post->status)->toBe('publish');
});
