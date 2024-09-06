# Simple Banking Application

A banking application that demonstrates the use of both file and database storage systems while following Object-Oriented Programming (OOP) principles. This project features user roles (Admin and Customer), transactions, and session management.

## Getting Started

1. **Clone the repository:**

    ```shell
    git clone git@github.com:Fabdoc27/Bangubank.git
    cd Bangubank
    ```

2. **Install the dependencies:**

    ```shell
    composer install
    ```

**Note:** You can change the storage type inside `config/database.php`:

-   **File Storage:** Set `"storage" => "file"`.
-   **Database Storage:** Set `"storage" => "database"`.

3. **Run the project:**

    Start the PHP development server:

    ```shell
    php -S localhost:8080
    ```

4. **Access the application:**

    Open your browser and go to [http://localhost:8080](http://localhost:8080).
