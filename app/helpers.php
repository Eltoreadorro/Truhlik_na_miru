<?php
if (!function_exists('getContrastColor')) {
    function getContrastColor($hexColor)
    {
        // Удаляем # если есть
        $hexColor = str_replace('#', '', $hexColor);

        // Конвертируем в RGB
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));

        // Рассчитываем яркость
        $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;

        // Возвращаем черный или белый в зависимости от яркости фона
        return $brightness > 128 ? 'black' : 'white';
    }
}
