# Dashboard Application for Research Group

The Intelligence System Research Group dashboard website is an online-based website specifically designed to display statistical data related to Publications, Research, Abdimas and HaKi.

## Screenshots

![App Screenshot](https://github.com/aazmhafidz09/Dashboard-KK/blob/main/iScreen%20Shoter%20-%20Safari%20-%20240126005454.jpg?raw=true)

## Features

- Main Dashboard
- Research Statistics Data
- Publication Statistics Data
- Abdimas Statistics Data
- HaKi Statistics Data
- Data CRUD
- Administrator login feature

## Setting Database Configuration

Import `db_kk_is.sql` to your PhpMyAdmin Database

```bash
  public array $default = [
        'DSN'          => '',
        'hostname'     => 'localhost',
        'username'     => '',
        'password'     => '',
        'database'     => '',
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
        'pConnect'     => false,
        'DBDebug'      => true,
        'charset'      => 'utf8',
        'DBCollat'     => 'utf8_general_ci',
        'swapPre'      => '',
        'encrypt'      => false,
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 3306,
        'numberNative' => false,
    ];
```

## Run Locally

Clone the project

```bash
  git clone https://github.com/aazmhafidz09/Dashboard-KK.git
```

Go to the project directory

```bash
  cd ~your_directory~/
```

Start the server

```bash
  .~your_directory~/php spark serve
```

## Authors

- [@Aazmhafidz09](https://github.com/aazmhafidz09)
