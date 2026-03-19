<?php

namespace Albertvds\WpSync\DTOs;

class WpPost
{
    public function __construct(
        public readonly int    $id,
        public readonly string $title,
        public readonly string $content,
        public readonly string $excerpt,
        public readonly string $slug,
        public readonly string $status,
        public readonly string $date,
        public readonly string $link,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            id:      $data['id'],
            title:   $data['title']['rendered'] ?? '',
            content: $data['content']['rendered'] ?? '',
            excerpt: $data['excerpt']['rendered'] ?? '',
            slug:    $data['slug'],
            status:  $data['status'],
            date:    $data['date'],
            link:    $data['link'],
        );
    }
}
