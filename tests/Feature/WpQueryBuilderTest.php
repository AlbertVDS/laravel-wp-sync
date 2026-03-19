<?php

use Illuminate\Support\Facades\Http;
use Albertvds\WpSync\WpFacade as Wp;

it('fetches posts with where parameters', function () {
    Http::fake([
        '*/wp/v2/posts*' => Http::response([
            ['id' => 1, 'title' => ['rendered' => 'Hello'], 'content' => ['rendered' => ''], 'excerpt' => ['rendered' => ''], 'slug' => 'hello', 'status' => 'publish', 'date' => '2024-01-01', 'link' => 'https://example.com/hello'],
        ]),
    ]);

    $posts = Wp::posts()->where('status', 'publish')->get();

    expect($posts)->toHaveCount(1);
});
