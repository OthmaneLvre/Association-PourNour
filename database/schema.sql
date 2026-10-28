CREATE DATABASE IF NOT EXISTS association_pour_nour
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE association_pour_nour;

CREATE TABLE IF NOT EXISTS donors (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(254) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_donors_email (email)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS members (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(254) NOT NULL,

    phone VARCHAR(30) NULL,
    address_line1 VARCHAR(255) NULL,
    address_line2 VARCHAR(255) NULL,
    postal_code VARCHAR(20) NULL,
    city VARCHAR(150) NULL,
    country CHAR(2) NOT NULL DEFAULT 'FR',

    contact_email_opt_in TINYINT(1) NOT NULL DEFAULT 0,
    contact_sms_opt_in TINYINT(1) NOT NULL DEFAULT 0,
    contact_postal_opt_in TINYINT(1) NOT NULL DEFAULT 0,
    contact_preferences_updated_at DATETIME NULL,

    status ENUM('pending', 'active', 'expired', 'cancelled')
        NOT NULL DEFAULT 'pending',
    membership_start DATE NULL,
    membership_end DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_members_email (email)
) ENGINE=InnoDB;


-- Adhésions annuelles : Solo 10 €, Couple 15 €
CREATE TABLE IF NOT EXISTS memberships (
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

-- Personnes rattachées à une adhésion
CREATE TABLE IF NOT EXISTS membership_members (
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


CREATE TABLE IF NOT EXISTS transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reference VARCHAR(64) NOT NULL UNIQUE,
    transaction_type ENUM('donation', 'membership') NOT NULL,
    donor_id BIGINT UNSIGNED NULL,
    member_id BIGINT UNSIGNED NULL,
    membership_id BIGINT UNSIGNED NULL,
    amount_cents INT UNSIGNED NOT NULL,
    currency CHAR(3) NOT NULL DEFAULT 'EUR',
    payment_method ENUM('stripe', 'paypal') NULL,
    submission_token CHAR(64) NULL,
    payment_status ENUM(
        'pending', 'paid', 'failed', 'cancelled'
    ) NOT NULL DEFAULT 'pending',
    provider_payment_id VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    paid_at TIMESTAMP NULL DEFAULT NULL,

    CONSTRAINT fk_transaction_donor
        FOREIGN KEY (donor_id) REFERENCES donors(id),

    CONSTRAINT fk_transaction_member
        FOREIGN KEY (member_id) REFERENCES members(id),

    CONSTRAINT fk_transaction_membership
        FOREIGN KEY (membership_id) REFERENCES memberships(id),

    CONSTRAINT chk_transaction_amount
        CHECK (amount_cents > 0),

    CONSTRAINT chk_transaction_owner
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
        ),

    UNIQUE KEY uq_provider_payment
        (payment_method, provider_payment_id),

    UNIQUE KEY uq_submission_token (submission_token),

    INDEX idx_transaction_status (payment_status),
    INDEX idx_transactions_membership (membership_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS payment_events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    transaction_id BIGINT UNSIGNED NULL,
    provider ENUM('stripe', 'paypal') NOT NULL,
    provider_event_id VARCHAR(255) NOT NULL,
    event_type VARCHAR(150) NOT NULL,
    processed_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_payment_event_transaction
        FOREIGN KEY (transaction_id)
        REFERENCES transactions(id),

    UNIQUE KEY uq_provider_event (provider, provider_event_id)
) ENGINE=InnoDB;
