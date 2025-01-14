<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Enum para situações do livro.
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 13/01/2025 
 * @version 1.0.0
 */
final class BookSituationEnum extends Enum {

    const BORROWED = 1;
    const AVAILABLE = 2;

    /**
     * Obtém as situações do livro.
     *
     * @return Collection $values
     */
    public static function get() {

        $values = collect([
            ['id' => static::BORROWED, 'name' => static::getName(static::BORROWED)],
            ['id' => static::AVAILABLE, 'name' => static::getName(static::AVAILABLE)],
        ]);

        return $values;

    }

    /**
     * Obtém o nome da situação.
     *
     * @param [type] $id
     * @return String $name
     */
    public static function getName($id) {

        $name = null;

        if ($id == static::BORROWED) {
            $name = "Emprestado";
        } else if ($id == static::AVAILABLE) {
            $name = "Disponível";
        }

        return $name;

    }

}
