<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <Label>Formulaire création de user</Label>
        <input type="text" name="usernameCreate">
        <input type="text" name="passwordCreate">
        <input type="submit" name="submitCreate">
    </form>
</body>
</html>
<?php 

// CRUD

// Connexion à la BDD -> PDO

// Informations de connexion à la base de données
    $serveur = 'localhost'; // Adresse du serveur MySQL
    $utilisateur = 'root'; // Nom d'utilisateur MySQL
    $motDePasse = ''; // Mot de passe MySQL
    $nomBDD = 'demo'; // Nom de la base de données MySQL

    $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
    // Configuration de PDO pour afficher les erreurs
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Code à exécuter après la connexion réussie


    // Create
    if (isset($_POST['submitCreate'])){
        $usernameCreate = $_POST['usernameCreate'];
        $passwordCreate = $_POST['passwordCreate'];
        $sqlCreate = "INSERT INTO `user`(`username`, `password`) VALUES (:usernameCreate, :passwordCreate);";
        // Prepare
            $requete = $connexion->prepare($sqlCreate);
            $requete->bindParam(':usernameCreate', $usernameCreate);
            $requete->bindParam(':passwordCreate', $passwordCreate);
        // Execute
        $requete->execute();

    }
    ?>
    <form method="POST">

    <?php
    $sqlRead = "SELECT * FROM `user`;";
    $request = $connexion->query($sqlRead);
    $data = $request->fetchAll(pdo::FETCH_ASSOC);
    foreach($data as $value){
        echo $value['id'] . " " . $value['username'] . " " . $value['password'] . " <a href='?page=modifier&id=" . $value['id'] . "'>Modifier</a><input type='hidden' name='idDelete' value='" . $value['id'] ."'> <input type='submit' name='submitDelete' value='Supprimer'>";
    }
    ?>
</form>
    <?php

    if (isset($_GET['page']) && $_GET['page'] == "modifier"){
        ?>
            <form method="POST">
                <Label>Formulaire modification de user</Label>
                <input type="hidden" name="idUpdate" value="<?php echo $_GET['id']; ?>">
                <input type="text" name="usernameUpdate">
                <input type="text" name="passwordUpdate">
                <input type="submit" name="submitUpdate">
            </form>
        <?php

        if (isset($_POST['submitUpdate'])){
            $idUpdate = $_POST['idUpdate'];
            $usernameUpdate = $_POST['usernameUpdate'];
            $passwordUpdate = $_POST['passwordUpdate'];
            $sqlUpdate = "UPDATE `user` SET `username`='$usernameUpdate',`password`='$passwordUpdate' WHERE id = $idUpdate";

            $connexion->query($sqlUpdate);

        }
    }
    

    if (isset($_POST['submitDelete'])){
        $idDelete = $_POST['idDelete'];
        $sqlDelete = "DELETE FROM `user` WHERE id = $idDelete";

        $connexion->query($sqlDelete);

    }
    


    // Requête SQL -> même requête que dans le terminal ou phpmyadmin
        // Create
            // SQL = INSERT INTO `user`(`username`, `password`) VALUES ('Villeneuve','[value-3]');
    // Read
        // SQL = SELECT * FROM `user`
    // Update
        // SQL = UPDATE `user` SET `username`='[value-2]',`password`='[value-3]' WHERE id = truc
    // Delete
        // SQL = DELETE FROM `user` WHERE id = truc

// Query vers la BDD (l'execution de la requête)
    // Requête préparé
    // Execution
// Reponse
    // Données ajoutées ou Fetch à faire 
    // Confirmation de l'execution

    
?>