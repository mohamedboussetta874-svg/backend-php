<?php
declare(strict_types=1);

require_once __DIR__ . '/CompteBancaire.php';
require_once __DIR__ . '/CompteEpargne.php';
require_once __DIR__ . '/CompteCourant.php';
require_once __DIR__ . '/Banque.php';

// Fonction pour tester un retrait
function tenterRetrait(CompteBancaire $compte, float $montant): void
{
    try {
        $resultat = $compte->retirer($montant);

        if ($resultat === false) {
            echo "Retrait de {$montant} MAD : "
                . $compte->getType()
                . " refusé ("
                . number_format($compte->getSolde(), 2)
                . " MAD)\n";
        } else {
            echo "Retrait de {$montant} MAD : "
                . $compte->getType()
                . " accepté ("
                . number_format($compte->getSolde(), 2)
                . " MAD)\n";
        }
    } catch (Throwable $e) {
        echo "Retrait de {$montant} MAD : "
            . $compte->getType()
            . " refusé ("
            . number_format($compte->getSolde(), 2)
            . " MAD)\n";
    }
}


echo "===== CREATION DES COMPTES =====\n";

$compteEpargne = new CompteEpargne(
    "CB000001",
    "Sara Alami",
    2000,
    3
);

$compteCourant = new CompteCourant(
    "CB000002",
    "Omar Benani",
    800,
    1000
);

echo $compteEpargne . "\n";
echo $compteCourant . "\n";


echo "\n===== POLYMORPHISME =====\n";

$comptes = [
    $compteEpargne,
    $compteCourant
];

foreach ($comptes as $compte) {
    echo $compte->getType() . " : ";
    echo $compte->getSolde() . " MAD\n";
}


echo "\n===== GESTION DE LA BANQUE =====\n";

$banque = new Banque("Banque Centrale");

$banque->ajouterCompte($compteEpargne);
$banque->ajouterCompte($compteCourant);


echo "\n===== INTERETS =====\n";

$interets = $compteEpargne->calculerInterets();

$banque->crediterInterets();

echo "Intérêts crédités : "
    . number_format($interets, 2)
    . " MAD\n";

echo "Nouveau solde : "
    . number_format($compteEpargne->getSolde(), 2)
    . " MAD\n";


echo "\n===== TEST DES RETRAITS =====\n";

tenterRetrait($compteEpargne, 1700);
tenterRetrait($compteCourant, 1700);

tenterRetrait($compteEpargne, 300);
tenterRetrait($compteCourant, 300);


echo "\n===== DECOUVERT =====\n";

if ($compteCourant->estEnDecouvert()) {
    echo "Le compte courant est en découvert.\n";
} else {
    echo "Le compte courant n'est pas en découvert.\n";
}


echo "\n===== STATISTIQUES =====\n";

$comptesParType = $banque->comptesParType();

echo "Comptes Epargne : "
    . ($comptesParType['Épargne'] ?? 0)
    . "\n";

echo "Comptes Courant : "
    . ($comptesParType['Courant'] ?? 0)
    . "\n";


echo "\n===== RECHERCHE =====\n";

$compteTrouve = $banque->trouverCompte("CB000001");

if ($compteTrouve !== null) {
    echo "Compte trouvé : " . $compteTrouve . "\n";
} else {
    echo "Compte introuvable.\n";
}


echo "\n===== TOUS LES COMPTES =====\n";

$banque->afficherComptes();


echo "\n===== TOTAL DES DEPOTS =====\n";

echo "Total : "
    . number_format($banque->totalDepots(), 2)
    . " MAD\n";


echo "\nNombre de comptes créés : "
    . CompteBancaire::getNombreComptes()
    . "\n";
