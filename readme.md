<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>



## About The project 
Graduation_Project  It's a web app based on LARAVEL 5.4 which fixed a significant real problem on the Departement of Computer science making the interaction between students , teachers (mentors) and companies the smoother and better possible for graduation projects and internships in order to find the best satisfying matching between Student and Teachers / Companies !
The Language of the app in its first version is the French .

<a href="https://ibb.co/cQnF0YN"><img src="https://i.ibb.co/GRS2yHV/Capture1.png" alt="Capture1" border="0"></a>
<a href="https://ibb.co/Mkzpscw"><img src="https://i.ibb.co/HTcYVtw/Capture2.png" alt="Capture2" border="0"></a>
<a href="https://ibb.co/M6V5Wrw"><img src="https://i.ibb.co/fvpGBf6/Screenshot-2017-05-30-20-54-25.png" alt="Screenshot-2017-05-30-20-54-25" border="0"></a>
<a href="https://ibb.co/ns38KfQ"><img src="https://i.ibb.co/ynhBx5g/Screenshot-2017-05-29-22-55-48.png" alt="Screenshot-2017-05-29-22-55-48" border="0"></a>

For further screenshots please checkout this link
https://www.dropbox.com/sh/8hoccm6gs55e2x2/AAAn9qX0WBBcKe2eSVY_rR8xa?dl=0


## Requirements
- PHP >= 5.6
- APACHE
- MYSQL
- LARAVEL 5.4
- composer 
- Javascript activated on your web browser 

### Note :
- You can group ( PHP , APACHE , MYSQL ) in just one tool  lamp ( on linux )  wamp ( for windows ) and mamp ( for Mac OS ) 

## Testing 
1) git clone https://github.com/raoufkeskes/Graduation_Project.git projectname
2) cd projectname
3) composer install
4) php artisan key:generate to regenerate secure key
5) use test.sql as a database and edit .env file for your DB settings
6) edit .env file for APP configuration and Email sending system :
    you can use this email in your env configuration : 
    ```
    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=pfeemailtest@gmail.com
    MAIL_PASSWORD=123456aA-
    MAIL_ENCRYPTION=tls
    ```
7) run this command : 
    ``` php artisan serve ```
8) This command will start a development server at http://localhost:8000:
9) Explore  Routes for more app understanding !

## License
June,2017
[MIT license](http://opensource.org/licenses/MIT).
