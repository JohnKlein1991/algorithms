<?php

// There are two participants - Beavis and Bathed

// All of them know this numbers:
$P = 10;
$G = 3;

// Each of them generates own private key
$privateKeyBeavis = 10;
$privateKeyBathed = 14;

// Each of them generates own public key ...
$generatedKeyBeavis = ($G ** $privateKeyBeavis) % $P;
$generatedKeyBathed = ($G ** $privateKeyBathed) % $P;

// ... and send it to another participant.

// So Beavis receives $generatedKeyBathed and generate the new secret key:
$generatedSecretKeyBeavis = ($generatedKeyBathed ** $privateKeyBeavis) % $P;

// Bathed receives $generatedKeyBeavis and generate the new secrey key:
$generatedSecretKeyBathed = ($generatedKeyBeavis ** $privateKeyBathed) % $P;

// ... and these two key are equal
$generatedSecretKeyBeavis === $generatedSecretKeyBathed;

// This is because the math formula:
// (((G ** b) mod P) ** a) mod P === (((G ** a) mod P) ** b) mod P

// And the Hacker, who watched for all communication between Beavis and Bathed cannot generate the same secret key:
// Let's the Hacker creates own private key
$privateKeyHacker = 9;
// ... then generates public key ...
$generatedKeyHacker = ($G ** $privateKeyHacker) % $P;
// ... and finally try to generate own secret keys:
$generatedSecretKeyH1 = ($generatedKeyBathed ** $privateKeyHacker) % $P;
$generatedSecretKeyH2 = ($generatedKeyBeavis ** $privateKeyHacker) % $P;
// these keys are not equal to $generatedSecretKeyBeavis and $generatedSecretKeyBathed

// Thanks)

var_dump($generatedSecretKeyBeavis, $generatedSecretKeyBathed, $generatedSecretKeyH1, $generatedSecretKeyH2);
