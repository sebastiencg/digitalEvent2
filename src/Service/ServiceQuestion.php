<?php

namespace App\Service;

use App\Entity\Question;

class ServiceQuestion
{
    function getRandomQuestionsByCategory($categories): array
    {
        $randomQuestions = [];

        foreach ($categories as $category) {
            $questionsByCategory = $category->getQuestions()->getValues();
            foreach ($this->getUniqueTypes($questionsByCategory) as $type) {
                $selectedQuestions = $this->takeOneQuestionByType($questionsByCategory, $type);
                $randomQuestions[] = $selectedQuestions;
            }
        }
        return $randomQuestions;
    }

    private function getUniqueTypes(array $questions): array
    {
        $types = [];

        foreach ($questions as $question) {
            $types[$question->getType()->getName()] = true;
        }
        return array_keys($types);
    }

    private function takeOneQuestionByType(array $questions, string $type): array
    {
        $filteredQuestions = array_filter($questions, function ($question) use ($type) {
            return $question->getType()->getName() === $type;
        });

        $randomKey = array_rand($filteredQuestions, 1);

        return [$filteredQuestions[$randomKey]];
    }

}