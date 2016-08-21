Klient pro jednoduché napojení na produktové feedy dodavatelé v [ShopAPI.cz](https://shopapi.cz).

## Přednosti ShopAPI/Client

### Nenáročnost na server a vysoký výkon
 * stahování feedů používá kompresi, takže je rychlé a nezatěžuje případný datový limit.
 * zpracování probíhá streamovaně, takže i 5GB feed si vystačí s pár MB paměti (@todo benchmark)
 
### Jednodušší napojení
Při použití klienta jste úplně odstíněni od XML a pracujete přímo s jednoduchými objekty. Není proto problém později přejít z XML feedu na REST API (filtry atd.), aniž by bylo nutné měnit zásadně kód napojení.

## Instalace
```bash
composer require shopapicz/client
composer require kdyby/curl-ca-bundle       # nepovinné, doporučené
```
Doporučujeme nainstalovat i kdyby/curl-ca-bundle kvůli certifikátům, pokud váš server nemá aktuální.

## Použití
```php
<?php
use ShopAPI\Client\XmlReader;

$reader = new XmlReader();
/*
 * URL XML feedu je https://shopapi.cz/feed/dddd8888eeee
 */
foreach ($reader->readFromUrl('dddd8888eeee') as $product) {
    echo $product->getName();
}

```

## Na co si dát pozor
Každý dodavatel nabízí data v jiném rozsahu a rozsah dat se může později měnit. Například dodavatel, který uváděl u všech produktů značku může později zařadit produkty, které značku uvedenou nemají. Při napojování je nutné s takovou situací počítat.

```php
<?php
// ŠPATNĚ
echo $product->getBrand()->getName(); 

// SPRÁVNĚ
if($product->getBrand()) {
    echo $product->getBrand()->getName(); 
}
```
