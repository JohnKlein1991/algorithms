<?php

/**
 * @param int[] $numbers
 * @return int[]
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
 * @param int[] $numbers
 * @return int[]
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

/**
 * @param array $graph array like
 * [nodeName => cost, ...]
 *   nodeName - string
 *   cost - int
 * @param int|string $start the name of the initial node
 * @param int|string $finish the name of the destination node
 * @return array|null array like
 * ['path' => path, 'cost' => cost]
 *   path - array, path from start to finish (including edges)
 *   cost - int, cost of this path
 */
function dijkstra(array $graph, $start, $finish): ?array
{
    $findLowerCost = function (array $costs, array $processed) {
        $result = null;
        foreach ($costs as $nodeName => $cost) {
            if (in_array($nodeName, $processed) || is_null($cost)) {
                continue;
            }

            if (is_null($result)) {
                $result = $nodeName;
                continue;
            }

            if ($cost < $costs[$result]) {
                $result = $nodeName;
            }
        }
        return $result;
    };

    $costs = [];
    $parents = [];
    $processed = [];

    $costs[$finish] = null;
    $parents[$start] = null;
    foreach ($graph[$start] as $nodeName => $cost) {
        $costs[$nodeName] = $cost;
        $parents[$nodeName] = $start;
    }

    $node = $findLowerCost($costs, $processed);

    while (!is_null($node)) {
        foreach ($graph[$node] as $nodeName => $cost) {
            $newCost = $cost + $costs[$node];
            if (!isset($costs[$nodeName])) {
                $costs[$nodeName] = $newCost;
                $parents[$nodeName] = $node;
            } elseif ($newCost < $costs[$nodeName]) {
                $costs[$nodeName] = $newCost;
                $parents[$nodeName] = $node;
            }
        }
        $processed[] = $node;
        $node = $findLowerCost($costs, $processed);
    }

    if (!isset($costs[$finish])) {
        return null;
    }

    $result = [
        'path' => [],
        'cost' => $costs[$finish],
    ];

    $currentElement = $finish;
    $result['path'][] = $currentElement;
    while (!is_null($currentElement) && isset($parents[$currentElement])) {
        $result['path'][] = $parents[$currentElement];
        $currentElement = $parents[$currentElement];
    }
    $result['path'] = array_reverse($result['path']);

    return $result;
}

/**
 * Dynamic programming: Longest Common Substring
 * @param string $str1
 * @param string $str2
 * @return string
 */
function dp_longest_common_substring(string $str1, string $str2)
{
    $matrix = [];
    $maxLength = 0;
    $maxi = null;
    $maxj = null;
    $result = '';

    for ($i = 0; $i < strlen($str1); $i++) {
        for ($j = 0; $j < strlen($str2); $j++) {
            if ($str1[$i] === $str2[$j]) {
                if ($i === 0 || $j === 0) {
                    $localLength = 1;
                } else {
                    $localLength = $matrix[$i - 1][$j - 1] + 1;
                }
                $matrix[$i][$j] = $localLength;
                if ($localLength > $maxLength) {
                    $maxLength = $localLength;
                    $maxi = $i;
                    $maxj = $j;
                }
            } else {
                $matrix[$i][$j] = 0;
            }
        }
    }

    if ($maxLength === 0) {
        return '';
    }

    while (isset($matrix[$maxi][$maxj]) && $matrix[$maxi][$maxj] !== 0) {
        $result = $str1[$maxi] . $result;

        $maxi = --$maxi;
        $maxj = --$maxj;
    }

    return $result;
}