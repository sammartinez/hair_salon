<?php

        class Client
        {
            private $name;
            private $phone;
            private $stylist_id;
            private $id;

            //Constructors
            function __construct($name, $phone, $stylist_id, $id)
            {
                $this->name = $name;
                $this->phone = $phone;
                $this->stylist_id = $stylist_id;
                $this->id = $id;
            }

            //Getters
            function getName()
            {
                return $this->name;
            }

            function getPhone()
            {
                return $this->phone;
            }

            function getStylistId()
            {
                return $this->stylist_id;
            }

            function getId()
            {
                return $this->id;
            }

            //Setters
            function setName($new_name)
            {
                $this->name = (string) $new_name;
            }

            function setPhone($new_phone)
            {
                $this->phone = $new_phone;
            }

            //Save function
            function save()
            {
                $GLOBALS['DB']->exec("INSERT INTO client (name, phone, stylist_id) VALUES ('{$this->getName()}', '{$this->getPhone()}', {$this->getStylistId()});");
                $this->id = $GLOBALS['DB']->lastInsertId();
            }

            //Update Function
            function update($new_name)
           {
               $GLOBALS['DB']->exec("UPDATE client SET name = '{$new_name}' WHERE id = {$this->getId()};");
           }

            //Delete function
            function delete()
            {
                $GLOBALS['DB']->exec("DELETE FROM client WHERE id = {$this->getId()};");
            }

            //Static Functions
            static function getAll()
            {
                $returned_clients = $GLOBALS['DB']->query("SELECT * FROM client;");
                $clients = array();

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

            static function deleteAll()
            {
                $GLOBALS ['DB']->exec("DELETE FROM client;");
            }

            static function find($search_id)
            {
                $found_client = null;
                $clients = Client::getAll();

                foreach($clients as $client) {
                    $client_id = $client->getId();
                    if ($client_id == $search_id) {
                        $found_client = $client;
                    }
                }
                return $found_client;
            }
        }

 ?>
