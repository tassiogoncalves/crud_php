# 🚀 Sistema CRUD em PHP (Estruturado)

Bem-vindo ao **Sistema CRUD em PHP**! Este é um projeto construído com o objetivo de ser simples, seguro e ter um visual moderno e agradável. Ele foi desenvolvido em PHP puro (estruturado), utilizando o banco de dados MariaDB/MySQL.

## ✨ O que este sistema faz? (Funcionalidades)
Este sistema é um painel administrativo completo que permite gerenciar três coisas principais:

1. **🔒 Autenticação e Perfis de Acesso**
   - **Login Seguro:** Ninguém entra no painel sem e-mail e senha.
   - **Níveis de Acesso:** Existem *Administradores* e usuários *Comuns*.
   - Apenas o *Administrador* consegue ver e modificar outros usuários do sistema.

2. **📦 Gestão de Produtos (com fotos, busca e movimentação de estoque!)**
   - Você pode cadastrar, listar, editar e apagar produtos livremente (seja como Admin ou Usuário Comum).
   - O sistema conta com uma **Barra de Busca** para filtrar rapidamente os produtos pelo nome.
   - Cada produto tem seu **Preço**, **Descrição**, **Foto** e **Estoque**.
   - O controle de estoque possui um alerta visual automático: se a quantidade for menor que 5, a listagem exibe um "badge" vermelho avisando que o estoque está baixo.
   - **Módulo de Movimentação (Estilo ERP):** Ao invés de digitar o novo estoque na mão, existe a área "Movimentações" onde os usuários lançam as Entradas e Saídas (informando a quantidade e o motivo). O sistema atualiza o estoque do produto automaticamente e salva tudo num extrato. Impede também que o estoque fique negativo.
   - Quando você apaga um produto ou troca a foto dele, o sistema é inteligente e apaga a foto antiga do servidor para não gastar espaço à toa.

3. **📂 Gestão de Categorias (com regras de autoria)**
   - Os produtos são organizados por categorias (ex: Eletrônicos, Roupas).
   - **Controle de Autoria:** O Usuário Comum só pode editar e excluir as categorias que *ele mesmo criou*. Apenas o Administrador tem poder para editar/excluir todas.
   - *Trava de Segurança:* O sistema não deixa você apagar uma categoria se ainda existirem produtos usando ela.

4. **🛡️ Segurança, Logs e Auditoria**
   - Senhas criptografadas usando o método `password_hash` (padrão ouro de segurança atual).
   - Proteção de rotas em todo o sistema (ninguém acessa as telas pelo navegador sem estar logado).
   - **Contra Invasões:** O código inteiro foi blindado contra SQL Injection (ataques hackers) utilizando a técnica de *Prepared Statements*.
   - **Sistema de Auditoria Invisível:** O sistema possui a função de Log. Todas as ações cruciais (login, cadastro, atualização e exclusão) são salvas silenciosamente no banco de dados. Administradores possuem uma tela exclusiva ("Logs") no menu onde podem auditar o que cada usuário fez, em qual dia e hora.

5. **⚙️ Ferramentas Práticas**
   - **Meu Perfil:** Cada usuário pode acessar a tela de "Meu Perfil" e mudar seu próprio nome de exibição e alterar sua senha sem precisar do Administrador.
   - **Recuperação de Senha:** Esqueceu a senha? Tem uma tela para colocar o email. O sistema integra nativamente com a biblioteca **PHPMailer** para disparar um e-mail com link seguro e temporário (1 hora) para você criar uma senha nova.

---

## 🛠️ O que você precisa para rodar? (Requisitos)
Para fazer esse projeto funcionar no seu computador, você vai precisar de:
- **PHP** (versão 7.4 ou superior recomendada).
- **Servidor Web** rodando na sua máquina (como o **MAMP**, **XAMPP** ou **WampServer**).
- **MySQL** ou **MariaDB** (geralmente já vêm inclusos no MAMP/XAMPP).

---

## ⚙️ Passo a Passo: Como Instalar

Siga estes passos simples para rodar o sistema no seu computador:

### 1. Baixe o projeto
Se você usa Git, clone este repositório dentro da pasta pública do seu servidor (ex: `htdocs` no MAMP/XAMPP ou `www` no WampServer):
```bash
git clone https://github.com/tassiogoncalves/crud_php.git crud_php_html
```

### 2. Configure o Banco de Dados
1. Abra o seu **phpMyAdmin** (geralmente acessível em `http://localhost/phpmyadmin` ou `http://localhost:8888/phpmyadmin` no MAMP).
2. Vá na aba **SQL**.
3. Abra o arquivo `bd/schema.sql` que está na pasta do projeto, copie todo o texto dele e cole na caixa de texto do SQL no phpMyAdmin.
4. Clique em **Executar**. Isso vai criar o banco de dados chamado `crud_php`, todas as tabelas, e já vai inserir um usuário administrador padrão para você!

### 3. Ajuste a Conexão (Se precisar)
Abra o arquivo `bd/conexao.php` no seu editor de código e verifique se as configurações de acesso ao banco estão corretas para o seu computador:
```php
$usuario = "tassio"; // Coloque seu usuário do MySQL (ex: root)
$senha = "12345";    // Coloque a senha do seu MySQL (ex: root ou deixe vazio se não tiver)
$porta = 8889;       // No MAMP geralmente é 8889. No XAMPP geralmente é 3306.
```

*Nota: Não se esqueça de ajustar a variável `BASE_URL` no final do arquivo `bd/conexao.php` para apontar para o endereço correto onde o seu projeto está rodando (ex: `http://localhost/crud_php_html/`).*

### 4. Tudo pronto! Faça o Login 🎉
Agora é só abrir o navegador e acessar o endereço do projeto (ex: `http://localhost:8888/crud_php_html/`).

Você verá a tela de Login. Use as credenciais do Administrador padrão que criamos para você:
- **E-mail:** `admin@admin.com`
- **Senha:** `admin123`

Pronto! Agora você já pode explorar, cadastrar produtos, subir fotos e criar novos usuários!

---
*Nota aos desenvolvedores: Conforme o sistema crescer e novas funcionalidades forem adicionadas, este README será mantido atualizado.*
