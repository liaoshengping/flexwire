<?php

namespace Liaosp\Flexwire\Http\Form;

use App\Models\Code;
use Illuminate\Support\Carbon;
use Liaosp\Flexwire\Services\Form;
use Liaosp\Flexwire\Services\ToolService;

class CodeValidateForm extends Form
{
    protected $type = 'form';


    public function handle()
    {
        $code = request()->input('code');
        /**
         * @var Code $codeObj
         */
        $codeObj = Code::query()->where('code',$code)->first();
        if (!$codeObj){
            return $this->fail('不存在该激活码，或已过期');
        }
        if (!$codeObj->pc_uuid){
            return $this->fail('已重置，或未激活，请勿重复重置');
        }
        if ($codeObj->status == Code::STATUS_UNACTIVE && !$codeObj->ex_at){
            return $this->fail('失败，未激活');
        }
        if ($codeObj->ex_at < Carbon::now()){
            return $this->fail('已过期');
        }

        $codeObj->ex_at = Carbon::parse($codeObj->ex_at)->subHours(24);
        $codeObj->pc_uuid = '';
        $codeObj->save();

        return  $this->success('操作成功，过期时间为：'.$codeObj->ex_at);

    }

    public function form()
    {
        $this->text('code', '激活码','');
        $this->submit('重置激活码');
    }

    public function confirm()
    {
        return '重置激活码减少1天有效期';
    }

    public function render()
    {
        $this->form();
        return [
            'class' => (new ToolService())->encode(get_class($this)),
            'class_name' => basename(str_replace('\\', '/', __CLASS__)),
            'form' => $this->content,
            'confirm' => $this->confirm(),
        ];
    }
}