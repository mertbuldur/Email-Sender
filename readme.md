Welcome to basic email sender management program

1. Import to Sql your database.

You can use the following code to add a transaction to the database.

$processor->add("buldurmert@gmail.com","test","Merhaba bu task ile gönderiliyor...");

forward to a future date.

$processor->add("buldurmert@gmail.com","test","Merhaba bu task ile gönderiliyor...","2019-03-21 12:00:00");

$processor->start(); // sender mail method