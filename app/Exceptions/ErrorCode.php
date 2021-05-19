<?php
namespace App\Exceptions;

class ErrorCode
{
    /**
     * A list of the exception types.
     *
     * @var array
     */
    protected $errorCodes = [
        'E0001' => '傳送參數錯誤',
        'E0002' => '新增失敗',
        'E0003' => '無更新任何資料',
        'E0004' => '藥局ID不存在',
        'E0005' => '口罩ID不存在',
        'E0006' => '顧客ID不存在',
        'E0007' => '此藥局並無販售此口罩',
        'E0008' => '口罩庫存不足',
        'E0009' => '顧客持有金額不足',
    ];

    public static function message($code)
    {
        $self = new static;
        return (isset($self->errorCodes[$code])) ? $self->errorCodes[$code] : '未知錯誤訊息';
    }
}
