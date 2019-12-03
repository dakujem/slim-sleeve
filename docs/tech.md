# Technical Dox

In-depth information on tech used in this skeleton app.


## The Stack

Let me rephrase, any of these can be swapped for other package or removed completely.

**Slim Psr7 HTTP**\
Comes from the authors of Slim and was a vital part of it prior to version v4.
Info on how to swap the HTTP implementation can be found in the [Slim v4 documentation](https://github.com/slimphp/Slim/blob/4.x/README.md).
> :zap: currently using nyholm/psr7 because of an issue in slim/psr7.

**Pimple container**\
Fast, stable, proven, lightweight.\
_Sleeve_ extends Pimple to add a touch of convenience.


- JWT
- tracy / symfony debug
- twig
- fractal
- validation



## The Directory Structure

The top-level directory structure provides guidelines to structure your code:
```
─ /  (root)
  ├─ app/
  ├─ domain/
  ├─ config/
  ├─ services/
  ├─ storage/
  ├─ public/
  └─ ...
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
Private storage space for your local storage adapter. For example for user uploads or generated files.

**/public**\
This is the place for _public_ assets (HTML, JS, CSS, images, ...). This is the only folder where the server should be able to access. Your document root.

**/public/storage**\
A publicly accessible storage. It is a good practice to symlink here from a folder in your private storage (e.g. `/storage/public`).
```
─ /  (root)
  ├─ ...
  ├─ public/
  |  └─ storage/   ─┐
  ├─ storage/       | (symlink)
  |  └─ public/   <─┘
  └─ ...
```
 This way you only have _one storage_ folder to care about, keeping the utility of a dedicated public storage. Many times it is handy that the user uploads or generated files can be accessed directly by the web server, mostly for performance reasons.

**/tests**, **/docs**, **/temp**, **/log**\
I hope these dirs are self-explanatory:
```
─ /  (root)
  ├─ ...
  ├─ tests/
  ├─ docs/
  ├─ temp/
  ├─ log/
  └─ ...
```

**/bin**\
Finally, migrations, service scripts, console commands and other stuff of that nature can be placed in the `bin` directory:
```
─ /  (root)
  ├─ ...
  ├─ bin/
  |  ├─ console/
  |  └─ migrations/
  └─ ...
```
In case your application is console-heavy, consider making the directory containing your console stuff a top-level directory, i.e. `/console`.

