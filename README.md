## Installation
### Clone the repository

### Set up your database 

In the .env file, find 
>DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name

And fill in your database options.

Create new database and run migration simply by executing:

```./bin/console doctrine:database:create``` 

```./bin/console doctrine:migrations:migrate``` 


## Usage


### Make new order
Run :
```./bin/console server:run``` 
This command will start listening to port 8000 of your localhost, then go to: *localhost:8000* and enjoy playing Tic Tac Toe