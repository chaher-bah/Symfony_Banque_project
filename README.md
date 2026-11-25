# Banque

Application bancaire sous Symfony, développée avec Symfony Console, Composer et XAMPP.

Un client peut détenir plusieurs comptes de types différents et effectuer des virements vers un compte de la même banque ou d’une autre banque. Chaque compte a son propre score. Ce score détermine l’accès au prêt et peut donner droit à un taux réduit ou à d’autres avantages.

## Modèle de données

```mermaid
erDiagram
    CLIENT ||--o{ COMPTE : detient
    COMPTE ||--o{ VIREMENT : emet
    COMPTE o|--o{ VIREMENT : "reçoit en interne"
    COMPTE ||--o{ PRET : "sert de référence pour"

    COMPTE {
        string type
        string iban UK
        int score
    }
    VIREMENT {
        decimal montant
        string ibanDestinataire
    }
    PRET {
        decimal montant
        decimal tauxAccorde
    }
```

Pour un virement interne, l’IBAN du destinataire correspond à un compte de la banque. Pour un virement externe, seul l’IBAN du destinataire est conservé.
