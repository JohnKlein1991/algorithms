<?php

/**
 * @param array $numbers
 * @return array
 */
function bubble_sort(array $numbers): array
{
    $count = count($numbers);

    if ($count < 2) {
        return $numbers;
    }

    while (true) {
        $sorted = true;
        for ($i = 1; $i < $count; $i++) {
            if ($numbers[$i] < $numbers[$i - 1]) {
                $temp = $numbers[$i];
                $numbers[$i] = $numbers[$i - 1];
                $numbers[$i - 1] = $temp;
                $sorted = false;
            }
        }

        if ($sorted) {
            return  $numbers;
        }
    }
}

/**
 * @param array $numbers
 * @return []|array
 */
function qsort(array $numbers): array
{
    $count = count($numbers);
    if ($count < 2) {
        return $numbers;
    }

    $index = rand(0, $count - 1);

    $less = [];
    $greater = [];

    for ($i = 0; $i < $count; $i++) {
        if ($i === $index) {
            continue;
        }
        if ($numbers[$i] <= $numbers[$index]) {
            $less[] = $numbers[$i];
        } else {
            $greater[] = $numbers[$i];
        }
    }


    return array_merge(qsort($less), [$numbers[$index]], qsort($greater));
}