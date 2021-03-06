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

        class StylistTest extends PHPUnit_Framework_TestCase
        {

                protected function tearDown()
                {
                    Stylist::deleteAll();
                    Client::deleteAll();
                }

                function test_GetClients()
                {
                      //Arrange
                      $name = "Becky";
                      $id = null;
                      $test_stylist = new Stylist($name, $id);
                      $test_stylist->save();

                      $name = "Sam";
                      $phone = "123-456-7890";
                      $stylist_id = $test_stylist->getId();
                      $id = 1;
                      $test_client = new Client($name, $phone, $stylist_id, $id);
                      $test_client->save();

                      $name2 = "Sammy";
                      $phone2 = "345-567-9812";
                      $stylist_id2 = $test_stylist->getId();
                      $id = 2;
                      $test_client2 = new Client($name, $phone, $stylist_id, $id);
                      $test_client2->save();

                      //Act
                      $result = $test_stylist->getClients();

                      //Assert
                      $this->assertEquals([$test_client, $test_client2], $result);
                }

                function test_getStylistName()
                {
                    //Arrange
                    $name = "vicki";
                    $test_stylist = new Stylist($name);

                    //Act
                    $result = $test_stylist->getStylistName();

                    //Assert
                    $this->assertEquals($name, $result);
                }

                function test_save()
              {
                  //Arrange
                  $name = "vicki";
                  $test_stylist = new Stylist($name);
                  $test_stylist->save();

                  //Act
                  $result = Stylist::getAll();

                  //Assert
                  $this->assertEquals($test_stylist, $result[0]);
              }

              function test_getAll()
              {
                  //Arrange
                  $name = "vicki";
                  $test_stylist = new Stylist($name);
                  $test_stylist->save();

                  //Act
                  $result = Stylist::getAll();

                  //Assert
                  $this->assertEquals([$test_stylist], $result);
              }

              function test_deleteAll()
              {
                  //Arrange
                  $name = "vicki";
                  $test_stylist = new Stylist($name);
                  $test_stylist->save();

                  //Act
                  Stylist::deleteAll();
                  $result = Stylist::getAll();

                  //Assert
                  $this->assertEquals([], $result);

              }

              function test_getId()
              {
                  //Arrange
                  $name = "vicki";
                  $id = 1;
                  $test_stylist = new Stylist($name, $id);

                  //Act
                  $result = $test_stylist->getId();

                  //Assert
                  $this->assertEquals(true, is_numeric($result));
              }

              function test_find()
              {

                  //Arrange
                  $name = "vicki";
                  $test_stylist = new Stylist($name);
                  $test_stylist->save();

                  //Act
                  $result = Stylist::find($test_stylist->getId());

                  //Assert
                  $this->assertEquals($test_stylist, $result);
              }

              function test_update()
              {
                  //Arrange
                  $name = "vicki";
                  $id = null;
                  $test_stylist = new Stylist($name, $id);
                  $test_stylist->save();

                  $new_stylist_name = "barb";

                  //Act
                  $test_stylist->update($new_stylist_name);

                  //Assert
                  $this->assertEquals("barb", $test_stylist->getStylistName());
              }

              function testDelete()
              {
                  //Arrange
                  $name = "vicki";
                  $id = null;
                  $test_stylist = new Stylist($name, $id);
                  $test_stylist->save();

                  $name2 = "barb";
                  $test_stylist2 = new Stylist($name2, $id);
                  $test_stylist2->save();

                  //Act
                  $test_stylist->delete();

                  //Assert
                  $this->assertEquals([$test_stylist2], Stylist::getAll());
              }
        }
 ?>
