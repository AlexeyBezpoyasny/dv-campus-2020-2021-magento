## Local development - domains ##

Add the following domains to the `/etc/hosts` file:

```shell
127.0.0.1 oleksii-bezpoiasnyi.local www.oleksii-bezpoiasnyi.local oleksii-bezpoiasnyi-second.local www.oleksii-bezpoiasnyi-second.local pma-prod-oleksii-bezpoiasnyi.local mh-prod-oleksii-bezpoiasnyi.local
```

Urls list:
- [https://oleksii-bezpoiasnyi.local](https://oleksii-bezpoiasnyi.local) 
- [https://www.oleksii-bezpoiasnyi.local](https://www.oleksii-bezpoiasnyi.local) 
- [https://oleksii-bezpoiasnyi-second.local](https://oleksii-bezpoiasnyi-second.local) 
- [https://www.oleksii-bezpoiasnyi-second.local](https://www.oleksii-bezpoiasnyi-second.local) 
- [http://pma-prod-oleksii-bezpoiasnyi.local](http://pma-prod-oleksii-bezpoiasnyi.local) 
- [http://mh-prod-oleksii-bezpoiasnyi.local](http://mh-prod-oleksii-bezpoiasnyi.local)


## Local development - self-signed certificates ##

Generate self-signed certificates before running this composition in the `$SSL_CERTIFICATES_DIR`:

```shell
mkcert -cert-file=oleksii-bezpoiasnyi.local-prod.pem -key-file=oleksii-bezpoiasnyi.local-prod-key.pem oleksii-bezpoiasnyi.local www.oleksii-bezpoiasnyi.local oleksii-bezpoiasnyi-second.local www.oleksii-bezpoiasnyi-second.local
```

Add these keys to the Traefik configuration file if needed.