// Initialisation Stripe
const stripe = Stripe("pk_test_51SdST0RDjDrTiQZntkJI0z80ZZuFDTx3HlC3yk86Ivhemc3XiQtNbsBa4f7Jxh53XmVTJDZRgoP4wQeztKjNVZiF00hbmtHHhV");

const elements = stripe.elements();
const card = elements.create("card", {
    hidePostalCode: true,
    style: {
        base: {
            color: "#6B5C58",
            fontFamily: "'Cormorant Garamond', serif",
            fontSize: "18px",
            "::placeholder": {
                color: "#C4B2A8"
            }
        },
        invalid: {
            color: "#E63946"
        }
    }
});
card.mount("#card-element");

// Formulaire
const form = document.getElementById("don-form");
const submitBtn = document.getElementById("submit-btn");
const errorDiv = document.getElementById("card-errors");

form.addEventListener("submit", async (e) => {
    e.preventDefault();
    submitBtn.disabled = true;

    const { paymentMethod, error } = await stripe.createPaymentMethod({
        type: "card",
        card: card
    });

    if (error) {
        errorDiv.textContent = error.message;
        submitBtn.disabled = false;
        return;
    }

    const res = await fetch("stripe-charge.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            amount: document.getElementById("amount").value,
            paymentMethodId: paymentMethod.id
        })
    });

    const data = await res.json();

    if (data.success) {
        alert("Merci pour votre don ❤️");
        form.reset();
        card.clear();
    } else {
        errorDiv.textContent = data.message;
    }

    submitBtn.disabled = false;
});
