<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

$db->Execute("DELETE FROM ". TABLE_PRODUCTS_REVIEWS ." WHERE language_code = '".$new_id."'");
