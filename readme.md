
:zap: This _thing_ is in its early development stage. You have been warned. :zap:

I had a Slim v3 skeleton app lying around and decided to build a Slim v4 dev stack and a skeleton App.

---


# Slim Sleeve

> 💿 composer create-project dakujem/slim-sleeve -s dev

A **Slim v4** skeleton app.\
🌳🌳🌳🐘🌳🌳🌳


## The Freedom

Slim v4 gives you even more freedom to build your own stack, so if you do not like a package used in this stack, go ahead and **swap it for one that suits you**. That's the power of freedom you are given here.


## The Stack

The stack consists of a PSR-7 HTTP implementation, Slim request dispatcher, router, middleware for security, view layer and a thin database abstraction layer.

The directory structure and the stack are prepared in a way to advocate good coding practices and layer separation.

To dive deeper, read the [tech docs](docs/tech.md).




## The Run

In your terminal, from the root of your installation, run
```sh
composer install
php -S localhost:8000 -t public
```
... then navigate to [http://localhost:8000](http://localhost:8000) and you are good to go.


## The License

Comes with one of the "I don't care" licenses. Use the code for whatever purpose you like.


-------

**TODOs**
- [x] bootstrapping
- [x] dir structure
- [x] JWT
- [ ] auth (-entication / -orization)  // do or do not?
- [ ] tracy / symfony debugger
- [ ] twig / latte
- [ ] fractal
- [ ] validation
- [ ] remove ballast
