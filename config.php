<?php

require 'lib/functions.php';

defined("DS") ? NULL : define("DS", DIRECTORY_SEPARATOR);
defined("PS") ? NULL : define("PS", "/");
defined("WEB_PATH") ? NULL : define("WEB_PATH", "http://".$_SERVER['HTTP_HOST'].PS.'www.russlls-famous-cookies.com'.PS);
defined("SERVER_PATH") ? NULL : define("SERVER_PATH", $_SERVER['DOCUMENT_ROOT'].DS.'www.russlls-famous-cookies.com'.DS);
defined("PUBLIC_PATH") ? NULL : define("PUBLIC_PATH", WEB_PATH."public".PS);
defined("LAYOUT_PATH") ? NULL : define("LAYOUT_PATH", SERVER_PATH."public".DS."layouts".DS);
defined("CSS_PATH") ? NULL : define("CSS_PATH", PUBLIC_PATH."styles".PS);
defined("JS_PATH") ? NULL : define("JS_PATH", PUBLIC_PATH."scripts".PS);
defined("PRODUCT_IMAGES_PATH") ? NULL : define("PRODUCT_IMAGES_PATH", WEB_PATH."images".PS.'products'.PS);
defined("NEWS_IMAGES_PATH") ? NULL : define("NEWS_IMAGES_PATH", WEB_PATH."images".PS.'news'.PS);
defined("BLOG_IMAGES_PATH") ? NULL : define("BLOG_IMAGES_PATH", WEB_PATH."images".PS.'blog-post'.PS);
defined("API_LOGIN_ID") ? NULL : define("API_LOGIN_ID", "5qG46RqfQ3");
defined("API_TRANSACTION_KEY") ? NULL : define("API_TRANSACTION_KEY", "54fyr4v3W666Z7Pf");
defined("SHIPPING_CHARGES_OPT1") ? NULL : define("SHIPPING_CHARGES_OPT1", "5.00");
defined("SHIPPING_CHARGES_OPT2") ? NULL : define("SHIPPING_CHARGES_OPT2", "11.35");