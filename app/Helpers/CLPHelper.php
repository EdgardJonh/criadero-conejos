<?php

namespace App\Helpers;

class CLPHelper
{
    /**
     * Formatea un precio en pesos chilenos
     *
     * @param int $precio Precio en centavos
     * @return string Precio formateado
     */
    public static function format($precio)
    {
        return '$' . number_format($precio, 0, ',', '.');
    }

    /**
     * Formatea un precio en pesos chilenos con texto
     *
     * @param int $precio Precio en centavos
     * @return string Precio formateado con texto
     */
    public static function formatWithText($precio)
    {
        return self::format($precio) . ' CLP';
    }

    /**
     * Convierte un string de precio a entero (elimina símbolos y comas)
     *
     * @param string $precioString
     * @return int
     */
    public static function parse($precioString)
    {
        // Eliminar símbolos de moneda, puntos y comas
        $clean = preg_replace('/[^\d]/', '', $precioString);
        return (int) $clean;
    }
}
