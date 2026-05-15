<?php

namespace App\Admin\Traits;

use Illuminate\Support\Str;

trait Setup
{
    public function uniqidReal($lenght = 13)
    {
        // uniqid gives 13 chars, but you could adjust it to your needs.
        return uniqid_real($lenght);
    }

    public function createCodeUser()
    {
        return 'U' . $this->uniqidReal(5) . time();
    }
    public function createAffiliateCode()
    {
        return 'AF' . $this->uniqidReal(2) . time();
    }
    public function createCodeOrder()
    {
        return 'HD' . $this->uniqidReal(5) . time();
    }

    public function createCodeSKU()
    {
        return 'SKU' . $this->uniqidReal(5) . time();
    }
    public function createCodePayment()
    {
        return 'P' . $this->uniqidReal(5) . time();
    }

    public function folderUploadFileForUser($path = '/')
    {
        $path = $path == '/' ? '/' : '/' . Str::finish($path, '/');

        return 'users/' . auth()->user()->id . $path;
    }

    public function generateTokenGetPassword()
    {
        return (string) Str::uuid() . '-' . time();
    }
}
