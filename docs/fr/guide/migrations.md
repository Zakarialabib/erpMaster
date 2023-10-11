Table: `users`
Properties: 'id', 'name', 'email', 'password', 'avatar', 'phone', 'role_id', 'status', 'is_all_warehouses', 'wallet_id', 'default_client_id', 'default_warehouse_id'

Property Types:
protected uuid $id;
protected string $name;
protected string $email;
protected string $password;
protected string $avatar;
protected string $phone;
protected unsignedInteger $role_id;
protected boolean $status;
protected boolean $is_all_warehouses;
protected integer $wallet_id;
protected integer $default_client_id;
protected integer $default_warehouse_id;

Table: `password_reset_tokens`
Properties: 'email', 'token', 'created_at'

Property Types:
protected string $email;
protected string $token;
protected timestamp $created_at;

Table: `password_resets`
Properties: 'email', 'token', 'created_at'

Property Types:
protected string $email;
protected string $token;
protected timestamp $created_at;

Table: `firewall_ips`
Properties: 'id', 'ip', 'log_id', 'blocked'

Property Types:
protected increments $id;
protected index $ip;
protected integer $log_id;
protected boolean $blocked;

Table: `firewall_logs`
Properties: 'id', 'ip', 'level', 'middleware', 'user_id', 'url', 'referrer', 'request'

Property Types:
protected increments $id;
protected index $ip;
protected string $level;
protected string $middleware;
protected integer $user_id;
protected text $url;
protected string $referrer;
protected text $request;

Table: `failed_jobs`
Properties: 'uuid', 'connection', 'queue', 'payload', 'exception', 'failed_at'

Property Types:
protected string $uuid;
protected text $connection;
protected text $queue;
protected longText $payload;
protected longText $exception;
protected timestamp $failed_at;

Table: `personal_access_tokens`
Properties: 'tokenable', 'name', 'token', 'abilities', 'last_used_at', 'expires_at'

Property Types:
protected morphs $tokenable;
protected string $name;
protected string $token;
protected text $abilities;
protected timestamp $last_used_at;
protected timestamp $expires_at;

Table: ``
Properties: 'id', 'name', 'guard_name', 'model_type'

Property Types:
protected bigIncrements $id;
protected string $name;
protected string $guard_name;
protected string $model_type;

Table: `brands`
Properties: 'name', 'image', 'slug', 'description', 'status', 'featured_image', 'meta_title', 'meta_description', 'origin'

Property Types:
protected string $name;
protected string $image;
protected string $slug;
protected text $description;
protected boolean $status;
protected string $featured_image;
protected string $meta_title;
protected string $meta_description;
protected string $origin;

Table: `warehouses`
Properties: 'name', 'city', 'address', 'phone', 'email', 'country'

Property Types:
protected string $name;
protected string $city;
protected text $address;
protected string $phone;
protected string $email;
protected string $country;

Table: `categories`
Properties: 'code', 'name', 'description', 'slug', 'image', 'status'

Property Types:
protected string $code;
protected string $name;
protected string $description;
protected string $slug;
protected string $image;
protected boolean $status;

Table: `products`
Properties: 'id', 'name', 'code', 'barcode_symbology', 'quantity', 'slug', 'image', 'gallery', 'unit', 'order_tax', 'description', 'status', 'tax_type', 'featured', 'condition', 'embeded_video', 'subcategories', 'options', 'meta_title', 'meta_description', 'best', 'hot'

Property Types:
protected uuid $id;
protected string $name;
protected string $code;
protected string $barcode_symbology;
protected integer $quantity;
protected string $slug;
protected text $image;
protected text $gallery;
protected string $unit;
protected integer $order_tax;
protected text $description;
protected boolean $status;
protected tinyInteger $tax_type;
protected boolean $featured;
protected string $condition;
protected text $embeded_video;
protected json $subcategories;
protected json $options;
protected string $meta_title;
protected string $meta_description;
protected boolean $best;
protected boolean $hot;

Table: `adjustments`
Properties: 'date', 'reference', 'note'

Property Types:
protected date $date;
protected string $reference;
protected text $note;

Table: `adjusted_products`
Properties: 'quantity', 'type'

Property Types:
protected integer $quantity;
protected string $type;

Table: `expense_categories`
Properties: 'name', 'description', 'type'

Property Types:
protected string $name;
protected text $description;
protected string $type;

Table: `expenses`
Properties: 'date', 'reference', 'description', 'amount', 'document'

Property Types:
protected date $date;
protected string $reference;
protected string $description;
protected float $amount;
protected string $document;

Table: `customer_groups`
Properties: 'name', 'percentage', 'status'

Property Types:
protected string $name;
protected string $percentage;
protected boolean $status;

Table: `wallets`
Properties: 'id', 'recieved_amount', 'sent_amount', 'balance', 'user_id', 'customer_id', 'supplier_id'

Property Types:
protected uuid $id;
protected string $recieved_amount;
protected string $sent_amount;
protected string $balance;
protected unsignedBigInteger $user_id;
protected unsignedBigInteger $customer_id;
protected unsignedBigInteger $supplier_id;

Table: `customers`
Properties: 'id', 'name', 'phone', 'email', 'city', 'country', 'address', 'tax_number', 'password', 'wallet_id', 'status'

Property Types:
protected uuid $id;
protected string $name;
protected string $phone;
protected string $email;
protected string $city;
protected string $country;
protected text $address;
protected string $tax_number;
protected string $password;
protected foreignUuid $wallet_id;
protected boolean $status;

Table: `suppliers`
Properties: 'id', 'name', 'email', 'phone', 'address', 'city', 'country', 'tax_number', 'wallet_id'

Property Types:
protected uuid $id;
protected string $name;
protected string $email;
protected string $phone;
protected text $address;
protected string $city;
protected string $country;
protected string $tax_number;
protected foreignUuid $wallet_id;

Table: `currencies`
Properties: 'name', 'code', 'symbol', 'thousand_separator', 'decimal_separator', 'exchange_rate'

Property Types:
protected string $name;
protected string $code;
protected string $symbol;
protected string $thousand_separator;
protected string $decimal_separator;
protected integer $exchange_rate;

Table: `settings`
Properties: 'key', 'lang', 'value'

Property Types:
protected string $key;
protected string $lang;
protected text $value;

Table: `sales`
Properties: 'id', 'date', 'reference', 'tax_percentage', 'tax_amount', 'discount_percentage', 'discount_amount', 'shipping_amount', 'total_amount', 'paid_amount', 'due_amount', 'payment_date', 'status', 'payment_status', 'payment_method', 'shipping_status', 'document', 'note'

Property Types:
protected uuid $id;
protected date $date;
protected string $reference;
protected integer $tax_percentage;
protected integer $tax_amount;
protected integer $discount_percentage;
protected integer $discount_amount;
protected integer $shipping_amount;
protected integer $total_amount;
protected integer $paid_amount;
protected integer $due_amount;
protected date $payment_date;
protected string $status;
protected string $payment_status;
protected string $payment_method;
protected string $shipping_status;
protected string $document;
protected text $note;

Table: `sale_details`
Properties: 'name', 'code', 'quantity', 'price', 'unit_price', 'sub_total', 'product_discount_amount', 'product_discount_type', 'product_tax_amount'

Property Types:
protected string $name;
protected string $code;
protected integer $quantity;
protected integer $price;
protected integer $unit_price;
protected integer $sub_total;
protected integer $product_discount_amount;
protected string $product_discount_type;
protected integer $product_tax_amount;

Table: `sale_payments`
Properties: 'amount', 'date', 'reference', 'payment_method', 'note'

Property Types:
protected integer $amount;
protected date $date;
protected string $reference;
protected string $payment_method;
protected text $note;

Table: `purchases`
Properties: 'id', 'date', 'reference', 'tax_percentage', 'tax_amount', 'discount_percentage', 'discount_amount', 'shipping_amount', 'total_amount', 'paid_amount', 'due_amount', 'status', 'payment_status', 'payment_method', 'document', 'note'

Property Types:
protected uuid $id;
protected date $date;
protected string $reference;
protected integer $tax_percentage;
protected integer $tax_amount;
protected integer $discount_percentage;
protected integer $discount_amount;
protected integer $shipping_amount;
protected integer $total_amount;
protected integer $paid_amount;
protected integer $due_amount;
protected string $status;
protected string $payment_status;
protected string $payment_method;
protected string $document;
protected text $note;

Table: `purchase_payments`
Properties: 'amount', 'date', 'reference', 'payment_method', 'note'

Property Types:
protected integer $amount;
protected date $date;
protected string $reference;
protected string $payment_method;
protected text $note;

Table: `purchase_details`
Properties: 'name', 'code', 'quantity', 'price', 'unit_price', 'sub_total', 'product_discount_amount', 'product_discount_type', 'product_tax_amount'

Property Types:
protected string $name;
protected string $code;
protected integer $quantity;
protected integer $price;
protected integer $unit_price;
protected integer $sub_total;
protected integer $product_discount_amount;
protected string $product_discount_type;
protected integer $product_tax_amount;

Table: `sale_returns`
Properties: 'date', 'reference', 'tax_percentage', 'tax_amount', 'discount_percentage', 'discount_amount', 'shipping_amount', 'total_amount', 'paid_amount', 'due_amount', 'status', 'payment_status', 'payment_method', 'note'

Property Types:
protected date $date;
protected string $reference;
protected integer $tax_percentage;
protected integer $tax_amount;
protected integer $discount_percentage;
protected integer $discount_amount;
protected integer $shipping_amount;
protected integer $total_amount;
protected integer $paid_amount;
protected integer $due_amount;
protected string $status;
protected string $payment_status;
protected string $payment_method;
protected text $note;

Table: `sale_return_details`
Properties: 'name', 'code', 'quantity', 'price', 'unit_price', 'sub_total', 'discount_amount', 'discount_type', 'tax_amount', 'id'

Property Types:
protected string $name;
protected string $code;
protected integer $quantity;
protected integer $price;
protected integer $unit_price;
protected integer $sub_total;
protected integer $discount_amount;
protected string $discount_type;
protected integer $tax_amount;
protected foreign $id;

Table: `sale_return_payments`
Properties: 'amount', 'date', 'reference', 'payment_method', 'note'

Property Types:
protected integer $amount;
protected date $date;
protected string $reference;
protected string $payment_method;
protected text $note;

Table: `purchase_returns`
Properties: 'date', 'reference', 'tax_percentage', 'tax_amount', 'discount_percentage', 'discount_amount', 'shipping_amount', 'total_amount', 'paid_amount', 'due_amount', 'status', 'payment_status', 'payment_method', 'note'

Property Types:
protected date $date;
protected string $reference;
protected integer $tax_percentage;
protected integer $tax_amount;
protected integer $discount_percentage;
protected integer $discount_amount;
protected integer $shipping_amount;
protected integer $total_amount;
protected integer $paid_amount;
protected integer $due_amount;
protected string $status;
protected string $payment_status;
protected string $payment_method;
protected text $note;

Table: `purchase_return_details`
Properties: 'name', 'code', 'quantity', 'price', 'unit_price', 'sub_total', 'discount_amount', 'discount_type', 'tax_amount'

Property Types:
protected string $name;
protected string $code;
protected integer $quantity;
protected integer $price;
protected integer $unit_price;
protected integer $sub_total;
protected integer $discount_amount;
protected string $discount_type;
protected integer $tax_amount;

Table: `purchase_return_payments`
Properties: 'amount', 'date', 'reference', 'payment_method', 'note'

Property Types:
protected integer $amount;
protected date $date;
protected string $reference;
protected string $payment_method;
protected text $note;

Table: `quotations`
Properties: 'date', 'reference', 'tax_percentage', 'tax_amount', 'discount_percentage', 'discount_amount', 'shipping_amount', 'total_amount', 'status', 'sent_on', 'expires_on', 'note'

Property Types:
protected date $date;
protected string $reference;
protected integer $tax_percentage;
protected integer $tax_amount;
protected integer $discount_percentage;
protected integer $discount_amount;
protected integer $shipping_amount;
protected integer $total_amount;
protected string $status;
protected timestamp $sent_on;
protected timestamp $expires_on;
protected text $note;

Table: `quotation_details`
Properties: 'name', 'code', 'quantity', 'price', 'unit_price', 'sub_total', 'product_discount_amount', 'product_discount_type', 'product_tax_amount'

Property Types:
protected string $name;
protected string $code;
protected integer $quantity;
protected integer $price;
protected integer $unit_price;
protected integer $sub_total;
protected integer $product_discount_amount;
protected string $product_discount_type;
protected integer $product_tax_amount;

Table: `product_warehouse`
Properties: 'price', 'cost', 'old_price', 'qty', 'stock_alert', 'is_discount', 'discount_date'

Property Types:
protected integer $price;
protected integer $cost;
protected integer $old_price;
protected integer $qty;
protected integer $stock_alert;
protected tinyInteger $is_discount;
protected date $discount_date;

Table: `user_warehouse`
Properties: 'status'

Property Types:
protected boolean $status;

Table: `languages`
Properties: 'name', 'code', 'rtl', 'status', 'is_default'

Property Types:
protected string $name;
protected string $code;
protected boolean $rtl;
protected integer $status;
protected boolean $is_default;

Table: `media`
Properties: 'id', 'model', 'uuid', 'collection_name', 'name', 'file_name', 'mime_type', 'disk', 'conversions_disk', 'size', 'manipulations', 'custom_properties', 'generated_conversions', 'responsive_images', 'order_column'

Property Types:
protected bigIncrements $id;
protected morphs $model;
protected uuid $uuid;
protected string $collection_name;
protected string $name;
protected string $file_name;
protected string $mime_type;
protected string $disk;
protected string $conversions_disk;
protected unsignedBigInteger $size;
protected json $manipulations;
protected json $custom_properties;
protected json $generated_conversions;
protected json $responsive_images;
protected unsignedInteger $order_column;

Table: `sessions`
Properties: 'id', 'user_id', 'ip_address', 'user_agent', 'payload', 'last_activity'

Property Types:
protected string $id;
protected foreignId $user_id;
protected string $ip_address;
protected text $user_agent;
protected longText $payload;
protected integer $last_activity;

Table: `pages`
Properties: 'title', 'slug', 'description', 'image', 'type', 'meta_title', 'meta_description', 'is_sliders', 'is_contact', 'is_offer', 'is_title', 'is_description', 'status'

Property Types:
protected string $title;
protected string $slug;
protected json $description;
protected string $image;
protected string $type;
protected string $meta_title;
protected string $meta_description;
protected tinyInteger $is_sliders;
protected tinyInteger $is_contact;
protected tinyInteger $is_offer;
protected tinyInteger $is_title;
protected tinyInteger $is_description;
protected tinyInteger $status;

Table: `orderforms`
Properties: 'name', 'email', 'phone', 'address', 'type', 'status', 'subject', 'message'

Property Types:
protected string $name;
protected string $email;
protected string $phone;
protected string $address;
protected string $type;
protected tinyInteger $status;
protected string $subject;
protected string $message;

Table: `subcategories`
Properties: 'name', 'slug', 'image', 'status', 'category_id', 'language_id'

Property Types:
protected string $name;
protected string $slug;
protected string $image;
protected tinyInteger $status;
protected foreignId $category_id;
protected foreignId $language_id;

Table: `sliders`
Properties: 'subtitle', 'title', 'description', 'image', 'bg_color', 'text_color', 'featured', 'link', 'status', 'embeded_video', 'page_id', 'language_id'

Property Types:
protected string $subtitle;
protected string $title;
protected string $description;
protected string $image;
protected string $bg_color;
protected string $text_color;
protected boolean $featured;
protected string $link;
protected string $status;
protected text $embeded_video;
protected foreignId $page_id;
protected foreignId $language_id;

Table: `sections`
Properties: 'title', 'image', 'featured_title', 'subtitle', 'label', 'link', 'description', 'status', 'bg_color', 'page', 'position', 'language_id'

Property Types:
protected text $title;
protected string $image;
protected text $featured_title;
protected text $subtitle;
protected text $label;
protected string $link;
protected text $description;
protected boolean $status;
protected string $bg_color;
protected string $page;
protected string $position;
protected foreignId $language_id;
GFDL;KDHPOI
Table: `packagings`
Properties: 'title', 'subtitle', 'cost'

Property Types:
protected string $title;
protected string $subtitle;
protected decimal $cost;

Table: `featured_banners`
Properties: 'title', 'description', 'image', 'status', 'featured', 'link', 'embeded_video', 'language_id', 'product_id'

Property Types:
protected string $title;
protected text $description;
protected string $image;
protected boolean $status;
protected boolean $featured;
protected string $link;
protected text $embeded_video;
protected foreignId $language_id;
protected foreignUuid $product_id;

Table: `blog_categories`
Properties: 'title', 'description', 'status', 'featured', 'meta_title', 'meta_desc', 'language_id'

Property Types:
protected string $title;
protected text $description;
protected boolean $status;
protected boolean $featured;
protected text $meta_title;
protected text $meta_desc;
protected foreignId $language_id;

Table: `blogs`
Properties: 'title', 'details', 'image', 'slug', 'status', 'featured', 'meta_title', 'meta_desc', 'category_id', 'language_id'

Property Types:
protected string $title;
protected text $details;
protected string $image;
protected string $slug;
protected boolean $status;
protected boolean $featured;
protected text $meta_title;
protected text $meta_desc;
protected foreignId $category_id;
protected foreignId $language_id;

Table: `pagesettings`
Properties: 'header', 'footer', 'bottomBar', 'topHeader', 'bottomFooter', 'themeColor', 'popularProducts', 'flashDeal', 'bestSellers', 'topBrands', 'status', 'featured_banner_id', 'page_id', 'language_id'

Property Types:
protected string $header;
protected string $footer;
protected string $bottomBar;
protected string $topHeader;
protected string $bottomFooter;
protected boolean $themeColor;
protected boolean $popularProducts;
protected boolean $flashDeal;
protected boolean $bestSellers;
protected boolean $topBrands;
protected string $status;
protected foreignId $featured_banner_id;
protected foreignId $page_id;
protected foreignId $language_id;

Table: `shippings`
Properties: 'is_pickup', 'title', 'subtitle', 'cost', 'status'

Property Types:
protected boolean $is_pickup;
protected string $title;
protected string $subtitle;
protected decimal $cost;
protected boolean $status;

Table: `orders`
Properties: 'id', 'date', 'reference', 'shipping_id', 'packaging_id', 'tax_percentage', 'tax_amount', 'discount_percentage', 'discount_amount', 'shipping_amount', 'total_amount', 'paid_amount', 'due_amount', 'payment_date', 'status', 'payment_status', 'payment_method', 'shipping_status', 'document', 'note'

Property Types:
protected uuid $id;
protected date $date;
protected string $reference;
protected foreignId $shipping_id;
protected foreignId $packaging_id;
protected integer $tax_percentage;
protected integer $tax_amount;
protected integer $discount_percentage;
protected integer $discount_amount;
protected integer $shipping_amount;
protected integer $total_amount;
protected integer $paid_amount;
protected integer $due_amount;
protected date $payment_date;
protected string $status;
protected string $payment_status;
protected string $payment_method;
protected string $shipping_status;
protected string $document;
protected text $note;

Table: `reviews`
Properties: 'rating', 'comment', 'product_id', 'customer_id'

Property Types:
protected integer $rating;
protected text $comment;
protected foreignUuid $product_id;
protected foreignUuid $customer_id;

Table: `printers`
Properties: 'name', 'connection_type', 'capability_profile', 'char_per_line', 'ip_address', 'port', 'path'

Property Types:
protected string $name;
protected enum $connection_type;
protected enum $capability_profile;
protected string $char_per_line;
protected string $ip_address;
protected string $port;
protected string $path;

Table: `cash_registers`
Properties: 'cash_in_hand', 'status'

Property Types:
protected double $cash_in_hand;
protected boolean $status;

Table: `integrations`
Properties: 'id', 'type', 'store_url', 'api_key', 'sandbox', 'api_secret', 'last_sync', 'products', 'orders', 'status'

Property Types:
protected uuid $id;
protected integer $type;
protected string $store_url;
protected string $api_key;
protected string $sandbox;
protected string $api_secret;
protected string $last_sync;
protected string $products;
protected string $orders;
protected boolean $status;

Table: `popups`
Properties: 'name', 'width', 'background_color', 'frequency', 'timing', 'delay', 'duration', 'visits', 'content', 'cta_text', 'cta_url', 'status', 'is_default'

Property Types:
protected string $name;
protected string $width;
protected string $background_color;
protected string $frequency;
protected string $timing;
protected integer $delay;
protected integer $duration;
protected integer $visits;
protected text $content;
protected string $cta_text;
protected string $cta_url;
protected boolean $status;
protected boolean $is_default;

Table: `redirects`
Properties: 'old_url', 'new_url', 'http_status_code', 'status'

Property Types:
protected string $old_url;
protected string $new_url;
protected string $http_status_code;
protected boolean $status;

Table: `notifications`
Properties: 'id', 'type', 'notifiable', 'data', 'read_at'

Property Types:
protected uuid $id;
protected string $type;
protected morphs $notifiable;
protected text $data;
protected timestamp $read_at;

Table: `subscribers`
Properties: 'email', 'name', 'tag', 'status'

Property Types:
protected string $email;
protected string $name;
protected string $tag;
protected boolean $status;

Table: `jobs`
Properties: 'id', 'queue', 'payload', 'attempts', 'reserved_at', 'available_at', 'created_at'

Property Types:
protected bigIncrements $id;
protected string $queue;
protected longText $payload;
protected unsignedTinyInteger $attempts;
protected unsignedInteger $reserved_at;
protected unsignedInteger $available_at;
protected unsignedInteger $created_at;

Table: `transfers`
Properties: 'id', 'reference', 'from_warehouse_id', 'to_warehouse_id', 'item', 'total_qty', 'total_tax', 'total_cost', 'total_amount', 'shipping', 'document', 'status', 'note'

Property Types:
protected uuid $id;
protected string $reference;
protected integer $from_warehouse_id;
protected integer $to_warehouse_id;
protected integer $item;
protected double $total_qty;
protected double $total_tax;
protected double $total_cost;
protected double $total_amount;
protected double $shipping;
protected string $document;
protected integer $status;
protected text $note;

Table: `movements`
Properties: 'type', 'quantity', 'price', 'date', 'movable_id', 'movable_type', 'user_id'

Property Types:
protected string $type;
protected unsignedInteger $quantity;
protected decimal $price;
protected dateTime $date;
protected unsignedBigInteger $movable_id;
protected string $movable_type;
protected unsignedBigInteger $user_id;

Table: `price_histories`
Properties: 'cost', 'effective_date', 'expiry_date'

Property Types:
protected integer $cost;
protected date $effective_date;
protected date $expiry_date;

Table: `email_templates`
Properties: 'name', 'description', 'message', 'default', 'placeholders', 'type', 'subject', 'status'

Property Types:
protected string $name;
protected text $description;
protected text $message;
protected text $default;
protected json $placeholders;
protected string $type;
protected string $subject;
protected string $status;

Table: `menus`
Properties: 'name', 'label', 'url', 'type', 'placement', 'sort_order', 'parent_id', 'icon', 'new_window', 'status'

Property Types:
protected string $name;
protected string $label;
protected string $url;
protected char $type;
protected string $placement;
protected integer $sort_order;
protected integer $parent_id;
protected string $icon;
protected boolean $new_window;
protected integer $status;

Table: `queue_monitors`
Properties: 'job_id', 'name', 'queue', 'started_at', 'finished_at', 'failed', 'attempt', 'progress', 'exception_message'

Property Types:
protected string $job_id;
protected string $name;
protected string $queue;
protected timestamp $started_at;
protected timestamp $finished_at;
protected boolean $failed;
protected integer $attempt;
protected integer $progress;
protected text $exception_message;

