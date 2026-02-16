# Social Network Laravel Project

## 📌 Description
A **Social Network** project built with **Laravel**, **Blade**, and **Tailwind CSS**.  
Features include:
- User authentication (register/login)
- Create posts, comments, and likes
- Add friends, accept/reject friend requests
- Search for users and send friend requests
- **Real-time notifications** for Friend Requests, Likes, and Comments using Laravel Echo + Pusher/Broadcasting

---

## 🛠 Requirements

- PHP >= 8.0  
- Composer  
- MySQL or any supported database  
- Node.js + NPM (for Vite and frontend assets)

---

## ⚡ Installation

```bash
# Clone the repository
git clone <your-repo-url>
cd project-folder

# Install PHP dependencies
composer install

# Install frontend dependencies
npm install

# Copy env file
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=social_network
DB_USERNAME=root
DB_PASSWORD=

# Run migrations & seeders
php artisan migrate --seed

# Build frontend assets
npm run dev


php artisan websockets:serve


📂 Project Structure
app/
├─ Http/
│  ├─ Controllers/
│  ├─ Services/       # Business logic
├─ Models/
resources/
├─ views/             # Blade templates
├─ js/                # Frontend scripts (Echo)


🔗 Important Routes
# Friends
Route::get('/friends', [FriendsController::class, 'index'])->name('friends.index');
Route::post('/friends/send/{id}', [FriendsController::class, 'sendRequest'])->name('friends.send');
Route::post('/friends/accept/{id}', [FriendsController::class, 'acceptRequest'])->name('friends.accept');
Route::delete('/friends/reject/{id}', [FriendsController::class, 'rejectRequest'])->name('friends.reject');

# Posts
Route::get('/posts', [PostsController::class, 'all'])->name('posts.all');
Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');