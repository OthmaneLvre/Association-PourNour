-- Association Pour Nour
-- Migration 001 : gestion des adhésions
-- MariaDB 10.4
-- À exécuter une seule fois, après sauvegarde.
-- Ne pas utiliser le compte applicatif pour cette migration.

USE association_pour_nour;

-- 1. Coordonnées individuelles
ALTER TABLE members
    ADD COLUMN phone VARCHAR(30) NULL,
    ADD COLUMN address_line1 VARCHAR(255) NULL,
    ADD COLUMN address_line2 VARCHAR(255) NULL,
    ADD COLUMN postal_code VARCHAR(20) NULL,
    ADD COLUMN city VARCHAR(150) NULL,
    ADD COLUMN country CHAR(2) NOT NULL DEFAULT 'FR',
    ADD COLUMN contact_email_opt_in TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN contact_sms_opt_in TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN contact_postal_opt_in TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN contact_preferences_updated_at DATETIME NULL;

-- 2. Adhésions Solo / Couple
CREATE TABLE memberships (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    membership_type ENUM('solo', 'couple') NOT NULL,
    amount_cents INT UNSIGNED NOT NULL,
    status ENUM('pending', 'active', 'expired', 'cancelled')
        NOT NULL DEFAULT 'pending',
    membership_start DATE NULL,
    membership_end DATE NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT chk_membership_amount
        CHECK (
            (membership_type = 'solo' AND amount_cents = 1000)
            OR
            (membership_type = 'couple' AND amount_cents = 1500)
        ),

    INDEX idx_memberships_status (status)
) ENGINE=InnoDB;

-- 3. Association des personnes à une adhésion
CREATE TABLE membership_members (
    membership_id BIGINT UNSIGNED NOT NULL,
    member_id BIGINT UNSIGNED NOT NULL,
    member_role ENUM('primary', 'secondary') NOT NULL,

    PRIMARY KEY (membership_id, member_id),

    CONSTRAINT fk_membership_members_membership
        FOREIGN KEY (membership_id)
        REFERENCES memberships(id),

    CONSTRAINT fk_membership_members_member
        FOREIGN KEY (member_id)
        REFERENCES members(id),

    UNIQUE KEY uq_membership_role (membership_id, member_role),
    INDEX idx_membership_members_member (member_id)
) ENGINE=InnoDB;

-- 4. Lien entre transactions et adhésions
ALTER TABLE transactions
    ADD COLUMN membership_id BIGINT UNSIGNED NULL,
    ADD INDEX idx_transactions_membership (membership_id),
    ADD CONSTRAINT fk_transaction_membership
        FOREIGN KEY (membership_id)
        REFERENCES memberships(id);


-- 5. Adapter la contrainte des transactions
-- Préserver les dons et autoriser les nouvelles adhésions.

ALTER TABLE transactions
    DROP CONSTRAINT chk_transaction_owner,
    ADD CONSTRAINT chk_transaction_owner
        CHECK (
            (
                transaction_type = 'donation'
                AND donor_id IS NOT NULL
                AND member_id IS NULL
                AND membership_id IS NULL
            )
            OR
            (
                transaction_type = 'membership'
                AND donor_id IS NULL
                AND (
                    (membership_id IS NOT NULL AND member_id IS NULL)
                    OR
                    (membership_id IS NULL AND member_id IS NOT NULL)
                )
            )
        );
