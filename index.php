<?php
$todoList = [];

$serveur = "localhost";  // L'emplacement du serveur MySQL (généralement "localhost")
$utilisateur = "root";  // Votre nom d'utilisateur MySQL
$motDePasse = "root";  // Votre mot de passe MySQL
$nomBaseDeDonnees = "todolistdb";  // Le nom de votre base de données

// Établir une connexion à la base de données
$connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $nomBaseDeDonnees);

// Vérifier la connexion
if (!$connexion) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
} else {
    // Requête SQL pour récupérer les éléments de la table "todo"
    $requete = "SELECT id, content FROM todo";

    // Exécuter la requête
    $resultat = mysqli_query($connexion, $requete);

    // Vérifier si la requête a réussi
    if ($resultat) {
        // Parcourir les résultats et les afficher
        while ($row = mysqli_fetch_assoc($resultat)) {
            $todoList[] = $row["content"];
        }

        // Libérer le résultat
        mysqli_free_result($resultat);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form method="post">
    <label>
      Titre :
      <input name="todo-title" type="text" />
    </label>
    <button type="submit">Ajouter</button>
  </form>
  <?php
    if (isset($_POST['todo-title'])) {
      $contentValue = $_POST['todo-title'];
      $todoList[] = $contentValue;

      $sql = "INSERT INTO todo (content) VALUES ('" . addslashes($contentValue) . "')";

      if ($connexion->query($sql) === TRUE) {
        // echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $connexion->error;
      }
    }
  ?>
  <ul>
    <?php foreach ($todoList as $eachTodo): ?>
    <li><?= $eachTodo ?></li>
    <?php endforeach; ?>
  </ul>
</body>
</html>
<?php
    // N'oubliez pas de fermer la connexion lorsque vous avez terminé
    mysqli_close($connexion);
?>