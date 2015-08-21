<?php

        /**
        * @backupGlobals disabled
        * @backupStaticAttributes disabled
        */

        require_once "src/Stylist.php";
        require_once "src/Client.php";

        $server = 'mysql:host=localhost:8889;dbname=test_hair_salon';
        $username = 'root';
        $password = 'root';
        $DB = new PDO($server, $username, $password);

        class ClientTest extends PHPUnit_Framework_TestCase
        {
            protected function tearDown()
            {
                Client::deleteAll();
                Stylist::deleteAll();
            }

            function test_getId()
            {
                //Arrange
                $name = "Vicki";
                $id = null;
                $test_stylist = new Stylist($name, $id);
                $test_stylist->save();

                $client = "Aalto";
                $phone = "123-456-7890";
                $stylist_id = $test_stylist->getId();
                $test_client = new Client($client, $phone, $stylist_id, $id);
                $test_client->save();

                //Act
                $result = $test_client->getId();

                //Assert
                $this->assertEquals(true, is_numeric($result));
            }

            function test_getStylistId()
            {
                //Arrange
                $name = "Becky";
                $id = null;
                $test_stylist = new Stylist($name, $id);
                $test_stylist->save();

                $client = "Jim";
                $phone = "123-456-7890";
                $stylist_id = $test_stylist->getId();
                $test_stylist = new Client($client, $phone, $stylist_id, $id);
                $test_stylist->save();

                //Act
                $result = $test_stylist->getStylistId();

                //Assert
                $this->assertEquals(true, is_numeric($result));
            }

            function test_save()
            {
                //Arrange
                $name = "Becky";
                $id = null;
                $test_stylist = new Stylist($name, $id);
                $test_stylist->save();

                $client = "Sam";
                $phone = "123-456-7890";
                $stylist_id = $test_stylist->getId();
                $test_client = new Client($client, $phone, $stylist_id, $id);

                //Act
                $test_client->save();

                //Assert
                $result = Client::getAll();
                $this->assertEquals($test_client, $result[0]);
            }

            function test_getAll()
            {
                //Arrange
                $name = "Becky";
                $id = null;
                $test_stylist = new Stylist($name, $id);
                $test_stylist->save();

                $client = "Mark";
                $phone = "123-456-6754";
                $stylist_id = $test_stylist->getId();
                $test_client = new Client($client, $phone, $stylist_id, $id);
                $test_client->save();

                $client2 = "Jim";
                $phone2 = "123-667-7890";
                $stylist_id2 = $test_stylist->getId();
                $test_client2 = new Client($client, $phone, $stylist_id, $id);
                $test_client2->save();

                //Act
                $result = Client::getAll();

                //Assert
                $this->assertEquals([$test_client, $test_client2], $result);

            }
        }

 ?>
