<?php

//fonction pour l'aide au debug et verification du code lors de la construction du site
function debug($variable)
{
    echo '<pre>';
    print_r($variable);
    echo '</pre>';
}



// fonction qui exécute des requêtes

function executeRequete($requete, $param = array())
{// le paramètre $requete attend de recevoir une requête SQL sous forme de string. $param attend un array avec les marqueurs associés à leur valeur. Ce paramètre est optionnel car on lui a affecté un array() vide par défaut

    foreach ($param as $indice => $valeur) {
        $param[$indice] = htmlspecialchars($valeur);
    } // htmlspecialchars transforme les chevrons pour neutraliser les balises <script> et <style> Dans cette boucle on prend à chaque tour de boucle la valeur du tableau $param que l'on échappe et que l'on réaffecte à son emplacement d'origine 

    global $pdo; // on accède à la variable globale $pdo qui est déinie dans init.php à l'extérieur de cette fonction

    // requête préparée
    $resultat = $pdo->prepare($requete); // on prépare la requête envoyée à notre fonction
    $succes = $resultat->execute($param); // puis on exécute la requête en lui passant le tableau qui contient les marqueurs et leur valeurs pour faire les bindParam (cette opération est faite même si elle n'est pas écrite dans le code). On récupère dans la variable $succes true si la requête a marché sinon false

    if ($succes) {
        return $resultat; // si $succes contient true, la requête a marché, je retourne le résultat de ma requête
    } else {
        return false; // si la requête n'a pas marché on retourne false
    }
}

