<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Enum de status de empréstimo de livros.
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
final class LendingBookStatusEnum extends Enum {

    const RENTED = 1;
    const DELAYED = 2;
    const RETURNED = 3;

    /**
     * Obtém os status.
     *
     * @return Collection $values
     */
    public static function get() {

        $values = collect([
            ['id' => static::RENTED, 'name' => static::getName(static::RENTED)],
            ['id' => static::DELAYED, 'name' => static::getName(static::DELAYED)],
            ['id' => static::RETURNED, 'name' => static::getName(static::RETURNED)],
        ]);

        return $values;

    }

    /**
     * Obtém o nome do status.
     *
     * @param [type] $id
     * @return String $name
     */
    public static function getName($id) {

        $name = null;

        if ($id == static::RENTED) {
            $name = "Emprestado";
        } else if ($id == static::DELAYED) {
            $name = "Atrasado";
        } else if ($id == static::RETURNED) {
            $name = "Devolvido";
        }

        return $name;

    }
    
}
