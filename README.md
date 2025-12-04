## Requisitos

- Servidor web Apache via *XAMPP*
- *PHP* 7.4+
- *MySQL* 5.7+ ou *MariaDB*

---

## Instalação

1. *Clone o projeto para a pasta correta do seu servidor local*:

   - Para XAMPP: htdocs/
   - No git bash -> git clone git@github.com:gCamposDev/SistemaWebPHP-LocacaoVeiculos.git

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

CREATE TABLE IF NOT EXISTS veiculos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  marca VARCHAR(80) NOT NULL,
  modelo VARCHAR(120) NOT NULL,
  ano INT NOT NULL,
  placa VARCHAR(20) NOT NULL UNIQUE,
  preco_dia DECIMAL(10,2) NOT NULL,
  disponivel TINYINT(1) NOT NULL DEFAULT 1,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS locacoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  id_veiculo INT NOT NULL,
  data_locacao DATETIME DEFAULT CURRENT_TIMESTAMP,
  valor_fipe DECIMAL(10,2) NULL,
  fipe_json TEXT NULL,

  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
    ON DELETE CASCADE,
  FOREIGN KEY (id_veiculo) REFERENCES veiculos(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



```
3. *Acesse no navegador:*
   
   - http://localhost/SistemaWebPHP-LocacaoVeiculos/public/index.php

4. *Para criar um usuário com perfil admin, acesse o seguinte link:*
   
   - http://localhost/SistemaWebPHP-LocacaoVeiculos/public/criar_admin.php

*Após a criação do administrador, exclua o arquivo criar_admin.php por motivos de segurança!*

5. *ATENÇÃO*
   
   - Verifique o endereço das pastas de acordo com as informações acima
   - Use exatamente o mesmo comando SQL
   - Qualquer problema com a configuração ou o projeto, fique a vontade para enviar um email -> gcamposlive@gmail.com
