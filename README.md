# Voting-System Application

The Voting-System is a web application designed for conducting dynamic and repeatable elections for choosing organization leaders within the Computer Science program. It features administrative controls for configuring election rules and ensuring fair voting practices.

## Features:

1. **Dynamic Election Management:** Allows admins to set up and manage multiple elections with customizable parameters.
   
2. **Unique Signed URL per User:** Ensures each voter receives a unique URL for secure and single-vote guarantee.
   
3. **Real-time Result Visualization:** Provides clear and real-time visual representation of voting results.
   
4. **Role-based Access Control (RBAC):** Implements roles to control access levels for administrators and voters.
   
5. **Mobile Responsiveness:** Responsive design ensures usability across various devices.
   
## Technology Stack:

- **Backend:** Laravel, PHP, MySQL
- **Frontend:** Vue.js, Inertia.js, JavaScript
- **Styling:** Tailwind CSS

## Installation:

1. Configure your database and mail provider settings in the `.env` file.
   
2. Run database migrations and seeders:
```
php artisan migrate --seed
```
3. Start the development server:
```
php artisan serve
```
4. Compile frontend assets:
```
npm run dev
```
5. Run the queue for background jobs:
```
php artisan queue:work
```
## Usage:

- Access the application at `http://localhost:8000` after starting the server.
- Admins can log in to manage elections and view results.
- Voters receive unique URLs via email for secure voting.
