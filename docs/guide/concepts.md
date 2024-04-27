This comprehensive model documentation provides a thorough understanding of the 'Suppliers' table within our ERP software management system. It includes an overview of its purpose, usage of relationships, and details about the architecture of the table's columns.

# Ad
The 'Ad' model in our ERP software management system is a representation of an online advertisement. It serves as a repository for information related to different types of ads, such as their titles, social media platforms, images, URLs, views, and associated payment details.
The 'Ad' model has several key features and relationships that contribute to its functionality. First, it has a one-to-one relationship with the 'User' model, which links the ad to the user who created it. Second, it has a one-to-many relationship with the 'Package' model, representing the various packages or plans that users can purchase for advertising. Additionally, it has a many-to-many relationship with the 'User' model through the 'UserViews' table, which allows tracking user engagement with the ad.
The 'Ad' model also includes enums for 'Status' and 'AdType' to provide additional data validation and type-safety for these attributes.
The 'AdjustedProduct' model in the context of the ERP software management system represents a record of a product's adjusted quantity. This model maintains information about the amount of a product that is adjusted due to various operations like sales, purchases, or inventory changes. It helps keep track of the product's real-time availability and movement within the system.

# AdjustedProduct
The 'adjusted_products' table is a part of the database and stores the necessary details for each adjusted product. It is linked to other tables such as 'adjustments', 'products', and 'warehouses' through relationships. The relationships are established using the foreign key columns 'adjustment_id', 'product_id', and 'warehouse_id' in the 'adjusted_products' table that refer to the primary key columns of the other tables.

In the 'AdjustedProduct' model, we have defined attributes like 'id', 'product_id', 'warehouse_id', 'quantity', 'created_at', and 'updated_at'. These attributes represent the individual fields of the 'adjusted_products' table. The model also uses the 'HasAdvancedFilter' trait to facilitate filtering based on these attributes.

The 'adjustment()', 'product()', and 'warehouse()' methods are the relationships defined in the model, which allow accessing the corresponding records from the 'adjustments', 'products', and 'warehouses' tables through their primary keys.

In conclusion, the 'AdjustedProduct' model serves as a crucial component in the ERP software management system, tracking the adjusted quantities of products within the system and maintaining relationships with relevant entities. It helps in handling various business operations and is an essential part of the software's data architecture.


## Adjustment
The 'adjustments' table is the database representation of the 'Adjustment' model. It stores essential details like the unique 'id', 'reference_no' (a reference number that helps identify the adjustment), 'warehouse_id' (the warehouse to which the adjustment is applied), 'date' (the date when the adjustment is made), and other timestamps for 'created_at' and 'updated_at'. The 'date' attribute is formatted using a custom cast to display the date in a user-friendly format.

The 'Adjustment' model has relationships defined to other models in the system. It belongs to a 'user' (the user who made the adjustment), a 'warehouse' (where the adjustment is made), and has many 'adjusted_products' (a separate model that stores detailed information about the products involved in the adjustment).

The 'Adjustment' model also has custom logic defined in the 'boot' method. It automatically generates a unique reference number based on a prefix ('ADJ') and the maximum id of existing adjustments, ensuring that the reference numbers are always unique. This helps in tracking and organizing the adjustments within the system.

In summary, the 'Adjustment' model in the ERP system is a crucial component that allows managing financial adjustments and their impact on the inventory. It is designed with relationships to other models in the system, and has custom logic to ensure proper data management and organization.
The 'AdsUser' model is an important component of the ERP software management system, as it is used to establish a relationship between advertisers and users. In this context, the 'AdsUser' model essentially acts as a bridge between the 'users' and 'ads' models. It holds information such as the 'user_id', which corresponds to the user who has an association with the ad, and the 'ads_id', which refers to the specific ad in question. The 'status' field is also a crucial aspect of the model, as it can be used to track the current status of the ad and user relationship (e.g., active, inactive, or pending).

## AdsUser
The 'ads_users' table, which is the underlying database component that backs the 'AdsUser' model, is a typical many-to-many relationship table. This table serves as a pivot table that allows the connection between the 'users' and 'ads' tables, enabling multiple 'users' to be associated with a single 'ad' and vice versa. The 'ads_users' table stores the primary keys of both the 'users' and 'ads' tables, along with any additional columns that the model might define (such as the 'status' column).

In summary, the 'AdsUser' model plays a critical role in the ERP software management system by creating a link between advertisers and users, facilitating the tracking and management of ad-user relationships, and providing valuable insights for the overall system.

The model's architecture, as reflected in the code, is designed to handle the necessary relationships and attributes efficiently, ensuring that the ERP software management system can effectively manage the ad-user relationships.
The 'Blog' model in our ERP software management system serves as a way to manage a collection of articles or content pieces. Its primary purpose is to create a medium for sharing information within the system. Each blog has attributes like title, description, featured status, slug, language, and category to help categorize and organize content.

## Blog
The 'Blogs' table has relationships with other models such as 'BlogCategory' and 'Language'. The 'category_id' attribute establishes a one-to-many relationship with the 'BlogCategory' model, allowing blogs to be associated with a specific category. Similarly, the 'language_id' attribute creates a one-to-many relationship with the 'Language' model, enabling the association of blogs with different languages for internationalization purposes. These relationships assist in organizing and managing the content in a structured manner.

In summary, the 'Blog' model is a core component of the ERP software management system, enabling content creation, organization, and management through its attributes, associations, and querying capabilities.

The BlogCategory model is an essential part of our ERP software management system, specifically designed to handle the categorization of blog entries. Its primary purpose is to provide a way to organize and structure blog content, making it easier for users to navigate and find relevant information.

### BlogCategory
The code above defines the 'BlogCategory' model in the context of an ERP software management system. This model represents a category for blog entries and is responsible for organizing and structuring the blog content.

The 'BlogCategory' model has a set of attributes, such as 'id', 'title', 'featured', 'status', and 'language_id', which represent the unique identifier, category title, whether it's featured or not, the status, and the associated language, respectively.

To summarize, the 'BlogCategory' model in the ERP software management system is responsible for organizing and categorizing blog entries, which in turn facilitates easy navigation and content discovery. It is implemented with relationships and features that enhance the system's overall functionality and usability.

### Brand
The 'Brand' model in the context of the ERP software management system plays a crucial role in classifying and organizing products and services offered by various companies. It serves as a fundamental unit to manage and differentiate products based on their origin and attributes. This model stores information about individual brands such as their name, image, description, and unique slug. It also allows users to define custom meta-tags for better indexing in search engines.

Furthermore, the 'Brand' model establishes a many-to-one relationship with the 'Product' model, which represents individual items offered by a brand. This relationship enables efficient retrieval and management of products associated with specific brands within the system. The 'Brand' model also includes a scope named 'Active' that filters out brands with a status set to 'false', providing a convenient way to retrieve only active brands for various operations.

The 'Brand' model is a vital component in the ERP software management system, ensuring efficient brand management, product organization, and facilitating various business operations across the system.

### CashRegister
The CashRegister model in our ERP software management system is responsible for tracking and managing cash transactions and storage. It has a general purpose of keeping a record of the amount of cash in hand, the user associated with the cash register, and the warehouse it belongs to.

The 'cash_registers' table in the database represents the CashRegister model. It consists of columns such as 'id', 'cash_in_hand', 'user_id', 'warehouse_id', and 'status', among others. The 'cash_in_hand' column represents the current amount of cash available in the register. The 'user_id' column is a foreign key that establishes a relationship with the 'users' table, which contains information about the user associated with the cash register. Similarly, the 'warehouse_id' column is a foreign key that establishes a relationship with the 'warehouses' table, which contains information about the warehouse where the cash register is located. The 'status' column can be used to define the current state of the cash register (e.g., active, inactive, or under maintenance). Other columns like 'received' and 'sent' track cash transactions that happened in the register.

The relationships with other models (users and warehouses) are set up using the Eloquent ORM's 'belongsTo' method, which allows us to retrieve data from associated tables without writing complex SQL queries. This makes it easier to query and manipulate the cash register data in our software. Additionally, the 'HasAdvancedFilter' trait is used for applying advanced filtering and ordering options on the 'cash_registers' table.

In summary, the CashRegister model represents a basic unit of cash storage and management in the ERP system. It includes relationships with users and warehouses, as well as columns for tracking the amount of cash in hand and its status.

### Customer
Here, we have a class called `Customer` which extends Laravel's built-in `Authenticatable` class to handle authentication. It uses traits such as `HasRoles` (from the package spatie/laravel-permission) for handling roles and permissions, `HasAdvancedFilter` for advanced search capabilities, and `HasUuid` for generating unique identifiers.



]