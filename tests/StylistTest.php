<?php

        /**
        * @backupGlobals disabled
        * @backupStaticAttributes disabled
        */

        require_once "src/Stylist.php";
        //require_once "src/Client.php";

        $server = 'mysql:host=localhost:8888;dbname=test_hair_salon';
        $username = 'root';
        $password = 'root';
        $DB = new PDO($server, $username, $password);

        class StylistTest extends PHPUnit_Framework_TestCase
        {

                protected function tearDown()
                {
                    Stylist::deleteAll();
                }

                function test_getStylistName()
                {
                    //Arrange
                    $name = "Vicki";
                    $test_stylist = new Stylist($name);

                    //Act
                    $result = $test_stylist->getStylistName();

                    //Assert
                    $this->assertEquals($name, $result);
                }

                function test_save()
              {
                  //Arrange
                  $name = "Vicki";
                  $test_stylist = new Stylist($name);
                  $test_stylist->save();

                  //Act
                  $result = Stylist::getAll();

                  //Assert
                  $this->assertEquals($test_stylist, $result[0]);
              }
        }
 ?>
