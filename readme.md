
:zap: This _thing_ is in its early development stage. You have been warned. :zap:

I had a Slim v3 skeleton app lying around and decided to build a Slim v4 dev stack and a skeleton App.

---


# Slim Sleeve

A **Slim v4** skeleton app.\
🌳🌳🐘🌳🌳


## The Freedom

Slim v4 gives you even more freedom to build your own stack, so if you do not like a package used in this stack, go ahead and **swap it for one that suits you**. That's the power of freedom you are given here.


## The Stack

**Slim Psr7 HTTP**\
Comes from the authors of Slim and was a vital part of it prior to version v4.
> :zap: currently using nyholm/psr7 because of an issue in slim/psr7. Info on how to swap the HTTP implementation can be found in the [Slim v4 documentation](https://github.com/slimphp/Slim/blob/4.x/README.md) 

**Pimple container**\
Fast, stable, proven, lightweight.\
Sleeve extends Pimple to add a touch of convenience.


## The Run

In your terminal, from the root of your installation, run
```sh
composer install
php -S localhost:8000 -t public
```
... then navigate to [http://localhost:8000](http://localhost:8000) and you are good to go.


## The License

Comes with one of the "I don't care" licenses. Use it for whatever purpose you like.


-------

TODOs
- [x] bootstrapping
- [x] dir structure
- [x] JWT
- [ ] auth (-entication / -orization) [do or do not?]
- [ ] tracy
- [ ] twig
- [ ] fractal
- [ ] validation
- [ ] remove ballast
