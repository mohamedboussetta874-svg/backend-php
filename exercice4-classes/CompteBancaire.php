<?php
declare(strict_types=1);

class CompteBancaire
{
    
    public const DEVISE = 'MAD';
    public const PLAFOND_RETRAIT = 5000.0;

    
    private static int $nombreComptes = 0;

    
    private string $numero;
    private string $titulaire;
    private float $solde;

    
    public function __construct(
        string $numero,
        string $titulaire,
        float $soldeInitial = 0.0
    ) {
        if (!self::estNumeroValide($numero)) {
            throw new InvalidArgumentException("Numéro de compte invalide.");
        }

        if ($soldeInitial < 0) {
            throw new InvalidArgumentException("Le solde ne peut pas être négatif.");
        }

        if (trim($titulaire) === '') {
            throw new InvalidArgumentException("Le titulaire est obligatoire.");
        }

        $this->numero = $numero;
        $this->titulaire = trim($titulaire);
        $this->solde = $soldeInitial;

        self::$nombreComptes++;
    }

    
    public function getNumero(): string
    {
        return $this->numero;
    }

    public function getTitulaire(): string
    {
        return $this->titulaire;
    }

    public function getSolde(): float
    {
        return $this->solde;
    }

    
    public function setTitulaire(string $titulaire): void
    {
        if (trim($titulaire) === '') {
            throw new InvalidArgumentException("Le titulaire est obligatoire.");
        }

        $this->titulaire = trim($titulaire);
    }

    
    public function deposer(float $montant): void
    {
        if ($montant <= 0) {
            throw new InvalidArgumentException("Le montant doit être positif.");
        }

        $this->solde += $montant;
    }

    
    public function retirer(float $montant): void
    {
        if ($montant <= 0) {
            throw new InvalidArgumentException("Le montant doit être positif.");
        }

        if ($montant > self::PLAFOND_RETRAIT) {
            throw new InvalidArgumentException("Plafond de retrait dépassé.");
        }

        if ($montant > $this->solde) {
            throw new RuntimeException("Solde insuffisant.");
        }

        $this->solde -= $montant;
    }

    
    public function virerVers(
        CompteBancaire $destination,
        float $montant
    ): void {
        if ($destination === $this) {
            throw new InvalidArgumentException("Virement vers le même compte impossible.");
        }

        if ($montant <= 0) {
            throw new InvalidArgumentException("Le montant doit être positif.");
        }

        if ($montant > self::PLAFOND_RETRAIT) {
            throw new InvalidArgumentException("Plafond de retrait dépassé.");
        }

        if ($montant > $this->solde) {
            throw new RuntimeException("Solde insuffisant.");
        }

        $this->solde -= $montant;
        $destination->solde += $montant;
    }

    
    public function __toString(): string
    {
        return sprintf(
            "%s - %s : %.2f %s",
            $this->numero,
            $this->titulaire,
            $this->solde,
            self::DEVISE
        );
    }

   
    public static function getNombreComptes(): int
    {
        return self::$nombreComptes;
    }

   
    public static function estNumeroValide(string $numero): bool
    {
        return preg_match('/^CB\d{6}$/', $numero) === 1;
    }
}
