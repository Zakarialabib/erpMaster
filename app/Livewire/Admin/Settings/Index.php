<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Settings;

use App\Models\Currency;
use App\Models\Customer;
use App\Models\Settings;
use App\Models\Warehouse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Support\Str;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $settings;

    /** @var array<string> */
    public $listeners = ['update'];

    public $listsForFields = [];

    public $invoice_header;

    public $invoice_footer;

    public $image;

    public $site_logo;
    public $site_title;
    public $social_facebook;
    public $social_twitter;
    public $social_instagram;
    public $social_linkedin;
    public $social_whatsapp;
    public $siteImage;

    public $favicon;

    #[Rule('required|string|min:1|max:255')]
    public $company_name;

    #[Rule('required|string|min:1|max:255')]
    public $company_email;

    #[Rule('required|string|min:1|max:255')]
    public $company_phone;
    public $company_logo;

    #[Rule('required|string|min:1|max:255')]
    public $company_address;

    #[Rule('nullable|string|min:0|max:255')]
    public $company_tax;

    #[Rule('nullable|string|min:0|max:255')]
    public $telegram_channel;

    #[Rule('required|integer|min:0|max:192')]
    public $default_currency_id;

    #[Rule('required|string|min:1|max:255')]
    public $default_currency_position;

    #[Rule('required|string|min:1|max:255')]
    public $default_date_format;

    #[Rule('nullable')]
    public $default_client_id;

    #[Rule('nullable')]
    public $default_warehouse_id;

    #[Rule('required|string|min:1|max:255')]
    public $default_language;

    public $invoice_footer_text;

    public $sale_prefix;

    public $saleReturn_prefix;

    public $purchase_prefix;

    public $purchaseReturn_prefix;

    public $quotation_prefix;

    public $salePayment_prefix;

    public $purchasePayment_prefix;

    public $is_rtl;

    public $show_email;

    public $show_address;

    public $show_order_tax;

    public $show_discount;

    public $show_shipping;

    public function render()
    {
        return view('livewire.admin.settings.index');
    }

    public function mount(): void
    {
        abort_if(Gate::denies('setting access'), 403);

        $this->site_logo = settings('site_logo');
        $this->site_title = settings('site_title');
        $this->favicon = settings('site_favicon');
        $this->company_name = settings('company_name');
        $this->company_email = settings('company_email');
        $this->company_phone = settings('company_phone');
        $this->company_logo = settings('company_logo');
        $this->company_address = settings('company_address');
        $this->company_tax = settings('company_tax');
        $this->telegram_channel = settings('telegram_channel');
        $this->default_currency_id = settings('default_currency_id');
        $this->default_currency_position = settings('default_currency_position');
        $this->default_date_format = settings('default_date_format');
        $this->default_client_id = settings('default_client_id');
        $this->default_warehouse_id = settings('default_warehouse_id');
        $this->default_language = settings('default_language');
        $this->invoice_footer_text = settings('invoice_footer_text');
        $this->sale_prefix = settings('sale_prefix');
        $this->saleReturn_prefix = settings('saleReturn_prefix');
        $this->purchase_prefix = settings('purchase_prefix');
        $this->purchaseReturn_prefix = settings('purchaseReturn_prefix');
        $this->quotation_prefix = settings('quotation_prefix');
        $this->salePayment_prefix = settings('salePayment_prefix');
        $this->purchasePayment_prefix = settings('purchasePayment_prefix');
        $this->is_rtl = settings('is_rtl');
        $this->show_email = settings('show_email');
        $this->show_address = settings('show_address');
        $this->show_order_tax = settings('show_order_tax');
        $this->show_discount = settings('show_discount');
        $this->show_shipping = settings('show_shipping');
        $this->social_facebook = settings('social_facebook');
        $this->social_twitter = settings('social_twitter');
        $this->social_instagram = settings('social_instagram');
        $this->social_linkedin = settings('social_linkedin');
        $this->social_whatsapp = settings('social_whatsapp');

        $this->initListsForFields();
    }

    public function update(): void
    {
        $this->validate();

        if ($this->company_logo) {
            $imageName = Str::slug($this->company_name) . '.' . $this->company_logo->extension();
            $this->company_logo->storeAs('uploads', $imageName, 'public');
            $this->company_logo = $imageName;
        }

        if ($this->invoice_header) {
            $imageName = 'invoice-header';
            Storage::put('uploads', $imageName, 'public');
                $this->createHTMLfile($this->invoice_header, $imageName);
            $this->invoice_header = $imageName;
        }

        if ($this->invoice_footer) {
            $imageName = 'invoice-footer';
            Storage::put('uploads', $imageName, 'public');
            $this->createHTMLfile($this->invoice_footer, $imageName);
            $this->invoice_footer = $imageName;
        }

        if ($this->site_logo) {
            $imageName = 'site-logo';
            $this->site_logo->storeAs('uploads', $imageName, 'public');
            $this->site_logo = $imageName;
        }

        if ($this->favicon) {
            $imageName = 'favicon';
            $this->favicon->storeAs('uploads', $imageName, 'public');
            $this->favicon = $imageName;
        }

        Settings::set('site_logo', $this->site_logo);
        Settings::set('site_title', $this->site_title);
        Settings::set('site_favicon', $this->favicon);
        Settings::set('company_name', $this->company_name);
        Settings::set('company_email', $this->company_email);
        Settings::set('company_phone', $this->company_phone);
        Settings::set('company_logo', $this->company_logo);
        Settings::set('company_address', $this->company_address);
        Settings::set('company_tax', $this->company_tax);
        Settings::set('telegram_channel', $this->telegram_channel);
        Settings::set('default_currency_id', $this->default_currency_id);
        Settings::set('default_currency_position', $this->default_currency_position);
        Settings::set('default_date_format', $this->default_date_format);
        Settings::set('default_client_id', $this->default_client_id);
        Settings::set('default_warehouse_id', $this->default_warehouse_id);
        Settings::set('default_language', $this->default_language);
        Settings::set('invoice_footer_text', $this->invoice_footer_text);
        Settings::set('sale_prefix', $this->sale_prefix);
        Settings::set('saleReturn_prefix', $this->saleReturn_prefix);
        Settings::set('purchase_prefix', $this->purchase_prefix);
        Settings::set('purchaseReturn_prefix', $this->purchaseReturn_prefix);
        Settings::set('quotation_prefix', $this->quotation_prefix);
        Settings::set('salePayment_prefix', $this->salePayment_prefix);
        Settings::set('purchasePayment_prefix', $this->purchasePayment_prefix);
        Settings::set('is_rtl', $this->is_rtl);
        Settings::set('show_email', $this->show_email);
        Settings::set('show_address', $this->show_address);
        Settings::set('show_order_tax', $this->show_order_tax);
        Settings::set('show_discount', $this->show_discount);
        Settings::set('show_shipping', $this->show_shipping);
        Settings::set('social_facebook', $this->social_facebook);
        Settings::set('social_twitter', $this->social_twitter);
        Settings::set('social_instagram', $this->social_instagram);
        Settings::set('social_linkedin', $this->social_linkedin);
        Settings::set('social_whatsapp', $this->social_whatsapp);


        cache()->forget('settings');

        $this->alert('success', __('Settings Updated successfully !'));
    }

    protected function createHTMLfile($file, string $name): string
    {
        $extension = $file->extension();
        $data = File::get($file->getRealPath());
        $base64 = 'data:image/' . $extension . ';base64,' . base64_encode($data);

        $html = sprintf(
            '<div><img style="width: 100%%; display: block;" src="%s"></div>',
            $base64
        );

        $path = public_path('print/' . $name . '.html');
        File::put($path, $html);

        return $base64;
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['currencies'] = Currency::pluck('name', 'id')->toArray();
        $this->listsForFields['warehouses'] = Warehouse::pluck('name', 'id')->toArray();
        $this->listsForFields['customers'] = Customer::pluck('name', 'id')->toArray();
    }
}
