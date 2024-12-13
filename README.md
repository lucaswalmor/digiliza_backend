# 📄 Documentação do Sistema de Reservas  

## 📋 Descrição do Projeto  
Este sistema permite gerenciar reservas de mesas para um restaurante. Ele inclui funcionalidades de login, gestão de reservas, validações de horários e administração de dados.  

---

## 🛠 Tecnologias Utilizadas  

**Frontend:**  
- HTML  
- CSS  
- JavaScript  
- Vue.js  
- Bootstrap  

**Backend:**  
- PHP com Laravel  

**Banco de Dados:**  
- MySQL  

---

## ✅ Funcionalidades Implementadas  
- Sistema de Login  
- Cadastro e gerenciamento de reservas  
- Validação de horários e conflitos de reservas  
- Painel administrativo com listagem de reservas  
- Banco de dados configurado com Migrations, Seeds e Factories  

---

## ⚙️ Regras de Negócio  
- Reservas permitidas das 18:00 às 23:59, exceto aos domingos, quando são permitidas durante o dia todo  
- Evita reservas com horários conflitantes  
- Validação de disponibilidade de mesas  

---

## 🚀 Como Executar  
1. Clone o repositório:  
   ```bash
   git clone https://github.com/lucaswalmor/digiliza_backend.git
   ```

2. Instale as dependências:  
   ```bash
   composer install
   ```

3. Configure o arquivo `.env` com seu banco de dados.  

4. Execute as migrations e seeds:  
   ```bash
   php artisan migrate --seed
   ```

5. Inicie o servidor:  
   ```bash
   php artisan serve
   ```

6. Acesse:  
   ```
   http://127.0.0.1:8000
   ```
---