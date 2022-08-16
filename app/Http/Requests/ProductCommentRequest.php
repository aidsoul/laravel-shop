<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @author aidsoul <work-aidsoul@outlook.com>
 */
class ProductCommentRequest extends FormRequest {

    protected $entity = [
        'name' => 'brand',
        'table' => 'brands'
    ];
    
    public function authorize() {
        return true;
    }

    public function rules() {
        switch ($this->method()) {
            case 'POST':
                return $this->createItem();
            case 'PUT':
            case 'PATCH':
                // $rules = $this->updateItem();
                // return $rules;
        }
    }
}