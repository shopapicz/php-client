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
| getText | string&#124;null |   |  |
| getHours | int&#124;null |   |  |
| getCode | string&#124;null |   |  |
| getQuantity | int&#124;null |   |  |
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
| getUpdated | DateTime |   |  |
| getMd5 | string |   |  |
| getUid | string |   |  |
## Product
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getUid | string |   |  |
| getName | string&#124;null |   |  |
| getEan | string&#124;null |   |  |
| getCode | string&#124;null |   |  |
| getUpdated | DateTime |   |  |
| getPrice | float&#124;null |   |  |
| getPriceRetail | float&#124;null |   |  |
| getImages | [Image](#image)[] |   |  |
| getAttributes | [AttributeValue](#attributevalue)[] |   |  |
| getAttribute | [AttributeValue](#attributevalue)&#124;null | uid  |  |
| getAvailability | [Availability](#availability) |   |  |
| getUid | string |   |  |
| getVariants | [Variant](#variant)[] |   |  |
| getCategories | [Category](#category)[] |   |  |
| getVideos | [Video](#video)[] |   |  |
| getDescription | string&#124;null |   |  |
| getFullDescription | string&#124;null |   |  |
| getUrl | string&#124;null |   |  |
| getVatRate | float&#124;null |   |  |
| getWarranty | int&#124;null |   |  |
| getBrand | [Brand](#brand)&#124;null |   |  |
| getCreated | DateTime |   |  |
| isDeleted | bool |   |  |
| getChecksum | string |   |  |
| getName | string&#124;null |   |  |
| getEan | string&#124;null |   |  |
| getCode | string&#124;null |   |  |
| getUpdated | DateTime |   |  |
| getPrice | float&#124;null |   |  |
| getPriceRetail | float&#124;null |   |  |
| getImages | [Image](#image)[] |   |  |
| getAttributes | [AttributeValue](#attributevalue)[] |   |  |
| getAttribute | [AttributeValue](#attributevalue)&#124;null | uid  |  |
| getAvailability | [Availability](#availability) |   |  |
| getUid | string |   |  |
## Variant
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getUid | string |   |  |
| getName | string&#124;null |   |  |
| getEan | string&#124;null |   |  |
| getCode | string&#124;null |   |  |
| getUpdated | DateTime |   |  |
| getPrice | float&#124;null |   |  |
| getPriceRetail | float&#124;null |   |  |
| getImages | [Image](#image)[] |   |  |
| getAttributes | [AttributeValue](#attributevalue)[] |   |  |
| getAttribute | [AttributeValue](#attributevalue)&#124;null | uid  |  |
| getAvailability | [Availability](#availability) |   |  |
| getUid | string |   |  |
| getName | string&#124;null |   |  |
| getEan | string&#124;null |   |  |
| getCode | string&#124;null |   |  |
| getUpdated | DateTime |   |  |
| getPrice | float&#124;null |   |  |
| getPriceRetail | float&#124;null |   |  |
| getImages | [Image](#image)[] |   |  |
| getAttributes | [AttributeValue](#attributevalue)[] |   |  |
| getAttribute | [AttributeValue](#attributevalue)&#124;null | uid  |  |
| getAvailability | [Availability](#availability) |   |  |
| getUid | string |   |  |
## Video
| Method | Return type | Arguments |Description |
| ------------- |-------------| -----| -----|
| getUid | string |   |  |
| getUrl | string |   |  |
| getUpdated | DateTime |   |  |
| getDuration | DateTime&#124;null |   |  |
| getType | string |   |  |
| isTypeYoutube | bool |   |  |
| isTypeVimeo | bool |   |  |
| getCode | string&#124;null |   |  |
| getUid | string |   |  |
