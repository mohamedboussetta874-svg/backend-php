<?php
declare(strict_types=1);

require_once __DIR__ . '/CompteBancaire.php';
require_once __DIR__ . '/CompteEpargne.php';

class Banque
{
    private string $nom;

 
    private array $comptes = [];

    public function __construct(string $nom)
    {
        $this->nom = $nom;
    }

    
    public function ajouterCompte(CompteBancaire $compte): void
    {
        $numero = $compte->getNumero();

        if (isset($this->comptes[$numero])) {
            throw new InvalidArgumentException(
                "Ce compte existe déjà."
            );
        }

        $this->comptes[$numero] = $compte;
    }

   
    public function trouverCompte(
        string $numero
    ): ?CompteBancaire {
        return $this->comptes[$numero] ?? null;
    }

    
    public function totalDepots(): float
    {
        $total = 0.0;

        foreach ($this->comptes as $compte) {
            $total += $compte->getSolde();
        }

        return $total;
    }

    
    public function crediterInterets(): int
    {
        $nombre = 0;

        foreach ($this->comptes as $compte) {
            if ($compte instanceof CompteEpargne) {
                $compte->ajouterInterets();
                $nombre++;
            }
        }

        return $nombre;
    }

    
    public function afficherComptes(): void
    {
        echo "Banque : " . $this->nom . PHP_EOL;

        foreach ($this->comptes as $compte) {
            echo $compte . PHP_EOL;
        }
    }

    
    public function comptesParType(): array
    {
        $resultat = [];

        foreach ($this->comptes as $compte) {
            $type = $compte->getType();

            if (!isset($resultat[$type])) {
                $resultat[$type] = 0;
            }

            $resultat[$type]++;
        }

        return $resultat;
    }
}
