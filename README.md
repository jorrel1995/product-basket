Tech Test Explaination 

I ensured that the business logic was strictly in the Basket Service file

Added functions in the basket.js for onclick actions such as updating the quantity, adding, and deleting items. 

Created a seeder to bulk create items, testing if the functionality will work correctly with multiple items in the basket. 

Created custom validations for the products so that firstly the validation is dedicated to the products request only and secondly to ensure the product exists and at least one quantity has been added.

Added Conditions on the blade files if the product is out of stock, no products exist, no items are in the basket to improve UX

Locally i set up via docker, this helped in regards to changing php version as it was required to be 8.1 maximum 

Created Unit Testing just to affirm that the functionality is working correctly in BasketControllerTest