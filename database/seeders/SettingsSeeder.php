<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /** @var array */
    protected $settings = [
        [
            'key'   => 'company_name',
            'value' => 'ERPMASTER',
        ],
        [
            'key'   => 'site_title',
            'value' => 'ERPMASTER',
        ],
        [
            'key'   => 'company_email',
            'value' => 'connect@zakarialabib.com',
        ],
        [
            'key'   => 'company_phone',
            'value' => '+212638041919',
        ],
        [
            'key'   => 'company_address',
            'value' => 'Casablanca, Maroc',
        ],
        [
            'key'   => 'company_tax',
            'value' => '',
        ],
        [
            'key'   => 'site_logo',
            'value' => 'logo.png',
        ],
        [
            'key'   => 'site_favicon',
            'value' => '',
        ],
        [
            'key'   => 'seo_meta_title',
            'value' => 'ERPMASTER',
        ],
        [
            'key'   => 'seo_meta_description',
            'value' => 'ERPMASTER',
        ],
        [
            'key'   => 'social_facebook',
            'value' => '#',
        ],
        [
            'key'   => 'social_twitter',
            'value' => '#',
        ],
        [
            'key'   => 'social_tiktok',
            'value' => '#',
        ],
        [
            'key'   => 'social_instagram',
            'value' => '#',
        ],
        [
            'key'   => 'social_linkedin',
            'value' => '#',
        ],
        [
            'key'   => 'social_whatsapp',
            'value' => '#',
        ],
        [
            'key'   => 'head_tags',
            'value' => '',
        ],
        [
            'key'   => 'body_tags',
            'value' => '',
        ],
        [
            'key'   => 'whatsapp_custom_message',
            'value' => '',
        ],
        [
            'key'   => 'site_maintenance_message',
            'value' => 'Site is under maintenance',
        ],
        [
            'key'   => 'site_maintenance_status',
            'value' => false,
        ],
        [
            'key'   => 'telegram_channel',
            'value' => '',
        ],
        [
            'key'   => 'default_currency_id',
            'value' => 1,
        ],
        [
            'key'   => 'default_currency_position',
            'value' => 'right',
        ],
        [
            'key'   => 'default_date_format',
            'value' => 'd-m-Y',
        ],
        [
            'key'   => 'default_client_id',
            'value' => '1',
        ],
        [
            'key'   => 'default_warehouse_id',
            'value' => null,
        ],
        [
            'key'   => 'multi_language',
            'value' => true,
        ],
        [
            'key'   => 'invoice_header',
            'value' => '',
        ],
        [
            'key'   => 'invoice_footer',
            'value' => '',
        ],
        [
            'key'   => 'invoice_footer_text',
            'value' => 'Thank you for your business',
        ],
        [
            'key'   => 'is_rtl',
            'value' => '1',
        ],
        [
            'key'   => 'sale_prefix',
            'value' => 'SA-000',
        ],
        [
            'key'   => 'saleReturn_prefix',
            'value' => 'SRE-000',
        ],
        [
            'key'   => 'purchase_prefix',
            'value' => 'PR-000',
        ],
        [
            'key'   => 'purchaseReturn_prefix',
            'value' => 'PRE-000',
        ],
        [
            'key'   => 'quotation_prefix',
            'value' => 'QU-000',
        ],
        [
            'key'   => 'salePayment_prefix',
            'value' => 'SP-000',
        ],
        [
            'key'   => 'purchasePayment_prefix',
            'value' => 'PP-000',
        ],
        [
            'key'   => 'expense_prefix',
            'value' => 'exp-000',
        ],
        [
            'key'   => 'delivery_prefix',
            'value' => 'del-000',
        ],
        [
            'key'   => 'show_email',
            'value' => '1',
        ],
        [
            'key'   => 'show_address',
            'value' => '1',
        ],
        [
            'key'   => 'show_order_tax',
            'value' => '1',
        ],
        [
            'key'   => 'show_discount',
            'value' => '1',
        ],
        [
            'key'   => 'show_shipping',
            'value' => '1',
        ],
        [
            'key'   => 'backup_status',
            'value' => false,
        ],
        [
            'key'   => 'backup_schedule',
            'value' => 2,
        ],
        [
            'key'   => 'backup_content',
            'value' => '',
        ],
        [
            'key'   => 'invoice_template',
            'value' => 'invoice-1',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $index => $setting) {
            $result = Settings::create($setting);

            if ( ! $result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }
        $this->command->info('Inserted '.count($this->settings).' records');
    }
}
