<?php
/*
* 
*Author Dalila HENNi
*
*/

namespace App\Service;

class CalendarService
{
    /*
    * Returns days name
    */
    public static function daysName()
    {
        $daysName = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        return $daysName;
    }

    /*
    * Determine how many days there are in the month
    */
    public static function countDays($currentMonth)
    {
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

        // Détermination du nombre de jours dans le mois
        $nbDays = 0;
        $longerMonths = ['janvier', 'mars', 'mai', 'juillet', 'aout', 'octobre', 'décembre'];
        $shorterMonths = ['septembre', 'novembre', 'avril', 'juin'];
        $yearNow = date('Y');

        if (in_array($currentMonth, $longerMonths)) {
            $nbDays = 31;
        }

        if (in_array($currentMonth, $shorterMonths)) {
            $nbDays = 30;
        }

        if ($currentMonth === 'Fevrier') {
            if (date("L", mktime(0, 0, 0, 1, 1, date('Y'))) == 1) {
                $nbDays = 29;
            }
            if (!date("L", mktime(0, 0, 0, 1, 1, date('Y'))) == 1) {
                $nbDays = 28;
            }
        }
        return $nbDays;
    }

    public function displayMonthlyCalendar($currentMonth)
    {
        $days = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
        $daysName =  self::daysName();
        $nbDaysInMonth = self::countDays($currentMonth);

        echo "<table>";
        foreach ($daysName as $day) {
            echo "<tr>";
            echo "<td>" . $day . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<table>";
        foreach ($days as $day) {
            echo "<tr>";
            echo "<td>" . $day . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}
