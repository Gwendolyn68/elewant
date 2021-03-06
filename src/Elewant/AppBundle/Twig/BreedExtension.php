<?php

declare(strict_types=1);

namespace Elewant\AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class BreedExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('breed_color', [$this, 'breedColorFilter']),
            new TwigFilter('breed_size', [$this, 'breedSizeFilter']),
            new TwigFilter('breed_name', [$this, 'breedNameFilter']),
        ];
    }

    public function breedColorFilter(string $breed): string
    {
        $color = explode('_', $breed);
        $color = array_shift($color);
        $color = strtolower($color);
        $color = 'elephpant-' . $color;

        return $color;
    }

    public function breedSizeFilter(string $breed): string
    {
        $size = explode('_', $breed);
        $size = array_pop($size);
        $size = strtolower($size);
        $size = 'elephpant-' . $size;

        return $size;
    }

    public function breedNameFilter(string $breed): string
    {
        $name = explode('_', $breed);
        $name = array_slice($name, 1, -1);
        $name = implode('-', $name);
        $name = strtolower($name);
        $name = 'elephpant-' . $name;

        return $name;
    }
}
