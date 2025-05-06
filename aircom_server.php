<?php
require_once 'routeros_api.class.php';
require_once 'telegram_bot.php';
require_once 'sms_gateway.php';

$username = $_POST['username'];
$password = $_POST['password'];
$telephone = $_POST['telephone'];
$montant = $_POST['montant'];
$nom = $_POST['nom'];

// Simule un paiement réussi (version test)
$paiement_ok = true; // à remplacer plus tard avec API réelle

if ($paiement_ok) {
    // Création PPPoE sur MikroTik
    $api = new RouterosAPI();
    if ($api->connect(getenv('MIKROTIK_IP'), getenv('MIKROTIK_USERNAME'), getenv('MIKROTIK_PASSWORD'))) {
        $api->comm("/ppp/secret/add", [
            "name" => $username,
            "password" => $password,
            "profile" => "default",
            "comment" => "Client Aircom payé"
        ]);
        $api->disconnect();
    }

    // Notification Telegram
    $message = "🎉 *Paiement confirmé*\n👤 $nom\n📞 $telephone\n👤 PPPoE: `$username`\n🔐 Mot de passe: `$password`\n💰 Montant: $montant FCFA";
    sendTelegram($message);

    // Notification SMS
    sendSMS($telephone, "Merci $nom. Votre compte PPPoE ($username) est actif. Mot de passe: $password – Aircom");

    // Affichage à l’écran
    echo "<h2>Paiement réussi !</h2>";
    echo "<p>Votre compte PPPoE <strong>$username</strong> a été créé avec succès.</p>";
} else {
    echo "<h2>Erreur de paiement</h2>";
}
?>
