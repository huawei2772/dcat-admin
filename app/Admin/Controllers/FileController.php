<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Traits\HasUploadedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileController
{
    use HasUploadedFile;

    public function upload()
    {
        $disk = $this->disk();

        // 判断是否是删除文件请求
        if ($this->isDeleteRequest()) {
            // 删除文件并响应
            return $this->deleteFileAndResponse($disk);
        }

        // 获取上传的文件
        $file = $this->file();

        $dir = date('Y/m/d');
        $newName = $this->generateUniqueName($file);
        $result = $disk->putFileAs($dir, $file, $newName);
        $path = "{$dir}/$newName";

        return $result
            ? $this->responseUploaded($path, $disk->url($path))
            : $this->responseErrorMessage(trans('admin.uploader.upload_failed'));
    }

    /**
     * 生成上传文件名称
     * @param UploadedFile $file
     * @return string
     */
    protected function generateUniqueName(UploadedFile $file): string
    {
        return md5(uniqid()) . '.' . $file->getClientOriginalExtension();
    }
}