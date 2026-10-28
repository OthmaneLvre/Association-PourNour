<?php
declare(strict_types=1);

require_once __DIR__ . '/donation-security.php';

function membershipCsrfToken(): string
{
    donationStartSession();

    if (empty($_SESSION['membership_csrf'])) {
        $_SESSION['membership_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['membership_csrf'];
}

function membershipValidateCsrf(mixed $token): bool
{
    donationStartSession();

    return is_string($token)
        && isset($_SESSION['membership_csrf'])
        && hash_equals($_SESSION['membership_csrf'], $token);
}

function membershipSubmissionToken(): string
{
    donationStartSession();

    if (empty($_SESSION['membership_submission_token'])) {
        $_SESSION['membership_submission_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['membership_submission_token'];
}

function membershipAmountCents(string $type): ?int
{
    return match ($type) {
        'solo' => 1000,
        'couple' => 1500,
        default => null,
    };
}

function membershipEscape(string $value): string
{
    return donationEscape($value);
}
