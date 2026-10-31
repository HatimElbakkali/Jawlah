```mermaid
erDiagram

    DESERT_ACTIVITY {
        INT id PK
        VARCHAR image
        VARCHAR title
        VARCHAR icon_title
        TEXT description
        VARCHAR location
        VARCHAR duration
        VARCHAR age_restriction
        VARCHAR accompanied
        DECIMAL price
        VARCHAR price_note
        DATETIME created_at
        INT capacity
        ENUM status
    }

    desert_activities_pack {
        INT id PK
        VARCHAR image
        VARCHAR title
        TEXT description
        VARCHAR location
        VARCHAR duration
        VARCHAR age_restriction
        VARCHAR accompanied
        DECIMAL price
        VARCHAR price_note
        INT capacity
        ENUM status
        DATETIME created_at
    }

    contact {
        INT id
        VARCHAR name
        VARCHAR email
        TEXT description
        VARCHAR phone
        VARCHAR subject 
        VARCHAR message
        ENUM status
        DATETIME created_at
    }

    BOOKING {
        INT id PK
        INT activity_id FK
        INT pack_id FK
        VARCHAR full_name
        VARCHAR phone_number
        VARCHAR email
        DATE reservation_date
        INT adults
        INT childrens
        INT infants
        VARCHAR duration
        VARCHAR selected_time
        DECIMAL price_per_person
        DECIMAL total_price
        ENUM status
        DATETIME created_at
    }

    EMAIL_NOTIFICATION_Contact {
        VARCHAR name
        VARCHAR email
        TEXT description
        VARCHAR phone
        VARCHAR subject 
        VARCHAR message
    }

    EMAIL_NOTIFICATION_booking {
        VARCHAR Name
        VARCHAR full_name
        VARCHAR phone_number
        VARCHAR email
        DATE reservation_date
        INT passengers
        VARCHAR duration
        VARCHAR selected_time
        DECIMAL price_per_person
        DECIMAL total_price
    }

    DESERT_ACTIVITY ||--o{ BOOKING : booked
    contact ||--o{ EMAIL_NOTIFICATION_Contact : send
    desert_activities_pack ||--o{ BOOKING : booked
    BOOKING ||--|| PAYMENT : has
    PAYMENT ||--o{ EMAIL_NOTIFICATION_booking : sends
```
