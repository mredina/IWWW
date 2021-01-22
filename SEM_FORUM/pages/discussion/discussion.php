<?php

if (!Authentication::getInstance()->hasIdentity()) {
    exit(header('Location: ' . BASE_URL . '?page=login'));
}

else {
    if (isset($_GET['category'])) {
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'delete_category') {
                require 'category/delete_category.php';
            }
            else if ($_GET['action'] == 'delete_thread') {
                require 'thread/delete_thread.php';
            }
            else if ($_GET['action'] == 'uzavrit') {
                require 'thread/close_thread.php';
            }
        }
        if (isset($_GET['thread'])) {
            if (isset($_GET['comment'])) {
                if (isset($_GET['action'])) {
                    if ($_GET['action'] == 'delete') {
                        require 'comment/delete_comment.php';
                    }

                    else if ($_GET['action'] == 'like') {
                        require 'comment/like_comment.php';
                    }

                    else if ($_GET['action'] == 'zobrazit') {
                        //require 'comment/show_comment.php';
                        echo "V přípravě";
                    }
                    else if ($_GET['action'] == 'update') {
                        require 'comment/update_comment.php';
                    }
                    else if ($_GET['action'] == 'nahlasit') {
                        require 'comment/report_comment.php';
                    }
                    else {

                        require 'thread/thread.php';

                    }
                } else {
                    require 'thread/thread.php';
                }

            } else {

                    require 'thread/thread.php';


            }
        } else {

            require 'thread/threads.php';
        }
    } else {
        require 'category/categories.php';
    }
}


