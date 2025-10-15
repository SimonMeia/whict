# What Have I Committed Today? (WHICT)

A beautiful Laravel application to track and visualize your daily GitHub commits across all your repositories.

## 🚀 Features

-   **GitHub Authentication** - Securely sign in with your GitHub account using OAuth
-   **Daily Commit Overview** - View all your commits for any specific date
-   **Multi-Repository Support** - Track commits across all your GitHub repositories
-   **Commit Statistics** - See total commits, active repositories, and hourly activity breakdown
-   **Rich Commit Details** - View commit messages, timestamps, repository info, and verification status

## 📋 Requirements

-   PHP 8.2 or higher
-   Composer
-   Node.js & NPM
-   GitHub OAuth Application (for authentication)

## 🛠️ Installation

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd whict
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install JavaScript dependencies**

    ```bash
    npm install
    ```

4. **Configure environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Set up GitHub OAuth**

    Create a GitHub OAuth application at [GitHub Developer Settings](https://github.com/settings/developers)

    Add your credentials to `.env`:

    ```env
    GITHUB_CLIENT_ID=your_client_id
    GITHUB_CLIENT_SECRET=your_client_secret
    GITHUB_REDIRECT_URI=http://localhost:8000/auth/callback
    ```

6. **Run migrations**

    ```bash
    php artisan migrate
    ```

7. **Run dev site**
    ```bash
    composer dev
    ```

Visit `http://localhost:8000` in your browser.

## 🎨 Tech Stack

-   **Backend:** Laravel 12
-   **Frontend:** Alpine.js, Tailwind CSS v4
-   **UI Components:** [Pines UI](https://devdojo.com/pines/docs/introduction)
-   **Authentication:** Laravel Socialite (GitHub OAuth)
-   **Testing:** Pest PHP
-   **Code Quality:** Laravel Pint

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   └── FetchCommitsController.php    # Handles commit fetching and display
├── Service/
│   ├── ApiService.php                # Base API service
│   ├── GithubService.php             # GitHub API integration
│   └── CommitProcessorService.php    # Commit data processing
└── Models/
    └── User.php                      # User model with GitHub token

resources/
├── views/
│   ├── welcome.blade.php             # Home page with date selector
│   ├── commits.blade.php             # Commits display page
│   └── components/                   # Reusable Blade components
├── css/
│   └── app.css                       # Tailwind CSS
└── js/
    └── app.js                        # Alpine.js bootstrap

routes/
└── web.php                           # Application routes
```

## 🔧 Development

**Format code with Pint:**

```bash
vendor/bin/pint
```

**Run tests:**

```bash
php artisan test
```

## 📝 How It Works

1. **Authentication:** Users sign in with their GitHub account via OAuth
2. **Token Storage:** GitHub access tokens are securely encrypted and stored
3. **Repository Fetching:** The app fetches all repositories pushed to on the selected date
4. **Commit Processing:** Commits are retrieved, deduplicated, and enriched with metadata
5. **Display:** Commits are beautifully displayed with statistics and links

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
