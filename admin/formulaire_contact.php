<?php
require_once '../inc/init.php';

// debug($_POST);


//traitement PHP du formulaire HTML pour l'insertion de nouveau produits mais aussi pour la modification de produits 
if (!empty($_POST)) { // si le formulaire a été envoyé

    // Contrôle du remplissage du formulaire
    if (!isset($_POST['name']) || strlen($_POST['name']) < 2 || strlen($_POST['name']) > 50) { // si le champs 'Nom' n'exsite pas OU que sa longeur est inférieure à 2 OU que sa longueur est supérieur à 50 (car limite de notre BDD), alors on met un message à l'internaute
        $contenu .= '<div class="alert alert-danger">Le nom doit contenir entre 2 et 50 caractères.</div>';
    }

    if (!isset($_POST['firstName']) || strlen($_POST['firstName']) < 2 || strlen($_POST['firstName']) > 50) { // si le champs 'Prénom' n'exsite pas OU que sa longeur est inférieure à 2 OU que sa longueur est supérieur à 50 (car limite de notre BDD), alors on met un message à l'internaute
        $contenu .= '<div class="alert alert-danger">Le prénom doit contenir entre 2 et 50 caractères.</div>';
    }

    if (!isset($_POST['phone']) || !preg_match('#^[0-9]{10}$#', $_POST['phone'])) { // si le champs 'Téléphone' n'exsite pas OU que sa composition est différent de l'intervalle de chifffre allant de 0 à 9 et un nombre de chiffre global de 10
        $contenu .= '<div class="alert alert-danger">Le numéro de téléphone n\'est pas valide.</div>';
    }

    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { // si le champs 'Email n'est pas renseigné OU qu'il n'est pas conforme à la syntaxe addr-spec de la RFC 822 (=ce que vérifie la fonction filter_var avec le paramètre 'FILTER_VALIDATE_EMAIL')
        $contenu .= '<div class="alert alert-danger">L\'email n\'est pas valide.</div>';
    }

    if (!isset($_POST['context']) || ($_POST['context'] !== 'ami' && $_POST['context'] !== 'famille' && $_POST['context'] !== 'professionel' && $_POST['context'] !== 'autre')) { // si le champs 'Contexte de connaissance' n'est pas renseigné (malgré la position par défaut sur 'Ami') OU s'il est diifférent de la liste des possibilités référencées en BDD, alors on met un message à l'internaute
        $contenu .= '<div class="alert alert-danger">Veuillez choisir un contexte de connaissance valide.</div>';
    }

    $photo_bdd = ""; //initialisation de la variable $photo_bdd à vide pour prévoir le cas d'ajout de produit sans joindre une photo

    if (isset($_POST['photo_actuelle'])) { // si existe "photo_actuelle" dans $_POST, c'est que je suis en train de modifier le produit : je veux donc remettre le chemin de la photo en BDD
        $photo_bdd = $_POST['photo_actuelle']; // alors on affecte le chemin de la photo actuelle à la variable $photo_bdd qui est insérée en BDD

    }


    if (!empty($_FILES['photo']['name'])) { // si  le nom de la photo (donc du fichier) n'est pas vide, c'est qu'un fichier est en cours d'upload

        $nom_fichier = time() . '_' . $_FILES['photo']['name']; //on attribut un nom à la photo qui va être joint : on lui ajoute le timestamp afin de le rendre unique
        $photo_bdd = 'photo/' . $nom_fichier; // cette variable contient le chemin relatif de l'image que l'on insère en BDD (elle est dans le dossier photo/ et s'appelle $nom_fichier)

        $dot_position = strpos($photo_bdd, '.'); //identification de la position du '.' dans le nom du fichier photo
        $type_file = substr($photo_bdd, $dot_position + 1); //récupère toute la fin du nom de fichier à partir de la position du '.' : donc on récupère l'extension du fichier
        // $contenu .= debug($type_file);

        if ($type_file !== 'jpg' && $type_file !== 'jpeg' && $type_file !== 'png') {
            $contenu .= '<div class="alert alert-danger">Ce type de fichier n\'est pas autorisé</div>';
        }
        if (empty($contenu)) {// s'il n'y a pas d'erreur
            copy($_FILES['photo']['tmp_name'], '../' . $photo_bdd); // on copie le fichier photo temporaire qui est dans $_FILES['photo']['tmp_name'] vers le répertoire dont le chemin est "../photo/nom_fichier".
        }
    }


    if (empty($contenu)) {
        // insertion ou modification du contact en BDD s'il n'y a pas de message (d'erreur) stocké dans la variable $contenu

        // Pour gérer la modification il faut récupérer l'id_contact et injecter $_POST['id_contact'] dans le formulaire HTML via un champ qui sera caché à l'utilisateur. Ce champs sera renseigné grâce à une formule conditionnelle placée avant l'insertion du header et le formulaire HTML. Cette formule récupère le $_GET['id_produit'] rempli au click du bouton "modifier" (placé sur la page gestion_repertoire) et renseigne la data dans le tableau associatif $contact['id_contact'] qui est injectée dans l'input caché du formulaire afin d'alimenter $_POST['id_contact']
        $succes = executeRequete(
            "REPLACE INTO contact (id_contact, nom, prenom, telephone, email, type_contact, photo) VALUES (:id_contact, :nom, :prenom, :telephone, :email, :type_contact, :photo)",
            array(
                ':id_contact' => $_POST['id_contact'],
                ':nom' => $_POST['name'],
                ':prenom' => $_POST['firstName'],
                ':telephone' => $_POST['phone'],
                ':email' => $_POST['email'],
                ':type_contact' => $_POST['context'],
                ':photo' => $photo_bdd, // chemin de la photo uploadée qui est vide par défaut
            )
        );

        if ($succes) { // si on a reçu un objet PDOStatement c'est que la requête a marché
            $contenu .= '<div class="alert alert-success">Le contact a été ajouté</div>';
        } else { // sinon on a reçu false, la requête n'a pas marché
            $contenu .= '<div class="alert alert-danger">Une erreur est survenue ...</div>';
        }
    }
}

if (isset($_GET['id_contact'])) { // si 'id_contact' est dans l'URL, c'est qu'on a demandé la modification d'un contact
    $resultat = executeRequete("SELECT * FROM contact WHERE id_contact = :id_contact", array(':id_contact' => $_GET['id_contact']));
    $contact = $resultat->fetch(PDO::FETCH_ASSOC); //$contact est un tableau associatif dont on va mettre les valeurs dans les champs de formulaire
    // debug($contact);
}

require_once '../inc/header.php';
?>

<h1>Formulaire de saisie de contact</h1>
<!-- insertion dans la page des messages d'erreur lors du controle des éléments du formulaire-->
<?= $contenu; ?>

<!-- Formulaire HTML qui servira pour l'insertion de nouveau contact mais aussi pour la modification de contact existant -->
<div>
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- on indique bien l'attribut enctype="multipart/form-data" car on veut que le formulaire envoie des données binaires (fichier : ici une photo à uploader) et du texte (champs du formulaire). -->

        <!-- pour la gestion de modification dans le traitement PHP, on indique dans le formulaire un input qui sera caché à l'utilisateur, pour récupérer la donnée de l'id_contact -->
        <input type="hidden" name="id_contact" value="<?php echo $contact['id_contact'] ?? 0; ?>">

        <div><label for="name">Nom</label></div>
        <div><input type="text" name="name" id="name" value="<?php echo $contact['nom'] ?? ''; ?>"></div>
        <!-- traitement PHP sur l'attribut 'value' pour permettre la modification du contact, et le préremplissage du formulaire avec les données déjà présentes en BDD. -->

        <div><label for="firstName">Prénom</label></div>
        <div><input type="text" name="firstName" id="firstName" value="<?php echo $contact['prenom'] ?? ''; ?>"></div>
        <!-- traitement PHP sur l'attribut 'value' pour permettre la modification du contact, et le préremplissage du formulaire avec les données déjà présentes en BDD. -->

        <div><label for="phone">Téléphone</label></div>
        <div><input type="tel" name="phone" id="phone" value="<?php echo $contact['telephone'] ?? ''; ?>"></div>
        <!-- traitement PHP sur l'attribut 'value' pour permettre la modification du contact, et le préremplissage du formulaire avec les données déjà présentes en BDD. -->

        <div><label for="email">Email</label></div>
        <div><input type="email" name="email" id="email" value="<?php echo $contact['email'] ?? ''; ?>"></div>
        <!-- traitement PHP sur l'attribut 'value' pour permettre la modification du contact, et le préremplissage du formulaire avec les données déjà présentes en BDD. -->

        <div><label for="context">Contexte de connaissance</label></div>
        <div><select name="context" id="context">
                <option value="ami">Ami</option>
                <option value="famille" <?php if (isset($contact['type_contact']) && $contact['type_contact'] == 'famille') echo 'selected'; ?>>Famille</option>
                <option value="professionel" <?php if (isset($contact['type_contact']) && $contact['type_contact'] == 'professionel') echo 'selected'; ?>>Professionel</option>
                <option value="autre" <?php if (isset($contact['type_contact']) && $contact['type_contact'] == 'autre') echo 'selected'; ?>>Autre</option>
                <!-- <option value="test">test</option> -->
                <!-- test d'ajout d'une possibilité de choisir 'test' dans la liste pour vérifier le contrôle bloquant-->
            </select></div>
        <!-- traitement PHP sur l'attribut 'value' pour permettre la modification du contact, et le préremplissage du formulaire avec les données déjà présentes en BDD. -->


        <div><label for="photo">Photo</label></div>
        <div><input type="file" name="photo"></div>
        <!-- Le type="file" permet de remplir la superglobale $_FILES. Le name="photo" correspond à l'indice de $_FILES['photo'].  -->

        <?php
        if (isset($contact['photo'])) { //si existe $contact['photo'] c'est que nous sommes en train de modifier le contact
            echo '<div>Photo actuelle du contact</div>';
            echo '<div><img style="width:80px;" src="../' . $contact['photo'] . '"></div>'; // on affiche la photo actuelle dont le chemin est dans le champs "photo" de la BDD donc dans $contact
            echo '<input type="hidden" name="photo_actuelle" value="' . $contact['photo'] . '">'; // on crée ce champs caché pour remettre le chemin de la photo actuelle dans le formulaire, donc dans $_POST à l'indice'photo_actuelle'. ainsi on ré-insère ce chemain en BDD lors de la modification
        }
        ?>


        <div class="mt-3"><input type="submit" value="Enregistrement du contact" class="btn btn-info"></a></div>

    </form>
</div>
<?php require_once '../inc/footer.php';
