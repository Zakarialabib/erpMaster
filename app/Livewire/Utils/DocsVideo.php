<?php

declare(strict_types=1);

namespace App\Livewire\Utils;

use Livewire\Component;

class DocsVideo extends Component
{
    public $content;

    public function mount()
    {
        // Each part of the content with a duration (in frames)
        $this->content = [
            $this->createSection('Introduction text...'),
            $this->createSection('Self-Learning Journey text...'),
            $this->createSection('Web and Digital Marketing text...'),
            $this->createSection('Integrated Knowledge text...'),
            $this->createSection('Development and Laravel Specialization text...'),
            $this->createSection('Conclusion and Thanks text...'),
            $this->createSection('Multi-Faceted Knowledge text...'),
            $this->createSection('Development Expertise text...'),
            $this->createSection('Continuous Improvement text...'),
            $this->createSection('Gratitude text...'),
        ];
    }

    private function createSection($text)
    {
        return [
            'text'             => $text,
            'durationInFrames' => 150, // 5 seconds at 30 frames per second
            'backgroundColor'  => $this->randomBackgroundColor(),
        ];
    }

    private function randomBackgroundColor()
    {
        $colors = ['#f0f', '#0ff', '#f00', '#0f0', '#00f']; // Add more colors if needed

        return $colors[array_rand($colors)];
    }

    public function render()
    {
        return view('livewire.utils.docs-video');
    }
}
