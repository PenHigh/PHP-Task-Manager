<h1 align="center">
    PHP Task Manager
</h1>

<p align="center">
    A simple task manager written in PHP
</p>

# Installation

1. Download the repo
    * Clone the repo
        ```bash
        git clone https://github.com/eroxl/php-task-manager.git
        ```
    * Or download the [zip file](https://github.com/PenHigh/PHP-Task-Manager/archive/refs/heads/main.zip)

2. Navigate to the repository
    * If you cloned the repo
        ```bash
        cd <download location>/php-task-manager
        ```
    * If you downloaded the zip file
        1. Unzip the file
            ```bash
            unzip main.zip
            ```
        2. Navigate to the folder
            ```bash
            cd php-task-manager-main
            ```
3. Download Docker & Docker Compose
    - [Docker](https://docs.docker.com/get-docker/)
    - [Docker Compose](https://docs.docker.com/compose/install/)
4. Copy the contents of .env.example to a file named .env
    ```bash
    cp ./.env.example ./.env
    ```
5. From the root of the project, run the Docker Compose file:
    ```bash
    docker-compose up --build
    ```
6. Navigate to [localhost:80](http://localhost:80) in your browser

# Contributors
- [Eroxl](https://github.com/eroxl) + INITIAL DOCKER SETUP & PROJECT SCAFFOLDING
- [Toby](https://github.com/tobycm) + BACKEND 
- [Axel](https://github.com/MostLeVert) - FRONTEND IMPLEMENTATION & DESIGN
