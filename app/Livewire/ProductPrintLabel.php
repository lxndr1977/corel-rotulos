<?php
namespace App\Livewire;

use Livewire\Component;

use App\Services\BarcodeService;


class ProductPrintLabel extends Component
{
    public $product;
    public $batch;
    public $product_variation;
    public $selectedBatch;  
    public $selectedVariation;  
    public $start_at_position = 1;
    public $total_labels = 1;

    protected $barcodeService;

    public function __construct()
    {
        $this->barcodeService = app(BarcodeService::class);
    }

    public function mount($product = null)
    {
        $this->product = $product;
        $this->updatedTotalLabels();
    }

 public function render()
    {
        return view('livewire.product-print-label', [
            'products' => $this->product
        ]);
    }

    public function updatedBatch()
    {
        $this->getBatch();
    }

    public function handleTotalLabelsBlur()
    {
        // Não precisa de lógica aqui a não ser que queira adicionar algo
        // específico para quando o campo de labels perde o foco.
    }

    public function updatedTotalLabels()
    {
        // Apenas atualiza a visualização, não chama getBatch()
        // Você pode adicionar lógica adicional aqui se necessário.
    }

    public function getBatch() {
        if ($this->product && $this->product->batches) {
            $this->selectedBatch = $this->product->batches->firstWhere('id', $this->batch);
        } else {
            $this->selectedBatch = null;
        }
    }


    public function getVariation() {
        if ($this->product && $this->product->variations) {
            $this->selectedVariation = $this->product->variations->firstWhere('id', $this->product_variation);
        } else {
            $this->selectedVariation = null;
        }
    }

    public function updateBatch($newValue)
    {
        $this->batch = $newValue;
    }

    public function getBarcode($gtin)
    {
        try {
            // Gera o código de barras como Base64
            return $this->barcodeService->generate($gtin, 'ean13', 2, 50, true);
        } catch (\Exception $e) {
            // Retorna uma imagem placeholder em caso de erro
            return 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/placeholder.png')));
        }
    }
}
