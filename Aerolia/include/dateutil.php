<?php

    class DateUtil {


        public static function date_week_start ($year, $week) {
        
            // Se obtiene la fecha del inicio del a�o
            $yearstart = mktime(0, 0, 0, 1, 1, $year);
            
            // Luego el d�a de la semana en que empieza el a�o (1 = lunes)
            $day_yearstart = (int)date("N", $yearstart);
            
            // En base a una peque�a f�rmula se obtiene la fecha en la cual inicia la semana
            $fweekstart = mktime(0, 0, 0, 1, ((8 - $day_yearstart) % 7) + 1, $year);
            
            // Y a eso se le suma los segundos en una semana, multiplicados por la semanas
            $date_week_start = $fweekstart + (($week - 1) * 7 * 24 * 60 * 60);
            
            return date("Y-m-d", $date_week_start);
            
        }
 
 
    }

?>