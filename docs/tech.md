# Technical Dox

This is the place where you would put your project documentation.

## The Stack

Let me rephrase, any of these can be swapped for other package or removed completely.

**Slim Psr7 HTTP**\
Comes from the authors of Slim and was a vital part of it prior to version v4.
> :zap: currently using nyholm/psr7 because of an issue in slim/psr7. Info on how to swap the HTTP implementation can be found in the [Slim v4 documentation](https://github.com/slimphp/Slim/blob/4.x/README.md) 

**Pimple container**\
Fast, stable, proven, lightweight.\
Sleeve extends Pimple to add a touch of convenience.


- JWT
- tracy
- twig
- fractal
- validation

## The Directory Structure

The basic directory structure provides simple guidelines to structure your code:
```
─ /  (root)
  ├─ app/
  ├─ domain/
  ├─ config/
  ├─ services/
  ├─ storage/
  ├─ public/
  |  ├─ img/, js/, css/, ...
  |  └─ storage/
  ├─ tests/
  ├─ docs/
  ├─ log/
  └─ temp/
```

**/app**\
The web application - HTTP request handling - controllers, middleware, views, serialization, and so on.

**/domain**\
This is the place to put your domain objects, domain model, domain services, data model, data validators, together composing your business logic.

**/services**\
Your PHP services that compose the layer between third party libraries, foreign software, APIs, remote calls, etc. and your application. Consider putting the persistence layer (repositories) here.

**/config**\
Put your configuration files here.

**/storage**\
Private storage space for your local storage adapter. For example for user uploads.

**/public**\
This is the place for _public_ assets (HTML, JS, CSS, images, ...). This is the only folder where the server should be able to access. Your document root.

**/public/storage**\
This is a publicly accessible storage. It is a good practice to symlink here from your private storage.

I hope the other dirs are self-explanatory.