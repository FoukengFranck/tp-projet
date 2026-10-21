<?php
// ============================================================
//  ajouter.php — Ajouter un étudiant (CREATE)
// ============================================================
require_once "connexion.php";

$erreur = "";
$nom = $prenom = $email = $age = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom    = trim($_POST['nom']    ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email  = trim($_POST['email']  ?? '');
    $age    = trim($_POST['age']    ?? '');

    // Validation
    if (empty($nom) || empty($prenom) || empty($email) || empty($age)) {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "L'adresse email n'est pas valide.";
    } elseif (!is_numeric($age) || (int)$age < 1 || (int)$age > 100) {
        $erreur = "L'âge doit être un nombre entre 1 et 100.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO etudiants (nom, prenom, email, age) VALUES (:nom, :prenom, :email, :age)");
        $stmt->execute([
            ':nom'    => $nom,
            ':prenom' => $prenom,
            ':email'  => $email,
            ':age'    => (int)$age,
        ]);
        header("Location: index.php?message=ajoute");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un étudiant</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #0f1117;
            --surface: #181c27;
            --surface2: #1e2334;
            --border: #2a3047;
            --accent: #4f8ef7;
            --red: #ef4444;
            --text: #e8eaf0;
            --muted: #7a82a0;
            --radius: 10px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 36px 40px;
            width: 100%;
            max-width: 520px;
        }

        .back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--muted);
            font-size: 13px;
            text-decoration: none;
            margin-bottom: 28px;
            transition: color .2s;
        }

        .back:hover {
            color: var(--text);
        }

        h1 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .sous-titre {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 28px;
        }

        .erreur {
            background: #2d0a0a;
            border: 1px solid #7f1d1d;
            color: #f87171;
            padding: 12px 16px;
            border-radius: var(--radius);
            font-size: 14px;
            margin-bottom: 22px;
        }

        .groupe {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            margin-bottom: 7px;
            letter-spacing: .03em;
            text-transform: uppercase;
        }

        input {
            width: 100%;
            padding: 11px 14px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            transition: border-color .2s;
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
        }

        input::placeholder {
            color: var(--muted);
        }

        .ligne {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .boutons {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn-submit {
            flex: 1;
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: var(--radius);
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: opacity .2s;
        }

        .btn-submit:hover {
            opacity: .85;
        }

        .btn-annuler {
            flex: 0 0 auto;
            background: var(--surface2);
            color: var(--muted);
            border: 1px solid var(--border);
            padding: 12px 22px;
            border-radius: var(--radius);
            text-decoration: none;
            font-size: 15px;
            text-align: center;
            transition: color .2s;
        }

        .btn-annuler:hover {
            color: var(--text);
        }
    </style>
</head>

<body>
    <div class="card">
        <a href="index.php" class="back">← Retour à la liste</a>
        <h1>Ajouter un étudiant</h1>
        <p class="sous-titre">Remplis le formulaire pour enregistrer un nouvel étudiant.</p>

        <?php if ($erreur): ?>
            <div class="erreur"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>

        <form method="POST" action="ajouter.php">
            <div class="ligne">
                <div class="groupe">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom) ?>" placeholder="Ex : Mbarga" required>
                </div>
                <div class="groupe">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom) ?>" placeholder="Ex : Paul" required>
                </div>
            </div>
            <div class="groupe">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="paul@email.com" required>
            </div>
            <div class="groupe">
                <label for="age">Âge</label>
                <input type="number" id="age" name="age" value="<?= htmlspecialchars($age) ?>" placeholder="Ex : 20" min="1" max="100" required>
            </div>
            <div class="boutons">
                <a href="index.php" class="btn-annuler">Annuler</a>
                <button type="submit" class="btn-submit">Enregistrer l'étudiant</button>
            </div>
        </form>
    </div>
</body>

</html>