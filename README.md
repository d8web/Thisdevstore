### This Dev Social Media

<p>Loja virtual completa com PHP puro, fiz a listagem de produtos vindas do banco de dados com filtro pelas categorias também de forma dinâmica. A loja possui sistema de login e cadastro, um detalhe do cadastro é que o email precisa ser válidado pelo usuário antes do mesmo fazer o login. O sistema possui também carrinho de compras e checkout da venda, além do usuário poder ver o seu perfil, alterar seus dados tais como nome, email, senha, etc... e ver seu histórico de compras.</p>

<p>Aqui também temos a parte adminstrativa do sistema, na qual o adminstrador pode gerir os dados da loja, adicionar/editar/deletar os produtos, ver todas as vendas realizadas, lista dos clientes da loja, alterar status da venda com possibilidade de enviar emails para o comprador o notificando sobre alteração do status e envio de pdf para o cliente com dados da compra.</p>

<img src=""/>

### Features

- [x] Sistema de autenticação
- [x] Cadastro de novos usuários com envio de email para confirmar
- [x] Lista de produtos
- [x] Lista de produtos filtrando por categoria
- [x] Adicionar produtos ao carrinho
- [x] Checkout

### Pré requisitos
Antes de iniciar você precisa ter o [Xampp](https://www.apachefriends.org/pt_br/index.html) instalado na sua máquina, essa ferramenta traz junto de si o PHP e o Mysql. É bom também ter um editor de código como [VSCode](https://code.visualstudio.com/).

Você pode clonar este repositório ou baixar o zip.

Ao descompactar, é necessário rodar o **composer** para instalar as dependências e gerar o *autoload*.

Vá até a pasta do projeto, pelo *prompt/terminal* e execute:
> composer install

### Configurações do projeto

Todos os arquivos de **configuração** do projeto estão dentro do arquivo *config.php*.

> const APP_NAME = 'Nome do projeto'; <br/>
> const APP_VERSION = 'Versão do projeto'; <br/>
> const BASE_URL = '/**PastaDoProjeto**/public'; <br/>

> const MYSQL_SERVER = 'Servidor'; <br/>
> const MYSQL_DATABASE = 'Nome do banco de dados'; <br/>
> const MYSQL_USER = 'Usuário do banco de dados'; <br/>
> const MYSQL_PASS = 'Senha do banco de dados'; <br/>
> const MYSQL_CHARSET = 'utf8'; <br/>

> const AES_KEY = 'muf4YDYMw3KeNv7rFkLFRJhkRwapBDVF'; <br/>
> const AES_IV = 'NjWA3sg3vyk6yVk2'; <br/>

> const STATUS = '["PENDING", "PROCESSING", "SEND", "CANCELED", "CONCLUDED"]'; <br/>
> const PDF_PATH = 'C:/xampp/htdocs/store/pdfs/'; <br/>

> const EMAIL_HOST = 'Host do seu email'; <br/>
> const EMAIL_FROM = 'Seu email'; <br/>
> const EMAIL_PASS = 'Sua senha'; <br/>
> const EMAIL_PORT = 'Porta'; <br/>

### Tecnologias

Neste projeto foram usadas as seguintes tecnologias

- [PHP](https://www.php.net/)
- [Mysql](https://www.mysql.com/)
- [MPDF](https://mpdf.github.io/)

<hr/>
Criado com muito esforço por <a href="https://github.com/d8web/" target="_blank">Daniel</a>.
