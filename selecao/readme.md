** Processo seletivo Splitpay**

 Não esqueça de rodar o script splitpay.sql em seu MYSQL, presente na pasta db, verifique a username e password do seu db, neste codigo esta setado como admin ambos.

 também esta disponível a collection json para o postman, na pasta collection

 Lembra-se que o teste unitário realiza a operação delete com o id 1, se ativado este id será deletado

 se realizado novamente retornará erro pois este id não existirá mais, mude o id para um id válido ou
 insira o registro 1 novamente .:

 INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `quantidade`) VALUES (1, 'teste', 'teste', 25.4, 20);

 para ativar realize as seguinte operações, na pasta raíz do projeto "selecao" .:

 composer install 

 php -S localhost:3000 -t src para ativar o servidor de desenvolvimento do PHP

para realizar o teste .: composer test 

autor : João vitor de lima, data : 12/11/2023 <a href="https://www.linkedin.com/in/jo%C3%A3o-vitor-de-lima-74441b1b1/" target="_blank"><img loading="lazy" src="https://img.shields.io/badge/-LinkedIn-%230077B5?style=for-the-badge&logo=linkedin&logoColor=white" target="_blank"></a>   
