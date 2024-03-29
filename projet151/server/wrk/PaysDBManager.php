<?php
require_once('wrk/Connexion.php');
require_once('bean/Pays.php');
class PaysDBManager
{
    private $Connexion;

    public function __construct()
    {


        $this->Connexion = connexion::getInstance();
    }

    public function ajouterPays($nom_pays)
{
    $result = "";
    try {
        $test = connexion::getInstance()->startTransaction();

        $param = array(':nom_pays' => $nom_pays);
        $query = connexion::getInstance()->executeQuery("INSERT INTO `monumentheritage`.`t_pays` (`nom`) VALUES (:nom_pays)", $param);

        if ($query == 1) {
            http_response_code(200);
            $result = json_encode(array("IsOk" => true, "message" => "Ajout du pays réussi"));
            $test = connexion::getInstance()->commitTransaction();
        } else {
            http_response_code(200);
            $result = json_encode(array("IsOk" => false, "message" => "Erreur lors de l'ajout du pays"));
            $test = connexion::getInstance()->rollbackTransaction();
        }
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur et retourner false
        echo "Erreur lors de l'ajout du pays : " . $e->getMessage();
        $test = connexion::getInstance()->rollbackTransaction();
    }
    return $result;
}

    
    public function récupérerTousPays()
    {
        try {
            $test = connexion::getInstance()->startTransaction();
            $test = connexion::getInstance()->selectQuery("SELECT nom FROM pays");
            if ($test >= 1) {
                foreach ($test as $row) {
                    echo json_encode($row);
                    $test = connexion::getInstance()->commitTransaction();

                }
            } else {
                echo "Erreur lors de la récupération des pays";
            }
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur et retourner false
            echo "Erreur lors de la récupération des pays : " . $e->getMessage();
            $test = connexion::getInstance()->rollbackTransaction();

        }
    }
    public function récupérerPays($pk_Pays)
    {
        try {
            $test = connexion::getInstance()->startTransaction();
            $param = array(':pk_Pays' => $pk_Pays);
            $query = connexion::getInstance()->selectQuery("SELECT * FROM t_pays WHERE PK_Pays = :pk_Pays");
            if ($query >= 11) {
                foreach ($query as $row) {
                    echo json_encode($row);
                    $query = connexion::getInstance()->commitTransaction();

                }
            }
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur et retourner false
            echo "Erreur lors de la récupération du pays : " . $e->getMessage();
            $test = connexion::getInstance()->rollbackTransaction();
        }
    }
    public function updatePays($pk_Pays, $nom_pays)
    {
        $test = connexion::getInstance()->startTransaction();
        $param = array(':nom_pays' => $nom_pays, 'pk_Pays' => $pk_Pays);

        $query = connexion::getInstance()->executeQuery("UPDATE pays SET nom = :nom_pays WHERE PK_Pays = :pk_Pays", $param);
        if ($query == 1) {
            echo json_encode($query);
            $test = connexion::getInstance()->commitTransaction();

        } else {
            echo 'Erreur avec la modification de pays';
            $test = connexion::getInstance()->rollbackTransaction();

        }


    }
}
?>