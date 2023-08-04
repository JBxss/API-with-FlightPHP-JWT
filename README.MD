# API con FlightPHP y JWT

Esta es una API construida con el microframework FlightPHP y utiliza JWT (JSON Web Tokens) para la autenticación y autorización de usuarios. Esta API proporciona endpoints para acceder a diferentes recursos y realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) en la base de datos.

## Requisitos

- PHP 7.0 o superior
- Composer
- Base de datos MySQL u otro compatible


## Endpoints

A continuación, se muestran los endpoints disponibles en esta API.

### Autenticación

- `POST /api/auth`: Permite a un usuario autenticarse. Se debe enviar un JSON con las credenciales de usuario (correo y contraseña) y devuelve un token JWT si la autenticación es exitosa.

### Usuarios

- `POST /api/users`: Crea un nuevo usuario. Se deben proporcionar los datos del usuario en un JSON en el cuerpo de la solicitud.

- `GET /api/users`: Obtiene todos los usuarios registrados en la base de datos.

- `GET /api/users/{id}`: Obtiene los detalles de un usuario específico por su ID.

- `PUT /api/users/{id}`: Actualiza los datos de un usuario específico por su ID. Se deben proporcionar los nuevos datos en un JSON en el cuerpo de la solicitud.

- `DELETE /api/users/{id}`: Elimina un usuario específico por su ID.

## Autenticación con JWT

Para acceder a los endpoints protegidos, debes incluir el token JWT en la cabecera `Authorization` de la solicitud. El token se obtiene después de iniciar sesión exitosamente en el endpoint `/api/auth`.

Ejemplo de cabecera de solicitud:

```
Authorization: Bearer <token>
```

## Ejemplo de solicitud y respuesta

### Solicitud

```
POST /api/auth
Content-Type: application/json

{
    "correo": "test",
    "contraseña": "test"
}
```

### Respuesta exitosa

```
HTTP/1.1 200 OK
Content-Type: application/json

{
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxMjM0NTY3ODkwLCJpYXQiOjE2MzI4MzM2NjAsImV4cCI6MTYzMjgzMzc2MH0.XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
}
```

## Contribuciones

Si deseas contribuir a este proyecto, ¡siéntete libre de hacer un fork y enviar tus pull requests!

## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.