<?php


        class Stylist
        {
            private $stylist_name;
            private $id;

            //Constructors
            function __construct($stylist_name, $id = null)
            {
                $this->stylist_name = $stylist_name;
                $this->id = $id;
            }

            //Getters
            function getStylistName()
            {
                return $this->stylist_name;
            }

            function getId()
            {
                return $this->id;
            }

            //Setters
            function setStylistName($new_stylist_name)
            {
                $this->stylist_name = (string) $new_stylist_name;
            }

            function getClients()
            {
                $clients = array();
                $returned_clients = $GLOBALS['DB']->query("SELECT * FROM client WHERE stylist_id = {$this->getId()};");

                foreach($returned_clients as $client) {
                    $name = $client['name'];
                    $phone = $client['phone'];
                    $stylist_id = $client['stylist_id'];
                    $id = $client['id'];
                    $new_client = new Client($name, $phone, $stylist_id, $id);
                    array_push($clients, $new_client);
                }

                return $clients;
            }

            //Save function
            function save()
            {
                $GLOBALS['DB']->exec("INSERT INTO stylist (name) VALUES ('{$this->getStylistName()}')");
                $this->id = $GLOBALS['DB']->lastInsertId();
            }

            //Delete function
            function delete()
            {
                $GLOBALS['DB']->exec("DELETE FROM stylist WHERE id = {$this->getId()};");
            }

            //Update function
            function update($new_stylist_name)
            {
                $GLOBALS['DB']->exec("UPDATE stylist SET name = '{$new_stylist_name}' WHERE id = {$this->getId()};");
                $this->setStylistName($new_stylist_name);
            }

            //Static Functions
            static function getAll()
            {
                $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylist;");
                $stylists = array();

                foreach($returned_stylists as $stylist) {
                    $name = $stylist['name'];
                    $id = $stylist['id'];
                    $new_stylist = new Stylist($name, $id);
                    array_push($stylists, $new_stylist);
                }
                return $stylists;
            }

            static function deleteAll()
            {
                $GLOBALS['DB']->exec("DELETE FROM stylist;");
            }

            static function find($search_id)
            {
                $found_stylist = null;
                $stylists = Stylist::getAll();

                foreach($stylists as $stylist) {
                    $stylist_id = $stylist->getId();

                    if($stylist_id == $search_id) {
                        $found_stylist = $stylist;
                    }
                }
                return $found_stylist;
            }

        }


 ?>
