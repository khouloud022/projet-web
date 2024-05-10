<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>8ème Anniversaire de Ma Marque</title>
    <link rel="stylesheet" href="anniversaire.css">
</head>
<body onload="onLoadFunction()">
<header><img src="img/back.PNG"></header>
    <div class="tete">
      <a href="parapharmcie.php"><strong>Accueil</strong></a>
      <a href="produits.php"><strong>Nos produits</strong></a>
      <a href="sign in.php"><strong>Mon compte</strong></a>
      <a href="conseil.php"><strong>Nos conseils</strong> </a>
      <a href="test contact.php"><strong>Contact</strong></a>
      <a href="anniversaire.php"><strong>Nos événements</strong></a>
      <a href="a propos.php"><strong>A propos</strong></a>
    </div>
    <br>
    <div class="bordure"></div>
    <br>
    <div class="container">
        <h1>8ème Anniversaire de Rivaderm</h1>
        <img id="image" src="rs/8-years-celebration.webp" onclick="onClickImage()" onmouseover="onMouseOverImage()" onmouseout="onMouseOutImage()">
        <p>Nous célébrons le huitième anniversaire de ma marque de skincare ! Joignez-vous à nous pour une soirée exceptionnelle, où des professionnels seront présents pour partager leurs connaissances. Venez nombreux pour cette occasion spéciale</p>
        <form id="registrationForm" method="post" action="anniversaire.php">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required onfocus="onFocusInput()" onblur="onBlurInput()" onselect="onSelectText()">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required onfocus="onFocusInput()" onblur="onBlurInput()" onselect="onSelectText()">
            <button type="submit" name="rejoindre">Rejoindre l'événement </button>
            <button type="submit" name="annuler">Annuler la participation</button>
        </form>
    </div>
</body>
</html>
<script>
function onLoadFunction() {
    console.log("Page chargée");

}

function onClickImage() {
    console.log("Image cliquée");
    var currentSrc = document.getElementById("image").src;
    if (currentSrc == "rs/8-years-celebration.webp") {
        document.getElementById("image").src = "rs/8 anni.webp";
    } else {
        document.getElementById("image").src = "rs/8-years-celebration.webp";
    }
}

function onMouseOverImage() {
    console.log("Souris sur l'image");
    document.getElementById("image").title = "joignez nous!!";
    document.getElementById("image").style.transition = "transform 0.5s";
    document.getElementById("image").style.transform = "scale(1.1)";
}
function onMouseOutImage() {
    console.log("Souris hors de l'image");
    document.getElementById("image").style.transition = "transform 0.5s";
    document.getElementById("image").style.transform = "none";
}

function onFocusInput() {
    console.log("Champ de formulaire en focus");
}

// Fonction appelée lorsqu'un utilisateur quitte un champ de formulaire
function onBlurInput() {
    console.log("Champ de formulaire hors focus");
    // Ajoutez ici le code pour gérer l'événement onblur d'un champ de formulaire
}

// Fonction appelée lorsqu'un utilisateur sélectionne du texte dans un champ de formulaire
function onSelectText() {
    console.log("Texte sélectionné");
    // Ajoutez ici le code pour gérer l'événement onselect d'un champ de formulaire
}

// Fonction appelée lors de la soumission du formulaire
function onSubmitFunction() {
    console.log("Formulaire soumis");
    // Ajoutez ici le code pour gérer l'événement onsubmit du formulaire
    return true; // Permet l'envoi du formulaire
}
</script>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "projet";

    // Vérification des données envoyées par le formulaire
    if (isset($_POST["nom"]) && isset($_POST["email"])) {
        $nom = $_POST["nom"];
        $email = $_POST["email"];
        
        try {
            $conn = new PDO("mysql:host=$db_server;dbname=$db_name", $db_user, $db_pass);
            // Configurer PDO pour rapporter les erreurs
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if (isset($_POST['rejoindre'])) { // Préparer et exécuter la requête SQL pour insérer les données dans la table
           $sql = "INSERT INTO evenement (nom_ev, nom, email) VALUES ('anniversaire', :nom, :email)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            echo "Merci $nom pour votre participation!";
            }elseif (isset($_POST['annuler'])) {
                // Si le bouton "Annuler la participation" a été cliqué
                $sql = "DELETE FROM evenement WHERE nom = :nom AND email = :email";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                echo "Votre participation à l'événement a été annulée.";
            }
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        $conn = null;
    } else {
        echo "Veuillez remplir tous les champs du formulaire.";
    }
}
?>
