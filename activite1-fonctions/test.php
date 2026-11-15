<?php
declare(strict_types=1);

require_once __DIR__ . '/fonctions.php';



echo "===== OPERATIONS =====\n";

echo "12 + 8 = " . additionner(12, 8) . PHP_EOL;
echo "12 - 8 = " . soustraire(12, 8) . PHP_EOL;
echo "12 * 8 = " . multiplier(12, 8) . PHP_EOL;
echo "12 / 8 = " . diviser(12, 8) . PHP_EOL;

try {
    echo diviser(10, 0) . PHP_EOL;
} catch (InvalidArgumentException $e) {
    echo "Erreur : " . $e->getMessage() . PHP_EOL;
}



echo "\n===== FONCTIONS LOGIQUES =====\n";

echo "7 est pair ? " . (estPair(7) ? "oui" : "non") . PHP_EOL;
echo "5 est positif ? " . (estPositif(5) ? "oui" : "non") . PHP_EOL;

echo "Maximum : " . maximum(10, 25, 15) . PHP_EOL;
echo "Maximum avec max() : " . maximumAvecMax(10, 25, 15) . PHP_EOL;

echo "7 est premier ? " . (estPremier(7) ? "oui" : "non") . PHP_EOL;



echo "\n===== CALCULS COMMERCIAUX =====\n";

echo "TTC : " . calculerTTC(100) . " MAD\n";
echo "Prix apres remise : " . calculerRemise(100, 10) . " MAD\n";

$facture = calculerFacture(100, 10, 10, 20);

echo "Facture : " .
    number_format($facture, 2, ",", " ") . " MAD\n";



echo "\n===== STATISTIQUES =====\n";

echo "Moyenne : " . moyenne(12, 15, 18) . PHP_EOL;
echo "Moyenne vide : " . moyenne() . PHP_EOL;

echo "Aire du cercle : " . aireCercle(5) . PHP_EOL;
echo "Perimetre : " . perimetreCercle(5) . PHP_EOL;

echo "25 Celsius = " . celsiusVersFahrenheit(25) . " F\n";
echo "77 Fahrenheit = " . fahrenheitVersCelsius(77) . " C\n";

echo "100 MAD = " . convertirDevise(100, 0.092) . " EUR\n";



echo "\n===== BOUCLES =====\n";

echo "5! = " . factorielle(5) . PHP_EOL;

echo "Fibonacci(8) : " .
    implode(", ", fibonacci(8)) . PHP_EOL;

echo "PGCD(48, 18) = " . pgcd(48, 18) . PHP_EOL;

echo "Puissance boucle : " . puissance(2, 3) . PHP_EOL;

echo "Puissance recursive : " .
    puissanceRecursive(2, 3) . PHP_EOL;

echo "\n===== FIN DES TESTS =====\n";
