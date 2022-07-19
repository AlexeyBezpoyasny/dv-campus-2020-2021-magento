## Local development - domains ##

Add the following domains to the `/etc/hosts` file:

```shell
127.0.0.1 oleksii-bezpoiasnyi-dev.local www.oleksii-bezpoiasnyi-dev.local oleksii-bezpoiasnyi-second-dev.local www.oleksii-bezpoiasnyi-second-dev.local pma-prod-oleksii-bezpoiasnyi-dev.local mh-prod-oleksii-bezpoiasnyi-dev.local
```

Urls list:
- [https://oleksii-bezpoiasnyi-dev.local](https://oleksii-bezpoiasnyi-dev.local) 
- [https://www.oleksii-bezpoiasnyi-dev.local](https://www.oleksii-bezpoiasnyi-dev.local) 
- [https://oleksii-bezpoiasnyi-second-dev.local](https://oleksii-bezpoiasnyi-second-dev.local) 
- [https://www.oleksii-bezpoiasnyi-second-dev.local](https://www.oleksii-bezpoiasnyi-second-dev.local) 
- [http://pma-prod-oleksii-bezpoiasnyi-dev.local](http://pma-prod-oleksii-bezpoiasnyi-dev.local) 
- [http://mh-prod-oleksii-bezpoiasnyi-dev.local](http://mh-prod-oleksii-bezpoiasnyi-dev.local)


## Local development - self-signed certificates ##

Generate self-signed certificates before running this composition in the `$SSL_CERTIFICATES_DIR`:

```shell
mkcert -cert-file=oleksii-bezpoiasnyi-dev.local-prod.pem -key-file=oleksii-bezpoiasnyi-dev.local-prod-key.pem oleksii-bezpoiasnyi-dev.local www.oleksii-bezpoiasnyi-dev.local oleksii-bezpoiasnyi-second-dev.local www.oleksii-bezpoiasnyi-second-dev.local
```

Add these keys to the Traefik configuration file if needed.