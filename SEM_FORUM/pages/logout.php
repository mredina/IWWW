<?php
Authentication::getInstance()->logout();
exit(header('Location: ' . BASE_URL . '?page=login'));
