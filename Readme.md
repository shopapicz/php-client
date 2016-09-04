Klient pro jednoduché napojení na produktové feedy dodavatelé v [ShopAPI.cz](https://shopapi.cz).

Podrobná dokumentace API v [docs/api.md](docs/api.md).

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

## Kódy
**Identifikátor UID je unikátní a je dostupný vždy.** Je přidělován v ShopAPI a doporučujeme ho použít pro párování. Je ale nevhodný pro komunikaci s dodavatelem, protože ten má zboží vedené pod vlastními kódy. Doporučujeme proto ukládat i *code* a *EAN*, pokud jsou dostupné.

UID doporučujeme používat pouze interně v aplikaci a zákazníkům/uživatelům ho vůbec nezobrazovat.

## Obrázky
Obrázky jsou nabízeny v maximálním možném rozlišení bez další komprese, tak jak byly získány od dodavatele. Jsou proto zcela nevhodné pro přímé použití v eshopu a je potřeba je dále zpracovat.

Obrázky jsou uložené v CDN a je možné bez obtíží stahovat je rychle paralelně. URL obrázku se ale může později změnit, takže nedoporučujeme se na ni dlouhodobě spoléhat.

## Dostupnost položky
Dostupnost položky je uváděna několika způsoby. U různých položek mohou být v různých kombinacích
 * *code* - kód dostupnosti (in_stock, out_of_stock, unknown, pre_order, unavailable)
 * *hours* - počet hodin (168 = týden)
 * *quantity* - počet kusů na skladě
 * *text* - slovní popis (*skladem*, *poslední kusy*, *není a nebude*, ...)
 
Při napojování doporučujeme používat *code* - je dostupný vždy a má jasně daný formát. Naopak na *text* se nedá nijak spolehnout a je vhodný pouze pro informativní zobrazení.

```php
<?php
use \ShopAPI\Client\Entity\Availability;

if($product->getAvailability()->getCode() === Availability::IN_STOCK){
    echo 'skladem!';
}
// nebo zkráceně:
if($product->getAvailability()->isInStock()){
    echo 'skladem!';
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


## Příklady
```php
<?php
use ShopAPI\Client\XmlReader;

$reader = new XmlReader();
/*
 * URL XML feedu je https://shopapi.cz/feed/dddd8888eeee
 */
foreach ($reader->readFromUrl('dddd8888eeee') as $product) {
    echo '<h1>' . $product->getName() . '</h1>';
    
    foreach($product->getImages() as $image) {
        echo '<img src="' . $image->getUrl() . '">';
    }
    
    if(count($product->getVariants())) {
        echo '<h2>Dostupné varianty:</h2>';
        echo '<ul>';
        foreach($product->getVariants() as $variant) {
            if($variant->getAvailability()->isInStock()) {
                echo '<li style="color:green">';
            } else {
                echo '<li style="color:red">';
            }
            echo $variant->getName();
            echo ' - ';
            echo $variant->getAvailability()->getText();
            echo  '</li>';
        }
        echo '</ul>';
    }
}

```
