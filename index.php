<?php

include_once "connexion.php";

$stmt = $pdo->query("SELECT * FROM etud ORDER BY nom ASC");

$etudiants = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des étudiants</title>

    <style>
        /* --- Style général --- */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .sous-titre {
            color: #888;
            margin-bottom: 25px;
            font-size: 14px;
        }

        /* --- Bouton Ajouter --- */
        .btn-ajouter {
            display: inline-block;
            background-color: #27ae60;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .btn-ajouter:hover {
            background-color: #219a52;
        }

        /* --- Tableau --- */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #2c3e50;
            color: white;
        }

        thead th {
            padding: 12px 16px;
            text-align: left;
            font-weight: normal;
            font-size: 14px;
        }

        tbody tr {
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        tbody td {
            padding: 12px 16px;
            font-size: 14px;
        }

        /* --- Badges actions --- */
        .btn-modifier {
            background-color: #3498db;
            color: white;
            padding: 5px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
            margin-right: 5px;
        }

        .btn-supprimer {
            background-color: #e74c3c;
            color: white;
            padding: 5px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
        }

        /* --- Message si aucun étudiant --- */
        .vide {
            text-align: center;
            padding: 40px;
            color: #aaa;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Gestion des étudiants</h1>
        <p class="sous-titre">Liste de tous les étudiants enregistrés</p>

        <a href="ajouter.php" class="btn-ajouter">+ Ajouter un étudiant</a>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Âge</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($etudiants) === 0) : ?>
                    <tr>
                        <td class="vide" colspan="6">Aucun étudiant enregistré pour l'instant.</td>
                    </tr>

                <?php else: ?>
                    <?php foreach ($etudiants as $etudiant): ?>
                        <tr>
                            <td><?=  $etudiant['id'] ?></td>
                            <td><?=  htmlspecialchars($etudiant['nom']) ?></td>
                            <td><?=  htmlspecialchars($etudiant ['prenom']) ?></td>
                            <td><?=  htmlspecialchars($etudiant['email']) ?></td>
                            <td><?=  $etudiant['age'] ?></td>
                            <td>
                                <a href="modifier.php?id=<?= $etudiant['id'] ?>" class="btn-modifier">Modifier</a>
                                <a href="supprimer.php?id=<?= $etudiant['id'] ?>" class="btn-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">Supprimer</a>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>