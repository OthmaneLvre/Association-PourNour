<?php
declare(strict_types=1);

function donationStartSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function donationCsrfToken(): string
{
    donationStartSession();

    if (empty($_SESSION['don_csrf'])) {
        $_SESSION['don_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['don_csrf'];
}

function donationValidateCsrf(mixed $token): bool
{
    donationStartSession();

    return is_string($token)
        && isset($_SESSION['don_csrf'])
        && hash_equals($_SESSION['don_csrf'], $token);
}

function donationAllowedAmounts(): array
{
    return [1, 2, 5, 10, 20, 50, 100, 200];
}

function donationValidateAmount(mixed $amount): ?int
{
    if (!is_string($amount) || !ctype_digit($amount)) {
        return null;
    }

    $value = (int) $amount;

    return in_array($value, donationAllowedAmounts(), true)
        ? $value
        : null;
}

function donationEscape(string $value): string
{
    return htmlspecialchars(
        $value,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

function donationSubmissionToken(): string
{
    donationStartSession();

    if (empty($_SESSION['don_submission_token'])) {
        $_SESSION['don_submission_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['don_submission_token'];
}
