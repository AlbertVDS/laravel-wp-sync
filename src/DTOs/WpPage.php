<?php

namespace Albertvds\WpSync\DTOs;

class WpPage
{
    public function __construct(
        public readonly int    $id,
        public readonly string $title,
        public readonly string $content,
        public readonly string $slug,
        public readonly string $status,
        public readonly int    $menuOrder,
        public readonly string $link,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            id:        $data['id'],
            title:     $data['title']['rendered'] ?? '',
            content:   $data['content']['rendered'] ?? '',
            slug:      $data['slug'],
            status:    $data['status'],
            menuOrder: $data['menu_order'] ?? 0,
            link:      $data['link'],
        );
    }
}
