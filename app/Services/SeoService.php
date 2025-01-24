<?php

namespace App\Services;

class SeoService
{
    protected string $title = '';
    protected string $keywords = '';
    protected string $description = '';

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;
        return $this;
    }

    public function getKeywords(string $default = ''): string
    {
        return $this->keywords ? $this->keywords : $default;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(string $default = ''): string
    {
        return $this->description ? $this->description : $default;
    }
}
