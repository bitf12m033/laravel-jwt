## About Repository

This repository is based on Laravel framework and developed the RESTful API using the JWT authentication for registration and authenticaion of user.Integrated the Stripe API to charge. Also written the test cases for the User and Payment. This application is connected with MySQL as well as mongodb.
To run this on local machine simply follow the below steps.

- Clone this repo.
- Go to project folder e.g. **laravel-jwt**
- Run command **composer update** to install packages.(Assuming Composer is installed on your device)
- Setup MySQL database using the **.env** file for database name and database credentials.
- Setup mongodb in your system. Make sure php_mongodb.dll is present in php extensions.
- Install mongodb package for laravel using **composer require jenssegers/mongodb**
- Setup mongodb credentials in **.env** file against mongodb constants.
- Now run command **php artisan serve** to start your app. Make sure you re in root directory of the project.
- [Localhost app link](http://127.0.0.1:8000/). http://127.0.0.1:8000/


## Api Endpoints

- [http://127.0.0.1:8000/api/register](http://127.0.0.1:8000/api/register).
    - **Method**
        - POST
    - **Request Data**
        - name
        - email
        - password
        - password_confirmation
    - **Response JSON**
        - user obejct
        - token
        - Error if any   
- [http://127.0.0.1:8000/api/login](127.0.0.1:8000/api/login).
     - **Method**
        - POST
     - **Request Data**
        - email
        - password
    - **Response JSON**
        - token 
        - Error if any
- [http://127.0.0.1:8000/api/user](127.0.0.1:8000/api/user)
     - **Method**
        - GET
     - **Request Data**
        - Header Authorization: Bearer Token
     - **Response JSON**
        - User Object 
        - Error if any
- [http://127.0.0.1:8000/api/pay](http://127.0.0.1:8000/api/pay)
  - **Method**
      - POST  
  - **Request Data**
      - card_number
      - cvc
      - card_holder
      - expiry (month/year , 03/24)
      - user_id
      - amount 
  - **Response**
      - Payment Object
      - Error if any.  

## Laravel Test Cases
- Run command **php artisan test** to execute all tests. 


