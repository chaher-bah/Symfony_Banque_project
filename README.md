# Banque

Application bancaire sous Symfony, avec Symfony Console, Composer et XAMPP. Un client peut détenir plusieurs comptes, effectuer des dépôts, des retraits et des virements, et demander un prêt. L’administrateur traite les inscriptions, les transactions et les demandes de prêt.

## Modèle de données

```mermaid
erDiagram
    User ||--o| Customer : "a pour profil"
    Customer ||--o{ Account : "détient"
    Account ||--o{ Transaction : "compte source"
    Account o|--o{ Transaction : "destination interne"
    Account ||--o{ Loan : "reçoit les fonds"
    User o|--o{ User : "statue sur une inscription"
    User o|--o{ Transaction : "statue sur une transaction"
    User o|--o{ Loan : "statue sur un prêt"

    User {
        int id PK
        string email UK
        string password "haché"
        json roles "ROLE_CUSTOMER ou ROLE_ADMIN"
        datetime createdAt
        UserStatus status "PENDING, ACTIVE, REJECTED"
        int decidedBy FK "administrateur, facultatif"
        datetime decidedAt "facultatif"
    }

    Customer {
        int id PK
        int user FK, UK
        string firstName
        string lastName
        string phone
        string address
        date birthDate
    }

    Account {
        int id PK
        int customer FK
        string iban UK
        AccountType type "CHECKING, SAVINGS"
        decimal balance "15,2"
        string currency
        datetime openedAt
        AccountStatus status "PENDING, ACTIVE, FROZEN, CLOSED"
        int score
        datetime scoreUpdatedAt
    }

    Transaction {
        int id PK
        int sourceAccount FK
        int destinationAccount FK "facultatif"
        string counterpartyIban "facultatif"
        string counterpartyName "facultatif"
        string counterpartyBank "facultatif"
        decimal amount "15,2"
        TransactionType type "TRANSFER, DEPOSIT, WITHDRAWAL"
        string label
        datetime createdAt
        TransactionStatus status "PENDING, COMPLETED, REJECTED"
        int decidedBy FK "administrateur, facultatif"
        datetime decidedAt "facultatif"
        string rejectionReason "facultatif"
    }

    Loan {
        int id PK
        int account FK
        decimal amount "15,2"
        decimal interestRate "5,2"
        int durationMonths
        datetime requestedAt
        int scoreAtRequest
        LoanStatus status "PENDING, APPROVED, REJECTED, ACTIVE, REPAID"
        int decidedBy FK "administrateur, facultatif"
        datetime decidedAt "facultatif"
    }
```

- **Inscription.** Un client possède un profil `Customer` lié à son `User`. Un administrateur utilise uniquement `User`. Le `UserChecker` de Symfony autorise la connexion uniquement lorsque `User.status` vaut `ACTIVE`.
- **Comptes et prêts.** Un compte `PENDING` ne peut ni envoyer ni recevoir de fonds, ni servir à demander un prêt. L’administrateur fixe le score de chaque compte. Lors d’une demande, `scoreAtRequest` conserve le score utilisé pour évaluer l’éligibilité et le taux du prêt.
- **Transactions.** Un virement désigne exactement un destinataire par `destinationAccount` en interne ou par `counterpartyIban` vers une autre banque. Un dépôt ou un retrait porte uniquement sur `sourceAccount`. Seule une transaction `COMPLETED` modifie le solde.
- **Décisions.** Pour une inscription, une transaction ou un prêt, `decidedBy` et `decidedAt` indiquent qui a pris la décision et à quelle date. Ces champs restent vides tant que la décision est en attente.
