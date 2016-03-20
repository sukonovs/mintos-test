Mintos test
=========

*Installation*

* Set up parameters
* "composer install"
* "php app/console doctrine:database:create"
* "php app/console doctrine:schema:create"
* "php app/console doctrine:fixtures:load"

*Notes*

* 10 investors are seeded in database, investor_1, investor_2 .. investor_10. password: demo.
* my choice of database type was PostgreSQL
* I am not aware of all best Symfony framework practices at this moment, so there could be some mistakes
* Documentation lacks information about multiple investments in one loan, I assumed multiple investments in one loan are allowed
* Did not extracted app logic form controllers, as I don't know desirable strategy for this test
* I choose redirect for access control logic instead of HTTP codes
