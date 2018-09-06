# set up

```
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load

```


# JWT authentication

Expected token payload looks like this:

```
{
  "user": "John Doe",
  "roles": ["leagues", "teamss"]
}
```

`user` is the username, it's not checked against any user database but it it required.

There are two roles: `teams` grants access to all teams endpoints, 
`leagues` grants access to all leagues *and* teams endpoints.

Signature is verified using `HS256` algorithm and `league-secret` secret which is *not* base64 encoded. 
If you use https://jwt.io to generate the token, it's the default algoorithm, the secret need to be set, and encoding of the secret needs to be unchecked.

In case I got it all wrong, this header works:

```
Auhorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiSm9obiBEb2UiLCJyb2xlcyI6WyJsZWFndWVzIiwidGVhbXMiXX0.QKWZvKZI5Yxw1UTjnPuHZO77EdMpgMbAgZhbA6gmWzI
``` 


 
