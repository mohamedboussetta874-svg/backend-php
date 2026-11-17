<?php
declare(strict_types=1);

require_once __DIR__ . '/CompteBancaire.php';

echo "===== GESTION DES COMPTES BANCAIRES =====\n\n";


$compte1 = new CompteBancaire("CB000001", "Sara Alami", 1000);
$compte2 = new CompteBancaire("CB000002", "Omar Benani", 0);

echo "Comptes créés :\n";
echo $compte1 . "\n";
echo $compte2 . "\n\n";


echo "===== DEPOT =====\n";
$compte1->deposer(500);
echo "Après dépôt de 500 MAD :\n";
echo $compte1 . "\n\n";


echo "===== RETRAIT =====\n";
$compte1->retirer(200);
echo "Après retrait de 200 MAD :\n";
echo $compte1 . "\n\n";


echo "===== VIREMENT =====\n";
$compte1->virerVers($compte2, 300);

echo "Compte émetteur : " . $compte1 . "\n";
echo "Compte destinataire : " . $compte2 . "\n\n";


echo "===== TEST SOLDE INSUFFISANT =====\n";

try {
    $compte2->retirer(1000);
} catch (RuntimeException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}


echo "\n===== TEST DEPOT NEGATIF =====\n";

try {
    $compte1->deposer(-100);
} catch (InvalidArgumentException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}


echo "\n===== TEST NUMERO INVALIDE =====\n";

try {
    $compte3 = new CompteBancaire("XYZ", "Ahmed", 500);
} catch (InvalidArgumentException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}


echo "\n===== MODIFICATION TITULAIRE =====\n";

$compte1->setTitulaire("Sara Benali");
echo $compte1 . "\n";


echo "\n===== TEST VISIBILITE =====\n";

try {
   echo $compte1->getSolde();
} catch (Error $e) {
    echo "Erreur : Impossible d'accéder à l'attribut privé solde.\n";
}


echo "\n===== STATISTIQUES =====\n";

echo "Nombre de comptes : "
    . CompteBancaire::getNombreComptes() . "\n";

echo "Devise : " . CompteBancaire::DEVISE . "\n";

echo "Plafond de retrait : "
    . CompteBancaire::PLAFOND_RETRAIT . " MAD\n";


echo "Numéro CB000001 valide : ";

echo CompteBancaire::estNumeroValide("CB000001")
    ? "Oui\n"
    : "Non\n";
