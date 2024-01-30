<?php

namespace App\Service;

class ServiceQuestion
{
    function Take10Question($allQuestions): array
    {
        $randomKeys = array_rand($allQuestions, min(10, count($allQuestions)));

        $randomKeys = is_array($randomKeys) ? $randomKeys : [$randomKeys];

        $randomQuestions = [];
        foreach ($randomKeys as $key) {
            $randomQuestions[] = $allQuestions[$key];
        }
        return $randomQuestions;

    }

}