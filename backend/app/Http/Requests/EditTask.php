<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateTask;

class EditTask extends CreateTask
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // 親クラス（FormRequest）のrules()を代入し、インスタンスを作る
        $rule = parent::rules();

        // TaskクラスのSTATUS定数の配列をルールクラスのin()を用いて代入
        $status_rule = Rule::in(array_keys(Task::STATUS));
    
        return $rule + [
            'status' => 'required|' . $status_rule,
        ];
    }

    public function attributes()
    {

        $attributes = parent::attributes();

        return $attributes + [
            'status' => '状態',
        ];
    }

    public function messges()
    {
        $messages = parent::message();

        $status_labels = array_map(function($item){
            return $item['label'];
        }, Task::STATUS);

        $status_labels = implode('、'. $status_labels);

        return $messages + [
            'status.in' => ':attribute には ' . $status_labels. ' のいずれかを指定してください。',
        ];
    }
}
