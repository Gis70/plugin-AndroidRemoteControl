/*
 * This file is part of the NextDom software (https://github.com/NextDom or http://nextdom.github.io).
 * Copyright (c) 2018 NextDom.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 2.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

<?php

require_once (dirname(__FILE__).'/../config/common.config.php');

/**
 * Mocked des requêtes
 */
class MockedStatement
{
    /**
     * @var Requête SQL
     */
    private $query;
    /**
     * @var Données de la requête
     */
    private $data;

    /**
     * Constructeur
     *
     * @param $query Requête SQL
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * Mock de l'exécution d'une requête
     *
     * @param array $data Données de la requête
     */
    public function execute($data = null)
    {
        $this->data = $data;
        MockedActions::add('query_execute', array('query' => $this->query, 'data' => $this->data));
    }

    /**
     * Obtenir les résultats d'une requête
     *
     * @param integer $fetchMethod Méthode de récupération (inutilisé)
     *
     * @return mixed Données définies par DB::setAnswer au format PDO
     */
    public function fetchAll($fetchMethod)
    {
        return DB::$answer;
    }
}

/**
 * Mock de la classe PDO
 */
class MockedPDO
{
    public function prepare($query)
    {
        return new MockedStatement($query);
    }
}

/**
 * Mock de la classe DB de Jeedom
 */
class DB
{
    /**
     * @var Connexion à la base de données
     */
    private static $connection = null;

    /**
     * @var Réponse à fournir à une requête
     */
    public static $answer;

    /**
     * Initialisation de la connexion
     */
    public static function init($useRealDB = false)
    {
        if ($useRealDB) {
            global $CONFIG;
            static::$connection = new PDO('mysql:host=' . $CONFIG['db']['host'] . ';port=' . $CONFIG['db']['port'] . ';dbname=' . $CONFIG['db']['dbname'], $CONFIG['db']['username'], $CONFIG['db']['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_PERSISTENT => true));
        }
        else {
            static::$connection = new MockedPDO();
        }
    }

    /**
     * @return Connexion Obtenir l'objet de la connexion
     */
    public static function getConnection()
    {
        return static::$connection;
    }

    /**
     * @param mixed $answer Définir la réponse à une requête
     */
    public static function setAnswer($answer)
    {
        if ($answer !== null) {
            static::$answer = array($answer);
        } else {
            static::$answer = array();
        }
    }
}
