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
    ];

    public static function message($code)
    {
        $self = new static;
        return (isset($self->errorCodes[$code])) ? $self->errorCodes[$code] : '未知錯誤訊息';
    }
}
