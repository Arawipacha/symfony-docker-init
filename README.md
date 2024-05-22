php bin/console make:controller ProductController

sf make:controller
 ### mapear routas/ routes

 En la carpeta config/routes.yml
 aggiungere le seguente configurazione:
 <code>
 index:
    path: /
    controller: App\Controller\RegisterAction::index
 </code>.
 
## Crear base de datos
php bin/console doctrine:database:create  

### Crear entidades/ models en la base de datos quando se crea las entidades se genera tambien un repository que controla a la entidad de base
php bin/console make:entity
sf make:entity

### Crear las migraciones codigo Sql sobre la base de las entities
php bin/console make:migration

### Ejecutar las migraciones a la base de datos
php bin/console doctrine:migrations:migrate



### ejemplo de un a funcion usan entity manager
<code>
public function getUsers(){
   $em= $this->getDoctrine()->getManager();
   $listUsers = $em->getRespository('App:Users')->findBy([],['name'=>'ASC']);
   return $this->render('user/users.html.twig',[
      'listUsers'=>$listUsers
   ]);
}
</code>

### crear un modulo de aunthentizacion
php bin/console make:auth
sf make:auth


### crear un usuario con authenticazione alcuni interface

sf make:user

register 

{
  "username":"pepito",
  "email":"ricardo@gmail.com",
  "password":"sdfdf"
}


login
{
    "security": {
        "credentials": {
            "login": "pepito",
            "password": "sdfdf"
        }
    }
}