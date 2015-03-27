<?php

require_once ($RootDir.'managers/abstract/MapElementSvgManager.php');
require_once ($RootDir.'models/map/Departement.php');
require_once ($RootDir.'models/map/Arrondissement.php');
require_once ($RootDir.'models/map/Commune.php');

class ArrondissementManager extends MapElementSvgManager{

    // add a arrondissement entry to the database
    public function add( $arr ){
        $q = $this->_db->prepare(
            'INSERT INTO `departement` SET '
            .'`arr_code` = :code, '
            .'`arr_name` = :name, '
            .'`arr_svg` = :svg, '
            .'`dep_no` = :reg '
        );
        $q->bindValue(':code', $dep->getId());
        $q->bindValue(':name', $dep->getName());
        $q->bindValue(':svg', $dep->getSvg());
        $q->bindValue(':reg', $dep->getParent());
        $q->execute();
    }

    // not necessary
    public function delete( $id ){
    }

    // get the arrondissement object from the database based on its arr_code
    public function get( $id ){
        $q = $this->_db->query('SELECT * FROM `arrondissement` WHERE `arr_code` = '.$id);
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new Arrondissement($data);
        }
    }
    // get the arrondissement object from the database based on its arr_name
    public function getByName( string $name ){
        $q = $this->_db->query('SELECT * FROM `arrondissement` WHERE `arr_name` = '.$name);
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new Arrondissement($data);
        }
    }
    // get the arrondissement object from the database based on its arr_svg
    public function getBySvg( string $svg ){
        $q = $this->_db->query('SELECT * FROM `arrondissement` WHERE `arr_svg` = '.$svg);
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new Arrondissement($data);
        }
    }
    // gives the parent arrondissement of this commune object
    public function getByCommune( Commune $com ){
        $q = $this->_db->query('SELECT * FROM `arrondissement` NATURAL JOIN `commune` WHERE `com_code`="'.$com->getId().'"');
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new Arrondissement($data);
        }
    }
    // gives the parent arrondissement of this commune name
    public function getByCommuneName( string $name ){
        $name = (string) $name;
        $q = $this->_db->query('SELECT * FROM `arrondissement` NATURAL JOIN `commune` WHERE `com_name`="'.$name.'"');
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new Arrondissement($data);
        }
    }

    // get list of all arrondissements
    public function getList(){
        $arrondissements = [];
        $q = $this->_db->query('SELECT * FROM `arrondissement` ORDER BY `arr_name`');
        while ($data = $q->fetch(PDO::FETCH_ASSOC)){
            $arrondissements[] = new Arrondissement($data);
        }
        return $arrondissements;
    }
    // get list of all arrondissements in the given departement
    public function getListByParent( $dep ){
        $arrondissements = [];
        $q = $this->_db->query('SELECT * FROM `arrondissement` WHERE `dep_no`="'.$dep->getId().'" ORDER BY `arr_name`');
        while ($data = $q->fetch(PDO::FETCH_ASSOC)){
            $arrondissements[] = new Arrondissement($data);
        }
        return $arrondissements;
    }

    // update the arrondissement object in the database
    public function update( $arr ){
        $q = $this->_db->prepare(
            'UPDATE `arrondissement` SET '
            .'`arr_name` = :name, '
            .'`arr_svg` = :svg, '
            .'`dep_no` = :dep '
            .'WHERE `arr_code` = :code'
        );
        $q->bindValue(':code', $dep->getId());
        $q->bindValue(':name', $dep->getName());
        $q->bindValue(':svg', $dep->getSvg());
        $q->bindValue(':dep', $dep->getParent());
        $q->execute();
    }

}