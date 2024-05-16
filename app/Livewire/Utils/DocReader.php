<?php

declare(strict_types=1);

namespace App\Livewire\Utils;

use Livewire\Component;
use App\Services\OpenAi;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Exception;

class DocReader extends Component
{
    use WithFileUploads;

    public $openAi;

    public $context;
    public $docModal = false;

    #[Validate('required', 'file', 'mimes:pdf')]
    public $doc;

    #[On('docModal')]
    public function docReaderModal()
    {
        $this->docModal = true;
    }

    public function generate()
    {
        $this->validate();

        $text = $this->extractTextFromPdf($this->doc->getRealPath());

        dd($text);

        $this->generatePrompt($text);
    }

    private function extractTextFromPdf($pdfFile): string
    {
        try {
            $parser = new \Smalot\PdfParser\Parser();
            $parsed = $parser->parseFile($pdfFile);
            dd($parsed->getPages()[0]);

            return $parsed->getText();
        } catch (Exception $e) {
            // Handle PDF parsing errors
            // Log or display an error message as needed
            throw $e;
        }
    }

    private function generatePrompt($context): string
    {        // Modify this based on how your OpenAi service is structured
        $prompt = 'You need to carry out data extraction from a given receipt and transform it into a structured JSON format. The data points you are required to extract include:';

        $prompt .= '- Order Reference (orderRef)';
        $prompt .= '- Purchase Date (date): make sure it aligns with the ISO-8601 format YEAR-MONTH-DAY';
        $prompt .= '- Tax Cost (taxAmount)';
        $prompt .= '- Transaction Total Cost (totalAmount)';
        $prompt .= '- Currency Used (currency)';
        $prompt .= '- Supplier Details (name, phone, address): Use Supplier as the model';
        $prompt .= "- Line items (text, qty, price, sku): Note, the 'qty' is typically 1 or minimal and the 'price' should be a number, excluding the currency element and should use a period as a decimal separator. The price data point must not be null, use lineItems as the key";

        $prompt .= 'In a situation where there are no suitable values for any of the above information, kindly set the value as null in your response. Remember, your final output should adhere to the neat, hierarchical structure of JSON.';

        $prompt .= "$context";

        $prompt .= 'OUTPUT IN JSON';

        $this->openAi = OpenAi::execute($prompt, 2000);
    }

    public function normalized(string $text): string
    {
        return Str::of($text)->squish()->trim()->toString();
    }

    public function render()
    {
        return view('livewire.utils.doc-reader');
    }
}
