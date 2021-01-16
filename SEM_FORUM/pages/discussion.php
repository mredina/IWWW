<?php

if (!Authentication::getInstance()->hasIdentity()) {
    exit(header('Location: ' . BASE_URL . '?page=login'));
}

else {
    if (isset($_GET['category'])) {
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'deleteK') {
                require 'discussion/deleteK.php';
            }
            else if ($_GET['action'] == 'deleteT') {
                require 'discussion/deleteT.php';
            }
            else if ($_GET['action'] == 'uzavrit') {
                require 'discussion/uzavritThread.php';
            }
        }
        if (isset($_GET['thread'])) {
            if (isset($_GET['comment'])) {
                if (isset($_GET['action'])) {
                    if ($_GET['action'] == 'delete') {
                        require 'discussion/comment/delete.php';
                    }

                    else if ($_GET['action'] == 'like') {
                        require 'discussion/comment/like.php';
                    }

                    else if ($_GET['action'] == 'zobrazit') {
                        require 'discussion/comment/zobrazit.php';
                    }
                    else if ($_GET['action'] == 'update') {
                        require 'discussion/comment/update.php';
                    }
                    else if ($_GET['action'] == 'nahlasit') {
                        require 'discussion/comment/nahlasit.php';
                    }
                    else {

                        require 'discussion/thread.php';

                    }
                } else {
                    require 'discussion/thread.php';
                }

            } else {

                    require 'discussion/thread.php';


            }
        } else {

            require 'discussion/threads.php';
        }
    } else {
        require 'discussion/categories.php';
    }
}


