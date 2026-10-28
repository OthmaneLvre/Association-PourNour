
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
    status ENUM('pending', 'active', 'expired', 'cancelled')
        NOT NULL DEFAULT 'pending',
    membership_start DATE NULL,
    membership_end DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_members_email (email)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reference VARCHAR(64) NOT NULL UNIQUE,
    transaction_type ENUM('donation', 'membership') NOT NULL,
    donor_id BIGINT UNSIGNED NULL,
    member_id BIGINT UNSIGNED NULL,
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

    CONSTRAINT chk_transaction_amount
        CHECK (amount_cents > 0),

    CONSTRAINT chk_transaction_owner
        CHECK (
            (transaction_type = 'donation'
                AND donor_id IS NOT NULL
                AND member_id IS NULL)
            OR
            (transaction_type = 'membership'
                AND member_id IS NOT NULL
                AND donor_id IS NULL)
        ),

    UNIQUE KEY uq_provider_payment
        (payment_method, provider_payment_id),

    UNIQUE KEY uq_submission_token (submission_token),

    INDEX idx_transaction_status (payment_status)
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
