# Property Documentation

## Table: `users`

| Property | Type |
| --- | --- |
| `id` | `uuid` |
| `name` | `string` |
| `email` | `string` |
| `password` | `string` |
| `avatar` | `string` |
| `phone` | `string` |
| `role_id` | `unsignedInteger` |
| `status` | `boolean` |
| `is_all_warehouses` | `boolean` |
| `wallet_id` | `integer` |
| `default_client_id` | `integer` |
| `default_warehouse_id` | `integer` |

## Table: `password_reset_tokens`

| Property | Type |
| --- | --- |
| `email` | `string` |
| `token` | `string` |
| `created_at` | `timestamp` |

## Table: `password_resets`

| Property | Type |
| --- | --- |
| `email` | `string` |
| `token` | `string` |
| `created_at` | `timestamp` |

## Table: ``

| Property | Type |
| --- | --- |
| `identifier` | `string` |
| `instance` | `string` |
| `content` | `longText` |

## Table: `firewall_ips`

| Property | Type |
| --- | --- |
| `id` | `increments` |
| `ip` | `index` |
| `log_id` | `integer` |
| `blocked` | `boolean` |

## Table: `firewall_logs`

| Property | Type |
| --- | --- |
| `id` | `increments` |
| `ip` | `index` |
| `level` | `string` |
| `middleware` | `string` |
| `user_id` | `integer` |
| `url` | `text` |
| `referrer` | `string` |
| `request` | `text` |

## Table: `failed_jobs`

| Property | Type |
| --- | --- |
| `uuid` | `string` |
| `connection` | `text` |
| `queue` | `text` |
| `payload` | `longText` |
| `exception` | `longText` |
| `failed_at` | `timestamp` |

## Table: `personal_access_tokens`

| Property | Type |
| --- | --- |
| `tokenable` | `morphs` |
| `name` | `string` |
| `token` | `string` |
| `abilities` | `text` |
| `last_used_at` | `timestamp` |
| `expires_at` | `timestamp` |

## Table: ``

| Property | Type |
| --- | --- |
| `id` | `bigIncrements` |
| `name` | `string` |
| `guard_name` | `string` |
| `model_type` | `string` |

## Table: `brands`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `image` | `string` |
| `slug` | `string` |
| `description` | `text` |
| `meta_title` | `string` |
| `meta_description` | `string` |
| `origin` | `string` |
| `status` | `boolean` |

## Table: `warehouses`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `city` | `string` |
| `address` | `text` |
| `phone` | `string` |
| `email` | `string` |
| `country` | `string` |

## Table: `categories`

| Property | Type |
| --- | --- |
| `code` | `string` |
| `name` | `string` |
| `description` | `string` |
| `slug` | `string` |
| `image` | `string` |
| `status` | `boolean` |

## Table: `products`

| Property | Type |
| --- | --- |
| `id` | `uuid` |
| `name` | `string` |
| `code` | `string` |
| `barcode_symbology` | `string` |
| `quantity` | `integer` |
| `slug` | `string` |
| `image` | `text` |
| `gallery` | `text` |
| `unit` | `string` |
| `order_tax` | `integer` |
| `description` | `text` |
| `status` | `boolean` |
| `tax_type` | `tinyInteger` |
| `embeded_video` | `text` |
| `subcategories` | `json` |
| `options` | `json` |
| `condition` | `string` |
| `meta_title` | `string` |
| `meta_description` | `string` |
| `featured` | `boolean` |
| `best` | `boolean` |
| `hot` | `boolean` |

## Table: `adjustments`

| Property | Type |
| --- | --- |
| `date` | `date` |
| `reference` | `string` |
| `note` | `text` |

## Table: `adjusted_products`

| Property | Type |
| --- | --- |
| `quantity` | `integer` |
| `type` | `string` |

## Table: `expense_categories`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `description` | `text` |
| `type` | `string` |

## Table: `expenses`

| Property | Type |
| --- | --- |
| `date` | `date` |
| `reference` | `string` |
| `description` | `string` |
| `amount` | `float` |
| `document` | `string` |

## Table: `customer_groups`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `percentage` | `string` |
| `status` | `boolean` |

## Table: `wallets`

| Property | Type |
| --- | --- |
| `id` | `uuid` |
| `recieved_amount` | `string` |
| `sent_amount` | `string` |
| `balance` | `string` |
| `user_id` | `unsignedBigInteger` |
| `customer_id` | `unsignedBigInteger` |
| `supplier_id` | `unsignedBigInteger` |

## Table: `customers`

| Property | Type |
| --- | --- |
| `id` | `uuid` |
| `name` | `string` |
| `phone` | `string` |
| `email` | `string` |
| `city` | `string` |
| `country` | `string` |
| `address` | `text` |
| `tax_number` | `string` |
| `password` | `string` |
| `wallet_id` | `foreignUuid` |
| `status` | `boolean` |

## Table: `suppliers`

| Property | Type |
| --- | --- |
| `id` | `uuid` |
| `name` | `string` |
| `email` | `string` |
| `phone` | `string` |
| `address` | `text` |
| `city` | `string` |
| `country` | `string` |
| `tax_number` | `string` |
| `wallet_id` | `foreignUuid` |

## Table: `currencies`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `code` | `string` |
| `symbol` | `string` |
| `thousand_separator` | `string` |
| `decimal_separator` | `string` |
| `exchange_rate` | `integer` |
| `is_default` | `boolean` |
| `status` | `boolean` |

## Table: `settings`

| Property | Type |
| --- | --- |
| `key` | `string` |
| `lang` | `string` |
| `value` | `text` |

## Table: `sales`

| Property | Type |
| --- | --- |
| `id` | `uuid` |
| `date` | `date` |
| `reference` | `string` |
| `tax_percentage` | `integer` |
| `tax_amount` | `integer` |
| `discount_percentage` | `integer` |
| `discount_amount` | `integer` |
| `shipping_amount` | `integer` |
| `total_amount` | `integer` |
| `paid_amount` | `integer` |
| `due_amount` | `integer` |
| `payment_date` | `date` |
| `status` | `string` |
| `payment_status` | `string` |
| `payment_method` | `string` |
| `shipping_status` | `string` |
| `document` | `string` |
| `note` | `text` |

## Table: `sale_details`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `code` | `string` |
| `quantity` | `integer` |
| `price` | `integer` |
| `unit_price` | `integer` |
| `sub_total` | `integer` |
| `product_discount_amount` | `integer` |
| `product_discount_type` | `string` |
| `product_tax_amount` | `integer` |

## Table: `sale_payments`

| Property | Type |
| --- | --- |
| `amount` | `integer` |
| `date` | `date` |
| `reference` | `string` |
| `payment_method` | `string` |
| `note` | `text` |

## Table: `purchases`

| Property | Type |
| --- | --- |
| `id` | `uuid` |
| `date` | `date` |
| `reference` | `string` |
| `tax_percentage` | `integer` |
| `tax_amount` | `integer` |
| `discount_percentage` | `integer` |
| `discount_amount` | `integer` |
| `shipping_amount` | `integer` |
| `total_amount` | `integer` |
| `paid_amount` | `integer` |
| `due_amount` | `integer` |
| `status` | `string` |
| `payment_status` | `string` |
| `payment_method` | `string` |
| `document` | `string` |
| `note` | `text` |

## Table: `purchase_payments`

| Property | Type |
| --- | --- |
| `amount` | `integer` |
| `date` | `date` |
| `reference` | `string` |
| `payment_method` | `string` |
| `note` | `text` |

## Table: `purchase_details`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `code` | `string` |
| `quantity` | `integer` |
| `price` | `integer` |
| `unit_price` | `integer` |
| `sub_total` | `integer` |
| `product_discount_amount` | `integer` |
| `product_discount_type` | `string` |
| `product_tax_amount` | `integer` |

## Table: `sale_returns`

| Property | Type |
| --- | --- |
| `date` | `date` |
| `reference` | `string` |
| `tax_percentage` | `integer` |
| `tax_amount` | `integer` |
| `discount_percentage` | `integer` |
| `discount_amount` | `integer` |
| `shipping_amount` | `integer` |
| `total_amount` | `integer` |
| `paid_amount` | `integer` |
| `due_amount` | `integer` |
| `status` | `string` |
| `payment_status` | `string` |
| `payment_method` | `string` |
| `note` | `text` |

## Table: `sale_return_details`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `code` | `string` |
| `quantity` | `integer` |
| `price` | `integer` |
| `unit_price` | `integer` |
| `sub_total` | `integer` |
| `discount_amount` | `integer` |
| `discount_type` | `string` |
| `tax_amount` | `integer` |
| `id` | `foreign` |

## Table: `sale_return_payments`

| Property | Type |
| --- | --- |
| `amount` | `integer` |
| `date` | `date` |
| `reference` | `string` |
| `payment_method` | `string` |
| `note` | `text` |

## Table: `purchase_returns`

| Property | Type |
| --- | --- |
| `date` | `date` |
| `reference` | `string` |
| `tax_percentage` | `integer` |
| `tax_amount` | `integer` |
| `discount_percentage` | `integer` |
| `discount_amount` | `integer` |
| `shipping_amount` | `integer` |
| `total_amount` | `integer` |
| `paid_amount` | `integer` |
| `due_amount` | `integer` |
| `status` | `string` |
| `payment_status` | `string` |
| `payment_method` | `string` |
| `note` | `text` |

## Table: `purchase_return_details`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `code` | `string` |
| `quantity` | `integer` |
| `price` | `integer` |
| `unit_price` | `integer` |
| `sub_total` | `integer` |
| `discount_amount` | `integer` |
| `discount_type` | `string` |
| `tax_amount` | `integer` |

## Table: `purchase_return_payments`

| Property | Type |
| --- | --- |
| `amount` | `integer` |
| `date` | `date` |
| `reference` | `string` |
| `payment_method` | `string` |
| `note` | `text` |

## Table: `quotations`

| Property | Type |
| --- | --- |
| `date` | `date` |
| `reference` | `string` |
| `tax_percentage` | `integer` |
| `tax_amount` | `integer` |
| `discount_percentage` | `integer` |
| `discount_amount` | `integer` |
| `shipping_amount` | `integer` |
| `total_amount` | `integer` |
| `status` | `string` |
| `sent_on` | `timestamp` |
| `expires_on` | `timestamp` |
| `note` | `text` |

## Table: `quotation_details`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `code` | `string` |
| `quantity` | `integer` |
| `price` | `integer` |
| `unit_price` | `integer` |
| `sub_total` | `integer` |
| `product_discount_amount` | `integer` |
| `product_discount_type` | `string` |
| `product_tax_amount` | `integer` |

## Table: `product_warehouse`

| Property | Type |
| --- | --- |
| `price` | `integer` |
| `cost` | `integer` |
| `old_price` | `integer` |
| `qty` | `integer` |
| `stock_alert` | `integer` |
| `is_ecommerce` | `boolean` |
| `is_discount` | `tinyInteger` |
| `discount_date` | `date` |

## Table: `user_warehouse`

| Property | Type |
| --- | --- |
| `status` | `boolean` |

## Table: `languages`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `code` | `string` |
| `rtl` | `boolean` |
| `status` | `integer` |
| `is_default` | `boolean` |

## Table: `media`

| Property | Type |
| --- | --- |
| `id` | `bigIncrements` |
| `model` | `morphs` |
| `uuid` | `uuid` |
| `collection_name` | `string` |
| `name` | `string` |
| `file_name` | `string` |
| `mime_type` | `string` |
| `disk` | `string` |
| `conversions_disk` | `string` |
| `size` | `unsignedBigInteger` |
| `manipulations` | `json` |
| `custom_properties` | `json` |
| `generated_conversions` | `json` |
| `responsive_images` | `json` |
| `order_column` | `unsignedInteger` |

## Table: `sessions`

| Property | Type |
| --- | --- |
| `id` | `string` |
| `user_id` | `foreignId` |
| `ip_address` | `string` |
| `user_agent` | `text` |
| `payload` | `longText` |
| `last_activity` | `integer` |

## Table: `pages`

| Property | Type |
| --- | --- |
| `title` | `string` |
| `slug` | `string` |
| `description` | `json` |
| `image` | `string` |
| `type` | `string` |
| `meta_title` | `string` |
| `meta_description` | `string` |
| `is_sliders` | `tinyInteger` |
| `is_contact` | `tinyInteger` |
| `is_offer` | `tinyInteger` |
| `is_title` | `tinyInteger` |
| `is_description` | `tinyInteger` |
| `status` | `tinyInteger` |

## Table: `orderforms`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `email` | `string` |
| `phone` | `string` |
| `address` | `string` |
| `type` | `string` |
| `status` | `tinyInteger` |
| `subject` | `string` |
| `message` | `string` |

## Table: `subcategories`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `slug` | `string` |
| `image` | `string` |
| `status` | `tinyInteger` |
| `category_id` | `foreignId` |
| `language_id` | `foreignId` |

## Table: `sliders`

| Property | Type |
| --- | --- |
| `subtitle` | `string` |
| `title` | `string` |
| `description` | `string` |
| `image` | `string` |
| `bg_color` | `string` |
| `text_color` | `string` |
| `featured` | `boolean` |
| `link` | `string` |
| `status` | `string` |
| `embeded_video` | `text` |
| `page_id` | `foreignId` |
| `language_id` | `foreignId` |

## Table: `sections`

| Property | Type |
| --- | --- |
| `title` | `text` |
| `image` | `string` |
| `featured_title` | `text` |
| `subtitle` | `text` |
| `label` | `text` |
| `link` | `string` |
| `description` | `text` |
| `status` | `boolean` |
| `bg_color` | `string` |
| `page` | `string` |
| `position` | `string` |
| `language_id` | `foreignId` |

## Table: `packagings`

| Property | Type |
| --- | --- |
| `title` | `string` |
| `subtitle` | `string` |
| `cost` | `decimal` |

## Table: `featured_banners`

| Property | Type |
| --- | --- |
| `title` | `string` |
| `description` | `text` |
| `image` | `string` |
| `status` | `boolean` |
| `featured` | `boolean` |
| `link` | `string` |
| `embeded_video` | `text` |
| `language_id` | `foreignId` |
| `product_id` | `foreignUuid` |

## Table: `blog_categories`

| Property | Type |
| --- | --- |
| `title` | `string` |
| `description` | `text` |
| `status` | `boolean` |
| `featured` | `boolean` |
| `meta_title` | `text` |
| `meta_description` | `text` |
| `language_id` | `foreignId` |

## Table: `blogs`

| Property | Type |
| --- | --- |
| `title` | `string` |
| `description` | `text` |
| `image` | `string` |
| `slug` | `string` |
| `status` | `boolean` |
| `featured` | `boolean` |
| `meta_title` | `text` |
| `meta_description` | `text` |
| `category_id` | `foreignId` |
| `language_id` | `foreignId` |

## Table: `pagesettings`

| Property | Type |
| --- | --- |
| `header` | `string` |
| `footer` | `string` |
| `bottomBar` | `string` |
| `topHeader` | `string` |
| `bottomFooter` | `string` |
| `themeColor` | `boolean` |
| `popularProducts` | `boolean` |
| `flashDeal` | `boolean` |
| `bestSellers` | `boolean` |
| `topBrands` | `boolean` |
| `status` | `string` |
| `featured_banner_id` | `foreignId` |
| `page_id` | `foreignId` |
| `language_id` | `foreignId` |

## Table: `shippings`

| Property | Type |
| --- | --- |
| `is_pickup` | `boolean` |
| `title` | `string` |
| `subtitle` | `string` |
| `cost` | `decimal` |
| `status` | `boolean` |

## Table: `orders`

| Property | Type |
| --- | --- |
| `id` | `uuid` |
| `date` | `date` |
| `reference` | `string` |
| `shipping_id` | `foreignId` |
| `packaging_id` | `foreignId` |
| `tax_percentage` | `integer` |
| `tax_amount` | `integer` |
| `discount_percentage` | `integer` |
| `discount_amount` | `integer` |
| `shipping_amount` | `integer` |
| `total_amount` | `integer` |
| `paid_amount` | `integer` |
| `due_amount` | `integer` |
| `payment_date` | `date` |
| `status` | `string` |
| `payment_status` | `string` |
| `payment_method` | `string` |
| `shipping_status` | `string` |
| `document` | `string` |
| `note` | `text` |

## Table: `reviews`

| Property | Type |
| --- | --- |
| `rating` | `integer` |
| `comment` | `text` |
| `product_id` | `foreignUuid` |
| `customer_id` | `foreignUuid` |

## Table: `printers`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `connection_type` | `enum` |
| `capability_profile` | `enum` |
| `char_per_line` | `string` |
| `ip_address` | `string` |
| `port` | `string` |
| `path` | `string` |

## Table: `cash_registers`

| Property | Type |
| --- | --- |
| `cash_in_hand` | `double` |
| `status` | `boolean` |

## Table: `integrations`

| Property | Type |
| --- | --- |
| `id` | `uuid` |
| `type` | `integer` |
| `store_url` | `string` |
| `api_key` | `string` |
| `sandbox` | `string` |
| `api_secret` | `string` |
| `last_sync` | `string` |
| `products` | `string` |
| `orders` | `string` |
| `status` | `boolean` |

## Table: `popups`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `width` | `string` |
| `background_color` | `string` |
| `frequency` | `string` |
| `timing` | `string` |
| `delay` | `integer` |
| `duration` | `integer` |
| `visits` | `integer` |
| `content` | `text` |
| `cta_text` | `string` |
| `cta_url` | `string` |
| `status` | `boolean` |
| `is_default` | `boolean` |

## Table: `redirects`

| Property | Type |
| --- | --- |
| `old_url` | `string` |
| `new_url` | `string` |
| `http_status_code` | `string` |
| `status` | `boolean` |

## Table: `notifications`

| Property | Type |
| --- | --- |
| `id` | `uuid` |
| `type` | `string` |
| `notifiable` | `uuidMorphs` |
| `data` | `text` |
| `read_at` | `timestamp` |

## Table: `subscribers`

| Property | Type |
| --- | --- |
| `email` | `string` |
| `name` | `string` |
| `tag` | `string` |
| `status` | `boolean` |

## Table: `jobs`

| Property | Type |
| --- | --- |
| `id` | `bigIncrements` |
| `queue` | `string` |
| `payload` | `longText` |
| `attempts` | `unsignedTinyInteger` |
| `reserved_at` | `unsignedInteger` |
| `available_at` | `unsignedInteger` |
| `created_at` | `unsignedInteger` |

## Table: `transfers`

| Property | Type |
| --- | --- |
| `id` | `uuid` |
| `reference` | `string` |
| `from_warehouse_id` | `integer` |
| `to_warehouse_id` | `integer` |
| `item` | `integer` |
| `total_qty` | `double` |
| `total_tax` | `double` |
| `total_cost` | `double` |
| `total_amount` | `double` |
| `shipping` | `double` |
| `document` | `string` |
| `status` | `integer` |
| `note` | `text` |

## Table: `movements`

| Property | Type |
| --- | --- |
| `type` | `string` |
| `quantity` | `unsignedInteger` |
| `price` | `decimal` |
| `date` | `dateTime` |
| `movable_id` | `uuid` |
| `movable_type` | `string` |
| `user_id` | `foreignUuid` |

## Table: `price_histories`

| Property | Type |
| --- | --- |
| `cost` | `integer` |
| `effective_date` | `date` |
| `expiry_date` | `date` |

## Table: `email_templates`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `description` | `text` |
| `message` | `text` |
| `default` | `text` |
| `placeholders` | `json` |
| `type` | `string` |
| `subject` | `string` |
| `status` | `string` |

## Table: `menus`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `label` | `string` |
| `url` | `string` |
| `type` | `char` |
| `placement` | `string` |
| `sort_order` | `integer` |
| `parent_id` | `integer` |
| `icon` | `string` |
| `new_window` | `boolean` |
| `status` | `integer` |

## Table: `queue_monitors`

| Property | Type |
| --- | --- |
| `job_id` | `string` |
| `name` | `string` |
| `queue` | `string` |
| `started_at` | `timestamp` |
| `finished_at` | `timestamp` |
| `failed` | `boolean` |
| `attempt` | `integer` |
| `progress` | `integer` |
| `exception_message` | `text` |

## Table: `contacts`

| Property | Type |
| --- | --- |
| `name` | `string` |
| `email` | `string` |
| `phone_number` | `string` |
| `subject` | `string` |
| `type` | `string` |
| `message` | `mediumText` |

