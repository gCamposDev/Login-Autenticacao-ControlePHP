## Requisitos

- Servidor web Apache via *XAMPP*
- *PHP* 7.4+
- *MySQL* 5.7+ ou *MariaDB*

---

## Instalação

1. *Clone ou copie* o projeto para a pasta correta do seu servidor local:

   - Para XAMPP: htdocs/

2. *Crie o banco de dados MySQL:*

```sql
CREATE DATABASE IF NOT EXISTS alugafacil
  DEFAULT CHARACTER SET utf8mb4 
  COLLATE utf8mb4_general_ci;

USE alugafacil;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  telefone VARCHAR(30) NOT NULL,
  usuario VARCHAR(80) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  perfil ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```
3. *Acesse no navegador:*
   
   - http://localhost/login-acesso/public/index.php

4. *Para criar um usuário com perfil admin, acesse o seguinte link:*
   
   - http://localhost/login-acesso/public/criar_admin.php

*Após a criação do administrador, exclua o arquivo criar_admin.php por motivos de segurança!*
