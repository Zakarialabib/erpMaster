This comprehensive model documentation provides a thorough understanding of the 'Suppliers' table within our ERP software management system. It includes an overview of its purpose, usage of relationships, and details about the architecture of the table's columns.

# Ad 

The 'Ad' model in our ERP software serves as a container for data related to platform advertisements. It facilitates easy management, search, and sorting of ads based on attributes such as status, title, social media, type, image, URL, views, amount, notes, and user_id. Utilizing traits like HasUuid, HasFactory, and HasAdvancedFilter, along with a BelongsToMany relationship with the User model, the 'Ad' model efficiently handles ad-related information.

# AdjustedProduct 

The "AdjustedProduct" model tracks adjustments made to product quantities across warehouses. With a one-to-one relationship with "Adjustment" and "Product" models, and one-to-many with "Warehouse," it stores essential attributes like product_id, warehouse_id, quantity, created_at, and updated_at. Utilizing HasAdvancedFilter, it enables advanced filtering and sorting. The table is named "adjusted_products" in the database.

## Delivery Model

The 'Delivery' model represents specific shipments of ordered goods. With one-to-one relationships with Sale, User, Shipping, and Order models, it stores information like reference number, shipping status, address, shipping ID, document number, and more. The 'Delivery' table includes columns for ID, created_at, updated_at, reference, sale_id, order_id, user_id, shipping_id, document, status, and note. It plays a vital role in ensuring efficient shipping, order tracking, and logistics within our ERP system.

# Expense

The 'Expense' model tracks and monitors organization expenses. Attributes like category_id, date, reference, amount, user_id, warehouse_id, and cash_register_id provide insights into the nature and source of expenses. With advanced filtering and sorting capabilities, the 'Expense' model aids in effective expense tracking and financial management.

# ExpenseCategory

The 'ExpenseCategory' model categorizes expenses based on criteria like project, vendor, or nature. It maintains a one-to-many relationship with the 'expenses' table. The 'expense_categories' table includes id (primary key), name (required and unique), description (optional), and timestamps for record management. Leveraging Laravel's Eloquent ORM and HasAdvancedFilter trait, the model facilitates efficient association with expenses.

# CashRegister

The 'CashRegister' model manages cash payments, offering flexibility and customization. With relationships to the User and Warehouse models, it tracks register activity, current cash, responsible user, and location. The 'CashRegisters' table includes ID, cash_in_hand, user_id, warehouse_id, and status columns. This model provides a seamless way to handle cash transactions in our ERP system.

# Order

The 'Order' model serves as a central hub for managing customer orders seamlessly. It stores essential details like order date, reference, shipping information, total amount, and payment and shipping status. The model establishes connections with customers and tracks individual order items. Optional fields allow for additional details such as special instructions or documents. The 'Order' model efficiently handles the entire process, from order placement to tracking, ensuring a smooth experience for managing customer orders.

# Product 

The 'Product' model serves as a central tool for managing and organizing information about the products we offer. It enables users to effortlessly keep track of various details for each product, such as name, code, status, category, and images. Users can easily search for active products and apply filters based on attributes like name or quantity. The model establishes connections with Categories, Brands, Warehouses, and Movement, providing valuable insights and refining search capabilities. the 'Product' model is a vital component in our ERP system, streamlining the process of managing and accessing essential product information.

# Warehouse

The 'Warehouses' model is a central repository within our ERP system that stores and manages information about various locations where products are stored. The model provides a comprehensive overview of essential details, including the warehouse name, city, country, address, phone number, email, total quantity of products in stock, and the value of those products. Through well-established relationships with users, products, and price information, the 'Warehouses' model facilitates a seamless flow of data, offering a holistic view of business operations. Alongside basic attributes, the model incorporates advanced search and filtering capabilities, enhancing user accessibility to specific warehouse data based on desired criteria.

# Customer

The 'Customer' model in the context of our ERP (Enterprise Resource Planning) software management system represents a person or business entity that uses our software. It has a general purpose to store, manage and retrieve customer information such as their name, email, phone number, address, country, city, etc. This information is crucial for effective communication and support, tracking of transactions, sales and purchases, and overall relationship management with the customers in order to provide them with an optimal experience.

# Supplier

In conclusion, the 'Supplier' model plays a vital role in our ERP software management system by facilitating efficient storage, retrieval, and organization of data related to suppliers. It serves as a central hub for various stakeholders, enabling effective communication, relationship management, and operational efficiency. By leveraging its features and relationships with other models, we can streamline supplier-related processes and enhance the overall experience within our ERP system.

# Customer
