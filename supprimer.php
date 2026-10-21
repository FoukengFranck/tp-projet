<?php
require_once "connexion.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = :id");
$stmt->execute([':id' => $id]);
$etudiant = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmer'])) {
    $stmt = $pdo->prepare("DELETE FROM etudiants WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header("location: index.php?message=spprime");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Supprimer un étudiant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 35px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .icone {
            font-size: 48px;
            margin-bottom: 15px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 22px;
        }

        .message {
            color: #555;
            font-size: 15px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .nom-etudiant {
            font-weight: bold;
            color: #e74c3c;
        }

        .avertissement {
            background: #fdecea;
            border-left: 4px solid #e74c3c;
            color: #c0392b;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 25px;
            text-align: left;
        }

        .boutons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn-confirmer {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
        }

        .btn-confirmer:hover {
            background-color: #c0392b;
        }

        .btn-annuler {
            background-color: #ecf0f1;
            color: #555;
            padding: 12px 28px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
        }

        .btn-annuler:hover {
            background-color: #dde1e3;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="icone">🗑️</div>
        <h1>Confirmer la suppression</h1>

        <p class="message">
            Tu es sur le point de supprimer l'étudiant<br>
            <!-- On affiche le nom et prénom de l'étudiant à supprimer -->
            <span class="nom-etudiant">
                <?= htmlspecialchars($etudiant['prenom'] . ' ' . $etudiant['nom']) ?>
            </span>
        </p>

        <div class="avertissement">
            ⚠️ Cette action est irréversible. L'étudiant sera définitivement supprimé de la base de données.
        </div>

        <!-- Le formulaire envoie un POST vers la même page -->
        <form method="POST" action="supprimer.php?id=<?= $id ?>">
            <div class="boutons">
                <!-- Bouton Annuler : simple lien vers l'accueil -->
                <a href="index.php" class="btn-annuler">Annuler</a>

                <!-- Bouton Confirmer : soumet le formulaire avec le champ 'confirmer' -->
                <!-- name="confirmer" est ce qu'on vérifie avec isset($_POST['confirmer']) -->
                <button type="submit" name="confirmer" class="btn-confirmer">
                    Oui, supprimer
                </button>
            </div>
        </form>

    </div>
</body>

</html>




