
# PassHub

A passwords management system in php.

---

# Features:

* `Categories` - categories is useful to organize your passwords.
* `Passwords` - store your passwords.
* `Logins Activities` - See successful and failed logins activities.
* `Lock Mode` - Enter lock mode to secure your account.
* `Alerts` - Receive alert via mail.

---

### Usage:
1. Download project.
2. Create MySql database names `passhub`.
3. import the `passhub-database.sql` to that created database.
4. Open `settings/db.php` and enter your DB connection settings.
5. Open `settings/config.php` and change the `$baseUrl` to your app path (DON'T add `/` in the end, Example: www.domain.com/projects/passhub)
6. Goto passhub database in `phpMyAdmin` then open `smtp_settings` table and enter your SMTP settings
7. Finally open the app in your browser by the `$baseUrl` you provided in the `settings/config.php` file
8. Default login details:
   * `email`: user@gmail.com
   * `password`: user
   * `pin-code`: 1234

---

### Testing Connection:
You can test the connection of SMTP and DB by opening these files

1. Testing SMTP connection: `testing/mail/test-mail-connection.php`
2. Testing DB connection: `testing/db/test-db-connection.php`

Just open the `.php` file in your browser

---

## Screenshots

![image](https://user-images.githubusercontent.com/25286081/222756702-0809fa7c-148e-479a-be6c-2550027052f8.png)

![image](https://user-images.githubusercontent.com/25286081/222756863-b5d0e961-84a0-4a09-93e5-a1f2163e0eef.png)

![image](https://user-images.githubusercontent.com/25286081/222756901-38cbd147-0b6a-4e3d-a65b-0df9274f487c.png)

![image](https://user-images.githubusercontent.com/25286081/222756927-0e569df8-d4b9-4633-82d0-f391b86d8840.png)

![image](https://user-images.githubusercontent.com/25286081/222756948-aa02f7df-b35d-4112-bd4f-0808e2d78845.png)

![image](https://user-images.githubusercontent.com/25286081/222757012-346591bb-df30-4bae-8617-04eb017319c2.png)

![image](https://user-images.githubusercontent.com/25286081/222757119-9c0c6e59-49e5-481e-99c9-bf519336a588.png)

![image](https://user-images.githubusercontent.com/25286081/222757168-71b8eef9-202a-4516-95f4-5e56f327cf8c.png)

![image](https://user-images.githubusercontent.com/25286081/222757189-304fa329-353d-4d85-a72a-fbc643af605c.png)

![image](https://user-images.githubusercontent.com/25286081/222757236-298c3e34-8812-45c4-8d03-080c844b1f4a.png)

![image](https://user-images.githubusercontent.com/25286081/222757286-d14f8206-29bd-4df0-9a6c-81c2d5add83a.png)
