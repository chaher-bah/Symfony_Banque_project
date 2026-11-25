# Banque

Application bancaire sous Symfony, avec Symfony Console, Composer et XAMPP. Un client peut détenir plusieurs comptes, effectuer des dépôts, des retraits et des virements, puis demander un prêt depuis l’un de ses comptes. Le score de ce compte détermine son éligibilité au prêt et peut lui donner accès à un taux réduit ou à d’autres avantages.

## Modèle de données

```mermaid
erDiagram
    User ||--o{ Account : "détient en tant que client"
    Account ||--o{ Transaction : "compte source"
    Account o|--o{ Transaction : "destination interne"
    Account ||--o{ Loan : "reçoit les fonds"

    User {
        int id PK
        string email UK
        string password "haché"
        json roles "ROLE_CUSTOMER ou ROLE_ADMIN"
        string firstName
        string lastName
        string phone
        string address
        date birthDate
        datetime createdAt
    }

    Account {
        int id PK
        int customer_id FK "User"
        string iban UK
        AccountType type "CHECKING, SAVINGS"
        decimal balance "15,2"
        string currency
        AccountStatus status "ACTIVE, FROZEN, CLOSED"
        int score "500 par défaut"
        datetime openedAt
    }

    Transaction {
        int id PK
        int sourceAccount_id FK
        int destinationAccount_id FK "facultatif"
        string counterpartyIban "facultatif"
        string counterpartyName "facultatif"
        string counterpartyBank "facultatif"
        decimal amount "15,2"
        TransactionType type "TRANSFER, DEPOSIT, WITHDRAWAL"
        TransactionStatus status "PENDING, COMPLETED, FAILED"
        string reference
        string label
        datetime createdAt
    }

    Loan {
        int id PK
        int account_id FK
        decimal amount "15,2"
        decimal interestRate "5,2"
        int durationMonths
        LoanStatus status "PENDING, APPROVED, REJECTED, ACTIVE, REPAID"
        int scoreAtRequest
        datetime requestedAt
        datetime decidedAt "facultatif"
    }
```

- **Accès et identité.** `User` regroupe les identifiants de connexion et le profil client. Le rôle détermine l’accès à l’espace client ou au tableau de bord. Les champs d’identité sont obligatoires pour les clients et facultatifs pour les administrateurs. Seul un client peut détenir un compte.
- **Transactions.** `sourceAccount` désigne toujours un compte de la banque. Pour un virement, il faut renseigner exactement un des deux champs, `destinationAccount` en interne ou `counterpartyIban` vers une autre banque. Le nom du bénéficiaire et sa banque peuvent compléter l’IBAN externe. Pour un dépôt ou un retrait, les deux destinations restent vides et l’opération crédite ou débite le compte indiqué.
- **Prêts.** À la demande, `Loan.scoreAtRequest` conserve le score du compte choisi. Ce score reste celui de la demande même si le score du compte évolue. Le même compte reçoit les fonds si le prêt est accordé.
