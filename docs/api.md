## Attribute
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getUid | string |   |  |
| getName | string |   |  |
| getUid | string |   |  |
## AttributeValue
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getAttribute | [Attribute](#attribute) |   |  |
| getValues | array |   |  |
## Availability
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getText | string |   |  |
| getHours | int |   |  |
| getCode | int |   |  |
| getQuantity | int |   |  |
| isInStock | bool |   |  |
| isOutOfStock | bool |   |  |
| isPreOrder | bool |   |  |
| isUnavailable | bool |   |  |
## Brand
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getUid | string |   |  |
| getName | string |   |  |
| getUid | string |   |  |
## Category
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getUid | string |   |  |
| getName | string |   |  |
| getPath | string[] |   |  |
| getUid | string |   |  |
## Image
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getUid | string |   |  |
| getUrl | string |   |  |
| getUpdated | \DateTime |   |  |
| getMd5 | string |   |  |
| getUid | string |   |  |
## Product
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getUid | string |   |  |
| getName | string |   |  |
| getEan | string |   |  |
| getCode | string |   |  |
| getUpdated | \DateTime |   |  |
| getPrice | float |   |  |
| getPriceRetail | float |   |  |
| getImages | [Image](#image)[] |   |  |
| getAttributes | [AttributeValue](#attributevalue)[] |   |  |
| getAttribute | null&#124;[AttributeValue](#attributevalue) | uid  |  |
| getAvailability | [Availability](#availability) |   |  |
| getUid | string |   |  |
| getVariants | [Variant](#variant)[] |   |  |
| getCategories | [Category](#category)[] |   |  |
| getVideos | [Video](#video)[] |   |  |
| getDescription | string |   |  |
| getFullDescription | string |   |  |
| getUrl | string |   |  |
| getVatRate | float |   |  |
| getWarranty | int |   |  |
| getBrand | [Brand](#brand) |   |  |
| getCreated | \DateTime |   |  |
| isDeleted | boolean |   |  |
| getChecksum | string |   |  |
| getName | string |   |  |
| getEan | string |   |  |
| getCode | string |   |  |
| getUpdated | \DateTime |   |  |
| getPrice | float |   |  |
| getPriceRetail | float |   |  |
| getImages | [Image](#image)[] |   |  |
| getAttributes | [AttributeValue](#attributevalue)[] |   |  |
| getAttribute | null&#124;[AttributeValue](#attributevalue) | uid  |  |
| getAvailability | [Availability](#availability) |   |  |
| getUid | string |   |  |
## Variant
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getUid | string |   |  |
| getName | string |   |  |
| getEan | string |   |  |
| getCode | string |   |  |
| getUpdated | \DateTime |   |  |
| getPrice | float |   |  |
| getPriceRetail | float |   |  |
| getImages | [Image](#image)[] |   |  |
| getAttributes | [AttributeValue](#attributevalue)[] |   |  |
| getAttribute | null&#124;[AttributeValue](#attributevalue) | uid  |  |
| getAvailability | [Availability](#availability) |   |  |
| getUid | string |   |  |
| getName | string |   |  |
| getEan | string |   |  |
| getCode | string |   |  |
| getUpdated | \DateTime |   |  |
| getPrice | float |   |  |
| getPriceRetail | float |   |  |
| getImages | [Image](#image)[] |   |  |
| getAttributes | [AttributeValue](#attributevalue)[] |   |  |
| getAttribute | null&#124;[AttributeValue](#attributevalue) | uid  |  |
| getAvailability | [Availability](#availability) |   |  |
| getUid | string |   |  |
## Video
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getUid | string |   |  |
| getUrl | string |   |  |
| getUpdated | \DateTime |   |  |
| getDuration | \DateTime |   |  |
| getType | string |   |  |
| isTypeYoutube | bool |   |  |
| isTypeVimeo | bool |   |  |
| getCode | string |   |  |
| getUid | string |   |  |
