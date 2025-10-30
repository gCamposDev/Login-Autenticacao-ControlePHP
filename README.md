## Requisitos

- Servidor web Apache via *XAMPP*
- *PHP* 7.4+
- *MySQL* 5.7+ ou *MariaDB*

---

## Instalação

1. *Clone o projeto para a pasta correta do seu servidor local*:

   - Para XAMPP: htdocs/
   - No git bash -> git clone git@github.com:gCamposDev/Login-Autenticacao-ControlePHP.git

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

CREATE TABLE IF NOT EXISTS cnhs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  numero_cnh VARCHAR(20) NOT NULL,
  categoria ENUM('A','B','AB','C','D','E') NOT NULL,
  validade DATE NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

```
3. *Acesse no navegador:*
   
   - http://localhost/Login-Autenticacao-ControlePHP/public/index.php

4. *Para criar um usuário com perfil admin, acesse o seguinte link:*
   
   - http://localhost/Login-Autenticacao-ControlePHP/public/criar_admin.php

*Após a criação do administrador, exclua o arquivo criar_admin.php por motivos de segurança!*

5. *ATENÇÃO*
   
   - Verifique o endereço das pastas de acordo com as informações acima
   - Use exatamente o mesmo comando SQL acima
   - Qualquer problema com a configuração ou o projeto, fique a vontade para enviar um email -> gcamposlive@gmail.com