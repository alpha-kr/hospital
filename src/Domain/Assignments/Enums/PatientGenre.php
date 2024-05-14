<?php

namespace Domain\Assignments\Enums;

enum PatientGenre: string
{
    case MA = 'M';
    case FE = 'F';

    public function getLabel(): string
    {
        return match ($this) {
            self::MA => 'Masculino',
            self::FE => 'Feminino',
        };
    }

    public static function getValues(): array
    {
        return array_map(fn($genre) => $genre->value, self::cases());
    }
}
