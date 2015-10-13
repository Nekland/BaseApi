1.1.3 (2015-XX-XX)
==================

1.1.2 (2015-10-13)
==================

* Added possibility to specify guzzle options for the default client adapter

1.1.1 (2015-09-21)
==================

* Added possibility to retrieve options from client

1.1.0 (2015-03-19)
==================

* Added possibility to send string as body (json string in most cases)
* Make the lib more testable by changing the way to call static methods
* Fixed wrong instanciation of the HttpClientFactory in default behavior of the ApiFactory

1.0.1 (2015-03-11)
==================

* 2 new extensions to make easier error management

1.0.0 (2015-03-10)
==================

New awesome features
--------------------

* Drop Guzzle dependency
* Added dependency on Symfony Event Dispatcher Component
* Added specificity tests with phpspec
* Added cache strategy support
* Added transformer strategies
* Made the ApiFactory "IDE friendly"

Compatibility breaks:
---------------------

Almost everything, sorry guys this is a new, very very major version :-).
