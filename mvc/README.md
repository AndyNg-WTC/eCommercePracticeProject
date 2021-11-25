# mvc_framework
## About
This is a custom PHP MVC (Model View Controller) framework template that you can use in your project.

Framework **v1.3** written in **PHP 8.0**.

### XAMPP

XAMPP version 8.0.8 was used when creating this framework.

[XAMPP 8.0.8 Download(sourceforge link)](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.0.8/)

### Database

You can create a simple database called `mvc` using the `app/mvc_db.sql` SQL file. The database includes 1 table and some sample data for you to make sure everything is working in the framework.

### Folder structure

The folder structure of the MVC framework is as follows:

```
- app
    - code
        - Module
            - Controller
            - Model
            - view
    - config
    - helpers
    - libraries
- public
    - css
    - images
    - js
```

<ins>**Note**</ins>: Users are restricted from directly browsing the `app` directory, and it's sub-directories. This is controlled in `/app/.htaccess`.

<br/>

A `Module` in the case of this framework, is a self-contained unit of code which provides functionality for the site.

For example: 
* The `Pages` module is responsible for loading specific site pages.
* The `User` module is responsible for anything user related, login, account creation, etc.

Each `Module` will have its own `Model`, `View`, and `Controller` directories and files.

<br/>

### Naming convention
#### Folder names
* The `Module` name must start with an uppercase letter e.g. `app/code/Pages`, `app/code/Post`, `app/code/User`.
* If the Module includes models, views and controllers, they must be in their own respective directories, `Model`,`view`, and `Controller`. 
<br/>
 **Note**: The first letter of model and controller is in upper case whereas the first letter of view is in lower case. 
The folder names are also singular.

#### File names
* The `Controller` and `Model` PHP files must have the same name as the `Module` name.
<br/>
E.g. `app/code/Pages/Controller/Pages.php` and `app/code/Pages/Model/Pages.php` 
* The files in the `view` folder must start in a lowercase letter.
<br/>
E.g. `app/code/Pages/view/index.php` , `app/code/Pages/view/about.php`

## Install

To install the framework, clone the repository using the following line:

```
git clone https://github.com/AndyNg-WTC/mvc_framework.git
```

## Usage

In order to use the MVC framework, you will need to edit the following files:


### `/app/config/Config.php`
This is the file which contains the database information, the site URL and site name.

```php
// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', '_YOUR_USER_');       //Your database user
define('DB_PASS', '_YOUR_PASS_');       //Your database user's password
define('DB_NAME', '_YOUR_DB_NAME_');    //Which database you are connecting to


// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// URL Root
define('URLROOT', '_YOUR_URL_');        // Your site's URL
// Site Name
define('SITENAME', '_YOUR_SITENAME_');  // Your site name
```

<br>

### `/public/.htaccess`

You will need to edit the `RewriteBase` to point to the `public` directory of the MVC framework located on your sever.

In the example below, if your framework has been cloned to a directory called `mvc` in your server's root directory, then the path will look like `/mvc/public`.

```
<IfModule mod_rewrite.c>
  Options -Multiviews
  RewriteEngine On
  RewriteBase /mvc/public
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule  ^(.+)$ index.php?url=$1 [QSA,L]
</IfModule>
```

## Creating and Using a Model

1. Create a model class with the same name as the Module in `app/code/<Module>/Model/`, for example `app/code/Post/Model/Post.php`.

```php
<?php

declare(strict_types=1);

namespace code\Pages\Model;

use libraries\Database;

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getPosts(): array
    {
        $this->db->query("SELECT * FROM posts");

        return $this->db->resultSet();
    }
}

```
The example model above will be used to deal with data related logic (CRUD) and will communicate with the database.


2. Within the `app/code/<module>/Controller/<controller>.php` class, load and use the `Model` in the methods, using the `model` method from the `libraries\Controller.php` class.

```php
declare(strict_types=1);

namespace code\Post\Controller;

use libraries\Controller;

class Post extends Controller
{
    public function posts(): void
        {
            // setting postModel method
            $this->postModel = $this->model($this->getModule(__FILE__), $this->getModule(__FILE__));
    
            $posts = $this->postModel->getPosts();
            $data = [
                'title' => 'Posts from DB',
                'posts' => $posts
            ];
    
    
            $this->view($this->getModule(__FILE__), __FUNCTION__, $data);
        }
}
```

3. Create a view for the controller method. E.g. Using the above example, the view is created in `app/code/Post/view/posts.php`

```php
<?php require APPROOT . '/code/Post/view/inc/header.php'; ?>
    <h1><?php echo $data['title']; ?></h1>
<ul>
    <?php foreach ($data['posts'] as $post) : ?>
        <li><?php echo $post->title; ?></li>
    <?php endforeach; ?>
</ul>
    <p>This is the MVC PHP framework. Please refer to the docs on how to use it.</p>
<?php require APPROOT . '/code/Post/view/inc/footer.php'; ?>
```