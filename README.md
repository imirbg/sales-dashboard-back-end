# Sales Dashboard Back End

### Running on Apache
1. change the name of the **.env.example** to **.env**
2. put your MYSQL database information and other configurations in the **.env** and **.php-database-migration/environments/dev.yml** file
3. execute following commands one by one 
```
php composer.phar install
./bin/migrate migrate:init dev
./bin/migrate migrate:up dev

```
4. seed some data into database by hitting **/add-new-customers** route(each time 100 customers will be added to database along with some orders)

