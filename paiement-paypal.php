<?php
session_start();
if (!isset($_SESSION['don'])) {
    header("Location: don.php");
    exit;
}

$don = $_SESSION['don'];
$amount = $don["montant"];
?>

<?php include 'partials/head.php'; ?>
<?php include 'partials/header.php'; ?>

<main class="page-don">
    <section class="don-section">
        <h2>Paiement via PayPal</h2>

        <div id="paypal-button-container"></div>

        <script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID&currency=EUR"></script>

        <script>
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: { value: "<?= $amount ?>" }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        window.location.href = "paiement-success.php";
                    });
                },
                onCancel: function() {
                    window.location.href = "paiement-cancel.php";
                }
            }).render("#paypal-button-container");
        </script>

    </section>
</main>
