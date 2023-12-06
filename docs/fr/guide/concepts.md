---
title: Concepts
lang: fr-FR
---
    
# Ad 

The 'Ad' model in our ERP software serves as a container for data related to platform advertisements. It facilitates easy management, search, and sorting of ads based on attributes such as status, title, social media, type, image, URL, views, amount, notes, and user_id. Utilizing traits like HasUuid, HasFactory, and HasAdvancedFilter, along with a BelongsToMany relationship with the User model, the 'Ad' model efficiently handles ad-related information.

# AdjustedProduct 

The "AdjustedProduct" model tracks adjustments made to product quantities across warehouses. With a one-to-one relationship with "Adjustment" and "Product" models, and one-to-many with "Warehouse," it stores essential attributes like product_id, warehouse_id, quantity, created_at, and updated_at. Utilizing HasAdvancedFilter, it enables advanced filtering and sorting. The table is named "adjusted_products" in the database.

## Delivery Model

The 'Delivery' model represents specific shipments of ordered goods. With one-to-one relationships with Sale, User, Shipping, and Order models, it stores information like reference number, shipping status, address, shipping ID, document number, and more. The 'Delivery' table includes columns for ID, created_at, updated_at, reference, sale_id, order_id, user_id, shipping_id, document, status, and note. It plays a vital role in ensuring efficient shipping, order tracking, and logistics within our ERP system.

# Expense

Les dépenses peuvent être classées en catégories (par exemple : frais de transport, charges de personnel, fournitures de bureau, etc.). Ainsi, la fonction "dépense" dépend de la fonction "catégorie", car il est nécessaire de créer des catégories avant de pouvoir enregistrer des dépenses.

The 'Expense' model tracks and monitors organization expenses. Attributes like category_id, date, reference, amount, user_id, warehouse_id, and cash_register_id provide insights into the nature and source of expenses. With advanced filtering and sorting capabilities, the 'Expense' model aids in effective expense tracking and financial management.

# ExpenseCategory

The 'ExpenseCategory' model categorizes expenses based on criteria like project, vendor, or nature. It maintains a one-to-many relationship with the 'expenses' table. The 'expense_categories' table includes id (primary key), name (required and unique), description (optional), and timestamps for record management. Leveraging Laravel's Eloquent ORM and HasAdvancedFilter trait, the model facilitates efficient association with expenses.

# CashRegister

The 'CashRegister' model manages cash payments, offering flexibility and customization. With relationships to the User and Warehouse models, it tracks register activity, current cash, responsible user, and location. The 'CashRegisters' table includes ID, cash_in_hand, user_id, warehouse_id, and status columns. This model provides a seamless way to handle cash transactions in our ERP system.

# Order

The 'Order' model serves as a central hub for managing customer orders seamlessly. It stores essential details like order date, reference, shipping information, total amount, and payment and shipping status. The model establishes connections with customers and tracks individual order items. Optional fields allow for additional details such as special instructions or documents. The 'Order' model efficiently handles the entire process, from order placement to tracking, ensuring a smooth experience for managing customer orders.

# Product 

Les produits sont généralement classés en catégories, ce qui permet une meilleure organisation et une recherche plus facile. Ainsi, la fonction "produit" dépend de la fonction "catégorie", car il est nécessaire de créer des catégories avant de pouvoir ajouter des produits.


The 'Product' model serves as a central tool for managing and organizing information about the products we offer. It enables users to effortlessly keep track of various details for each product, such as name, code, status, category, and images. Users can easily search for active products and apply filters based on attributes like name or quantity. The model establishes connections with Categories, Brands, Warehouses, and Movement, providing valuable insights and refining search capabilities. the 'Product' model is a vital component in our ERP system, streamlining the process of managing and accessing essential product information.

# Warehouse

The 'Warehouses' model is a central repository within our ERP system that stores and manages information about various locations where products are stored. The model provides a comprehensive overview of essential details, including the warehouse name, city, country, address, phone number, email, total quantity of products in stock, and the value of those products. Through well-established relationships with users, products, and price information, the 'Warehouses' model facilitates a seamless flow of data, offering a holistic view of business operations. Alongside basic attributes, the model incorporates advanced search and filtering capabilities, enhancing user accessibility to specific warehouse data based on desired criteria.

# Sale

Les ventes dépendent à la fois des clients et des produits. En effet, il est nécessaire d'avoir une liste de clients pour pouvoir enregistrer une vente, et il est également nécessaire de sélectionner les produits vendus.

# Purchase 

Les achats dépendent également des produits, mais aussi des fournisseurs. Il est nécessaire d'avoir une liste de fournisseurs pour pouvoir effectuer des achats, et il est également nécessaire de sélectionner les produits achetés.

# Facilité d'accès aux produits 

La nomination et l'utilisation de codes pour faciliter l'accès aux produits sont des pratiques très importantes pour la gestion d’ un grand nombre de produits ou d'articles.
l'utilisation de codes permet de classer et de catégoriser les produits de manière plus efficace et systématique, ce qui facilite la recherche, la gestion et l'organisation des produits. Les codes peuvent être utilisés pour identifier des catégories spécifiques de produits, des sous-catégories, des tailles, des couleurs, des variantes et bien plus encore.

# Pourquoi cette solution : avantages et qualités 

- Tableau de bord dynamique
Obtenez un aperçu global de toutes les informations relatives à votre activité  en un seul endroit grâce à notre tableau de bord, où vous pouvez visualiser des rapports sur des graphiques chronologiques et obtenir rapidement des informations sur les produits clients fournisseurs achat et vente rapidement.
- Report 
Consultez l'historique des transactions, ainsi que les niveaux de stock que vous avez. De cette manière, vous pouvez toujours être au courant des produits en stock, des produits qui doivent être réapprovisionnés et des produits performants.
- Gestion Commercial
l'automatisation des tâches répétitives permet de se concentrer sur des tâches plus importantes et de gagner du temps dans leur travail quotidien, permet de collecter et d'analyser les données plus rapidement et plus précisément que les méthodes manuelles.
les entreprises ont une meilleure visibilité sur leurs ventes, leurs achats, leurs stocks et leur rentabilité.
- Alertes de quantité de produit
Système d'alerte intégré pour les quantités de produits, qui vous informera lorsque les stocks de tout élément spécifique sont faibles. 
