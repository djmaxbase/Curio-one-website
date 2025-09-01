# 🌟 Curio One Website

Officiële website van **Curio One**, een team van 15 studenten van **Curio** (Nederland) dat deelneemt aan de **FIRST Tech Challenge (FTC)**.  
De site bevat teaminfo, sponsor(s), en een blog waar teamleden updates kunnen plaatsen.

---

## 📂 Bestandsstructuur

```
/website
│
├─ /css
│    └─ style.css
│
├─ /includes
│    ├─ navbar.php
│    ├─ hero.php
│    ├─ about.php
│    ├─ robots.php
│    ├─ blog.php
│    ├─ sponsors.php
│    ├─ contact.php
│    └─ footer.php
│
├─ index.php
├─ login.php
├─ admin.php
└─ logout.php
```

---

## 🗄️ Database installeren

Open je MySQL (phpMyAdmin of CLI) en plak dit in **één keer**:

```sql
CREATE DATABASE curioone;
USE curioone;

-- Users (inloggen)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Posts (blogartikelen)
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  author VARCHAR(50)
);
```

---

## 🔑 Eerste admin-gebruiker aanmaken

Maak tijdelijk een bestand **`maak_admin.php`** in de projectmap met deze inhoud:

```php
<?php
$pdo = new PDO("mysql:host=localhost;dbname=curioone", "root", "");

$username = "admin"; // kies gebruikersnaam
$password = password_hash("sterkwachtwoord", PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $password]);

echo "Admin user toegevoegd!";
```

1. Open in de browser:  
   ```
   http://localhost/website/maak_admin.php
   ```
2. Je ziet de melding:  
   ```
   Admin user toegevoegd!
   ```
3. **Verwijder dit bestand direct daarna!**

---

## 🚀 Website lokaal draaien

1. Zet de map `website` in je `htdocs` (XAMPP) of `www` (Laragon/WAMP).  
2. Start Apache en MySQL.  
3. Importeer de database met het SQL-script hierboven.  
4. Open in je browser:  
   ```
   http://localhost/website
   ```
5. Loginpagina (niet zichtbaar in het menu):  
   ```
   http://localhost/website/login.php
   ```

---

## ✨ Features

- 🔒 Login-systeem (alleen teamleden kunnen berichten plaatsen)  
- 📝 Blog via `admin.php`  
- 🏫 Sponsors-sectie (Curio)  
- 📬 Contactformulier (later te koppelen aan e-mail)  
- 🎨 Jeugdig & energiek design (oranje/blauw/donker thema)  

---

## 📌 To do

- [ ] Foto’s en bio’s toevoegen (*About*)  
- [ ] Robotfoto’s/specs toevoegen (*Robots*)  
- [ ] Posts bewerken/verwijderen in admin  
- [ ] Contactformulier koppelen aan e-mail  

---

## 👨‍💻 Ontwikkeld door
**Team Curio One** – studenten van Curio, Nederland
