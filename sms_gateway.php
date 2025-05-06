<?php
function sendSMS($numero, $message) {
    // Simulation d'envoi SMS via Togocel
    // À remplacer par une vraie API (ex: Orange SMS API ou autre)
    file_put_contents("logsms.txt", "[$numero] $message\n", FILE_APPEND);
}
?>
