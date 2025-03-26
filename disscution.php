<?php
ob_start();
$name_fichier = "";

if (isset($_GET['id1']) && isset($_GET['id2'])) {
    if ($_GET['id1'] < $_GET['id2']) {
        $name_fichier = $_GET['id1'] . "_" . $_GET['id2'] . ".txt";
    } else {
        $name_fichier = $_GET['id2'] . "_" . $_GET['id1'] . ".txt";
    }
} else {
    die("Erreur : paramètres ID manquants.");
}

// Création du fichier s'il n'existe pas
if (!file_exists($name_fichier)) {
    $file = fopen($name_fichier, "w");
    fclose($file);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="disscution.css">
    <title>Discussion</title>
    <script>
        function loadMessages() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("messages").innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "messages.php?id1=<?php echo $_GET['id1']; ?>&id2=<?php echo $_GET['id2']; ?>", true);
            xhr.send();
        }

        setInterval(loadMessages, 2000); // Rafraîchit toutes les 2 secondes

        function sendMessage(event) {
            event.preventDefault();
            var message = document.getElementById("messageInput").value;

            if (message.trim() === "") {
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "messages.php?id1=<?php echo $_GET['id1']; ?>&id2=<?php echo $_GET['id2']; ?>", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("messageInput").value = ""; 
                    loadMessages(); 
                }
            };
            xhr.send("msg1=" + encodeURIComponent(message));
        }
    </script>
</head>
<body onload="loadMessages()">
    <div class="container">
        <h2>Discussion</h2>
        <div id="messages" style="overflow-y: auto; max-height: 400px;">
            <!-- Les messages s'affichent ici -->
        </div>
      
        <form onsubmit="sendMessage(event)">
            <input type="text" id="messageInput" placeholder="Entrez votre message" required>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</body>
</html>
<script>
            function scrollToBottom() {
            var messagesDiv = document.getElementById("messages");
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }

            // Call scrollToBottom after loading messages
            function loadMessages() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("messages").innerHTML = xhr.responseText;
                scrollToBottom(); // Scroll to bottom after loading messages
                }
            };
            xhr.open("GET", "messages.php?id1=<?php echo $_GET['id1']; ?>&id2=<?php echo $_GET['id2']; ?>", true);
            xhr.send();
            }
        </script>