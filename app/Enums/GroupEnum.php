<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Enum para grupos de usuário.
 *
 * @author Luiz Fernando <lufmalta@gmail.com>
 * @since 14/01/2025 
 * @version 1.0.0
 */
final class GroupEnum extends Enum {

    const ADMIN = 1;
    const ATTENDANT = 2;
    const LIBRARY_USER = 3;

    /**
     * Obtém os grupos.
     *
     * @return Collection $values
     */
    public static function get() {

        $values = collect([
            ['id' => static::ADMIN, 'name' => static::getName(static::ADMIN)],
            ['id' => static::ATTENDANT, 'name' => static::getName(static::ATTENDANT)],
            ['id' => static::LIBRARY_USER, 'name' => static::getName(static::LIBRARY_USER)],
        ]);

        return $values;

    }

    /**
     * Obtém o nome do grupo.
     *
     * @param [type] $id
     * @return String $name
     */
    public static function getName($id) {

        $name = null;

        if ($id == static::ADMIN) {
            $name = "Administrador";
        } else if ($id == static::ATTENDANT) {
            $name = "Atendente";
        } else if ($id == static::LIBRARY_USER) {
            $name = "Usuário Biblioteca";
        }

        return $name;

    }

}
